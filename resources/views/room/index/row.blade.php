<tr>
    <td>{{ $room->name }}</td>
    <td>
        <a href="{{ route('room.delete', compact('room')) }}" class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#delete">{{ __('Hapus') }}</a>
        <a href="{{ route('room.edit', compact('room')) }}" class="btn btn-sm btn-success m-1">{{ __('Sunting') }}</a>
    </td>
</tr>
