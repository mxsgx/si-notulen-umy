<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudyRequest;
use App\Study;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    /**
     * Menampilkan daftar program studi.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Study::class);

        $query = Study::query();

        if ($request->has('cari')) {
            $keyword = $request->get('cari');
            $query->where('name', 'LIKE', "%$keyword%");
        }

        $studies = $query->paginate();

        return view('study.index', compact('studies'));
    }

    public function create()
    {
        $this->authorize('create', Study::class);

        return view('study.create');
    }

    public function store(StudyRequest $request)
    {
        $this->authorize('create', Study::class);

        $data = $request->validated();
        $study = Study::create($data);

        if ($study) {
            return redirect()->route('study.edit', compact('study'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menambahkan program studi baru.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menambahkan program studi baru.'),
            ]);
        }
    }

    public function edit(Study $study)
    {
        $this->authorize('update', $study);

        return view('study.edit', compact('study'));
    }

    public function update(StudyRequest $request, Study $study)
    {
        $this->authorize('update', $study);

        $data = $request->validated();

        if ($study->update($data)) {
            return redirect()->route('study.edit', compact('study'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil mengubah data program studi.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal mengubah data program studi.'),
            ]);
        }
    }

    public function delete(Study $study)
    {
        $this->authorize('forceDelete', $study);

        if ($study->forceDelete()) {
            return redirect()->route('study.index')->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menghapus program studi.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menghapus data program studi.'),
            ]);
        }
    }
}
