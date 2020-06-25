<tr>
    <td>{{ $meeting->name }}</td>
    <td>
        <a href="{{ route('meeting.delete', compact('meeting')) }}" class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#delete">{{ __('Hapus') }}</a>
        <a href="{{ route('meeting.edit', compact('meeting')) }}" class="btn btn-sm btn-success m-1">{{ __('Sunting') }}</a>
    </td>
</tr>
