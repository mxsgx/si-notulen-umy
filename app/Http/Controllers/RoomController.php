<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Menampilkan daftar ruangan.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Room::class);

        $query = Room::query();

        if ($request->has('cari')) {
            $keyword = $request->get('cari');
            $query->where('name', 'LIKE', "%$keyword%");
        }

        $query->orderBy('name');

        $rooms = $query->paginate();

        return view('room.index', compact('rooms'));
    }

    /**
     * Menampilkan form untuk menambahkan ruangan.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Room::class);

        return view('room.create');
    }

    /**
     * Menyimpan data ruangan ke database.
     *
     * @param RoomRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(RoomRequest $request)
    {
        $this->authorize('create', Room::class);

        $data = $request->validated();
        $room = Room::create($data);

        if ($room) {
            return redirect()->route('room.edit', compact('room'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menambahkan ruangan baru.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menambahkan ruangan baru.'),
            ]);
        }
    }

    /**
     * Menampilkan form untuk mengubah data ruangan.
     *
     * @param Room $room
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Room $room)
    {
        $this->authorize('update', $room);

        return view('room.edit', compact('room'));
    }

    /**
     * Menyimpan perubahan data ruangan ke database.
     *
     * @param RoomRequest $request
     * @param Room        $room
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(RoomRequest $request, Room $room)
    {
        $this->authorize('update', $room);

        $data = $request->validated();

        if ($room->update($data)) {
            return redirect()->route('room.edit', compact('room'))->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil mengubah data ruangan.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal mengubah data ruangan.'),
            ]);
        }
    }

    /**
     * Menghapus data ruangan dari database.
     *
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Room $room)
    {
        $this->authorize('forceDelete', $room);

        if ($room->forceDelete()) {
            return redirect()->route('room.index')->with('notice', [
                'type' => 'success',
                'dismissible' => true,
                'content' => __('Berhasil menghapus data ruangan.'),
            ]);
        } else {
            return redirect()->back()->with('notice', [
                'type' => 'danger',
                'dismissible' => true,
                'content' => __('Gagal menghapus data ruangan.'),
            ]);
        }
    }
}
