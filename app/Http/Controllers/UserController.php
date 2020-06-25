<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan pengguna yang terdaftar.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::query();

        if ($request->has('cari')) {
            $keyword = $request->get('cari');
            $query->where('name', 'LIKE', "%$keyword%")->orWhere('email', 'LIKE', "%$keyword%");
        }

        $users = $query->paginate();

        return view('user.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('user.create');
    }

    /**
     * Menyimpan data pengguna yang dibuat ke database.
     *
     * @param StoreUser $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreUser $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validated();
        $data['password'] = \Hash::make($data['password']);
        $user = User::create($data);

        if ($user) {
            return redirect()->route('user.edit', compact('user'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil membuat pengguna baru.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal membuat pengguna baru.'),
            ]);
        }
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('user.edit', compact('user'));
    }

    /**
     * Menyimpan data pengguna yang diubah ke database.
     *
     * @param UpdateUser $request
     * @param User       $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateUser $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = \Hash::make($data['password']);
        }

        if ($data['role'] === 'super-admin') {
            $data['study_id'] = null;
        }

        if ($user->update($data)) {
            return redirect()->route('user.edit', compact('user'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil memperbarui data pengguna.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal memperbarui data pengguna.'),
            ]);
        }
    }

    /**
     * Menghapus data pengguna dari database.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(User $user)
    {
        $this->authorize('forceDelete', $user);

        if ($user->forceDelete()) {
            return redirect()->route('user.index')->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menghapus pengguna.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menghapus pengguna.'),
            ]);
        }
    }
}
