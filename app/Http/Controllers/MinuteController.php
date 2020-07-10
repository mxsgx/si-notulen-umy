<?php

namespace App\Http\Controllers;

use App\Document;
use App\Http\Requests\StoreMinute;
use App\Http\Requests\UpdateMinute;
use App\Minute;
use App\Present;
use File;
use Hash;
use Illuminate\Http\Request;
use PDF;

class MinuteController extends Controller
{
    /**
     * Menampilkan daftar notulen.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Minute::class);

        $query = Minute::query();
        $fragments = [];

        if ($request->has('cari')) {
            $keyword = $request->get('cari');
            $query->where('agenda', 'LIKE', "%$keyword%");
            $fragments['cari'] = $keyword;
        }

        if (auth()->user()->role === 'admin') {
            $query->where('study_id', '=', auth()->user()->study_id);
        }

        $query->orderByDesc('meeting_date');

        $minutes = $query->paginate()->appends($fragments);

        return view('minute.index', compact('minutes'));
    }

    /**
     * Menampilkan form untuk membuat notulen.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Minute::class);

        return view('minute.create');
    }

    /**
     * Menyimpan data notulen ke database.
     *
     * @param StoreMinute $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreMinute $request)
    {
        $this->authorize('create', Minute::class);

        $data = collect($request->validated());
        $minute = Minute::create($data->except(['presents', 'attachments'])->toArray());

        if ($data->has('presents')) {
            $presents = $data->get('presents');

            foreach ($presents as $present) {
                Present::create([
                    'minute_id' => $minute->id,
                    'lecturer_id' => $present
                ]);
            }
        }

        if ($data->has('attachments')) {
            $attachments = $data->get('attachments');

            $this->attachment($attachments, $minute);
        }

        if ($minute) {
            return redirect()->route('minute.edit', compact('minute'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menambahkan notulen baru.'),
            ]);
        }

        return redirect()->back()->with('notice', [
            'type' => 'danger',
            'dismissible' => true,
            'content' => __('Gagal menambahkan notulen baru.'),
        ]);
    }

    /**
     * Memproses lampiran dan disimpan ke server.
     *
     * @param array  $attachments
     * @param Minute $minute
     */
    private function attachment($attachments, Minute $minute)
    {
        foreach ($attachments as $attachment) {
            $originalName = $attachment->getClientOriginalName();
            $fileName = hash('sha256', Hash::make($originalName)) . '.' . $attachment->getClientOriginalExtension();

            $attachment->move(storage_path('documents'), $fileName);

            Document::create([
                'name' => $originalName,
                'file_name' => $fileName,
                'minute_id' => $minute->id
            ]);
        }
    }

    /**
     * Menampilkan form untuk mengubah data notulen.
     *
     * @param Minute $minute
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Minute $minute)
    {
        $this->authorize('update', $minute);

        return view('minute.edit', compact('minute'));
    }

    /**
     * Menyimpan perubahan data pada notulen ke database.
     *
     * @param UpdateMinute $request
     * @param Minute       $minute
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateMinute $request, Minute $minute)
    {
        $this->authorize('update', $minute);

        $data = collect($request->validated());

        if ($data->has('presents')) {
            $existedPresents = $minute->presents->map(function ($present) {
                return (string)$present->lecturer_id;
            })->toArray();
            $incomingPresents = $data->get('presents');

            collect($incomingPresents)
                ->diff($existedPresents)
                ->each(function ($id) use ($minute) {
                    Present::create([
                        'minute_id' => $minute->id,
                        'lecturer_id' => $id
                    ]);
                });

            collect($existedPresents)
                ->diff($incomingPresents)
                ->each(function ($id) use ($minute) {
                    $query = Present::query();
                    $query->where('minute_id', '=', $minute->id)
                        ->where('lecturer_id', '=', $id);

                    optional(
                        $query->first(), function ($present) {
                        $present->forceDelete();
                    });
                });
        }

        if ($data->has('attachments')) {
            $attachments = $data->get('attachments');

            $this->attachment($attachments, $minute);
        }

        if ($data->has('delete_attachments')) {
            $deletedAttachments = $data->get('delete_attachments');

            foreach ($deletedAttachments as $id) {
                optional(Document::find($id), function ($document) {
                    $filePath = storage_path('documents/' . $document->file_name);
                    if (File::exists($filePath) && File::delete($filePath)) {
                        $document->forceDelete();
                    }
                });
            }
        }

        if ($minute->update($data->except(['presents', 'attachments', 'delete_attachments'])->toArray())) {
            return redirect()->route('minute.edit', compact('minute'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil mengubah data notulen.'),
            ]);
        }

        return redirect()->back()->with('notice', [
            'type' => 'danger',
            'dismissible' => true,
            'content' => __('Gagal mengubah data notulen.'),
        ]);
    }

    /**
     * Menampilkan hasil rapat yang ditulis dalam bentuk PDF.
     *
     * @param Minute $minute
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function pdf(Minute $minute)
    {
        $this->authorize('view', $minute);

        return PDF::loadView('minute.pdf', compact('minute'))->stream();
    }

    /**
     * Menampilkan lampiran jika file berjenis PDF atau Gambar selain
     * itu akan otomatis didownload.
     *
     * @param Minute   $minute
     * @param Document $document
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function document(Minute $minute, Document $document)
    {
        $this->authorize('view', $minute);

        $filePath = storage_path('documents/' . $document->file_name);

        if (File::exists($filePath)) {
            $ext = File::extension($filePath);

            if (in_array($ext, ['pdf', 'png', 'jpeg', 'jpg'])) {
                return response()->file($filePath, [
                    'filename' => $document->name
                ]);
            }

            return response()->download($filePath, $document->name);
        }

        abort('404', __('File tidak ditemukan'));
    }

    public function delete(Minute $minute)
    {
        $this->authorize('forceDelete', $minute);

        $minute->presents->each(function ($present) {
            $present->forceDelete();
        });

        $minute->documents->each(function ($document) {
            $filePath = storage_path('documents/' . $document->file_name);
            if (File::exists($filePath) && File::delete($filePath)) {
                $document->forceDelete();
            }
        });

        if ($minute->forceDelete()) {
            return redirect()->route('minute.index')->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menghapus data notulen.'),
            ]);
        }

        return redirect()->back()->with('notice', [
            'type' => 'danger',
            'dismissible' => true,
            'content' => __('Gagal menghapus data notulen.'),
        ]);
    }
}
