<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\Http\Requests\FacultyRequest;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Menampilkan daftar fakultas.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Faculty::class);

        $query = Faculty::query();

        if ($request->has('cari')) {
            $keyword = $request->get('cari');
            $query->where('name', 'LIKE', "%$keyword%");
        }

        $faculties = $query->paginate();

        return view('faculty.index', compact('faculties'));
    }

    /**
     * Menampilkan form untuk penambahan fakultas.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Faculty::class);

        return view('faculty.create');
    }

    /**
     * Menyimpan data fakultas ke database.
     *
     * @param FacultyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(FacultyRequest $request)
    {
        $this->authorize('create', Faculty::class);

        $data = $request->validated();
        $faculty = Faculty::create($data);

        if ($faculty) {
            return redirect()->route('faculty.edit', compact('faculty'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menambahkan fakultas baru.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menambahkan fakultas baru.'),
            ]);
        }
    }

    /**
     * Menampilkan form untuk mengubah data fakultas.
     *
     * @param Faculty $faculty
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Faculty $faculty)
    {
        $this->authorize('update', $faculty);

        return view('faculty.edit', compact('faculty'));
    }

    /**
     * Menyimpan perubahan data fakultas ke database.
     *
     * @param FacultyRequest $request
     * @param Faculty        $faculty
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(FacultyRequest $request, Faculty $faculty)
    {
        $this->authorize('update', $faculty);

        $data = $request->validated();

        if ($faculty->update($data)) {
            return redirect()->route('faculty.edit', compact('faculty'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil mengubah data fakultas.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal mengubah data fakultas.'),
            ]);
        }
    }

    /**
     * Menghapus fakultas dari database.
     *
     * @param Faculty $faculty
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Faculty $faculty)
    {
        $this->authorize('forceDelete', $faculty);
        $faculty->studies->each(function ($study) {
            $study->forceDelete();
        });

        if ($faculty->forceDelete()) {
            return redirect()->route('faculty.index')->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menghapus data fakultas.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menghapus data fakultas.'),
            ]);
        }
    }
}
