<?php

namespace App\Http\Controllers;

use App\Http\Requests\LecturerRequest;
use App\Lecturer;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Menampilkan daftar dosen.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Lecturer::class);

        $query = Lecturer::query();

        if ($request->has('cari')) {
            $keyword = $request->get('cari');
            $query->where('name', 'LIKE', "%$keyword%");
        }

        $query->orderBy('name');

        $lecturers = $query->paginate();

        return view('lecturer.index', compact('lecturers'));
    }

    /**
     * Menampilkan form untuk menambahkan dosen.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Lecturer::class);

        return view('lecturer.create');
    }

    /**
     * Menyimpan data dosen ke database.
     *
     * @param LecturerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(LecturerRequest $request)
    {
        $this->authorize('create', Lecturer::class);

        $data = $request->validated();
        $lecturer = Lecturer::create($data);

        if ($lecturer) {
            return redirect()->route('lecturer.edit', compact('lecturer'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menambahkan dosen baru.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menambahkan dosen baru.'),
            ]);
        }
    }

    /**
     * Menampilkan form untuk mengubah data dosen.
     *
     * @param Lecturer $lecturer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Lecturer $lecturer)
    {
        $this->authorize('update', $lecturer);

        return view('lecturer.edit', compact('lecturer'));
    }

    /**
     * Menyimpan perubahan data dosen ke database.
     *
     * @param LecturerRequest $request
     * @param Lecturer        $lecturer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(LecturerRequest $request, Lecturer $lecturer)
    {
        $this->authorize('update', $lecturer);

        $data = $request->validated();

        if ($lecturer->update($data)) {
            return redirect()->route('lecturer.edit', compact('lecturer'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil mengubah data dosen.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal mengubah data dosen.'),
            ]);
        }
    }

    /**
     * Menghapus data dosen dari database.
     *
     * @param Lecturer $lecturer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Lecturer $lecturer)
    {
        $this->authorize('forceDelete', $lecturer);

        if ($lecturer->forceDelete()) {
            return redirect()->route('lecturer.index')->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menghapus data dosen.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menghapus data dosen.'),
            ]);
        }
    }
}
