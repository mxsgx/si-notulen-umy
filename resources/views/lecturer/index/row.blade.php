<tr>
    <td>{{ $lecturer->name }}</td>
    <td>
        <a href="{{ route('lecturer.delete', compact('lecturer')) }}" class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#delete">{{ __('Hapus') }}</a>
        <a href="{{ route('lecturer.edit', compact('lecturer')) }}" class="btn btn-sm btn-success m-1">{{ __('Sunting') }}</a>
    </td>
</tr>
