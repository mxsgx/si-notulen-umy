<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingRequest;
use App\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Menampilkan daftar jenis rapat.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Meeting::class);

        $query = Meeting::query();

        if ($request->has('cari')) {
            $keyword = $request->get('cari');
            $query->where('name', 'LIKE', "%$keyword%");
        }

        $query->orderBy('name');

        $meetings = $query->paginate();

        return view('meeting.index', compact('meetings'));
    }

    /**
     * Menampilkan form untuk menambahkan jenis rapat.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Meeting::class);

        return view('meeting.create');
    }

    /**
     * Menyimpan data jenis rapat ke database.
     *
     * @param MeetingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(MeetingRequest $request)
    {
        $this->authorize('create', Meeting::class);

        $data = $request->validated();
        $meeting = Meeting::create($data);

        if ($meeting) {
            return redirect()->route('meeting.edit', compact('meeting'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menambahkan jenis rapat baru.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menambahkan jenis rapat baru.'),
            ]);
        }
    }

    /**
     * Menampilkan form untuk mengubah data jenis rapat.
     *
     * @param Meeting $meeting
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        return view('meeting.edit', compact('meeting'));
    }

    /**
     * Menyimpan perubahan data jenis rapat ke database.
     *
     * @param MeetingRequest $request
     * @param Meeting        $meeting
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(MeetingRequest $request, Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        $data = $request->validated();

        if ($meeting->update($data)) {
            return redirect()->route('meeting.edit', compact('meeting'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil mengubah data jenis rapat.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal mengubah data jenis rapat.'),
            ]);
        }
    }

    /**
     * Menghapus data jenis rapat dari database.
     *
     * @param Meeting $meeting
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Meeting $meeting)
    {
        $this->authorize('forceDelete', $meeting);

        if ($meeting->forceDelete()) {
            return redirect()->route('meeting.index')->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menghapus data jenis rapat.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menghapus data jenis rapat.'),
            ]);
        }
    }
}
