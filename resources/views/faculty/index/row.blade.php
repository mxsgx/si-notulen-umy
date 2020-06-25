<tr>
    <td>{{ $faculty->name }}</td>
    <td>
        <a href="{{ route('faculty.delete', compact('faculty')) }}" class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#delete">{{ __('Hapus') }}</a>
        <a href="{{ route('faculty.edit', compact('faculty')) }}" class="btn btn-sm btn-success m-1">{{ __('Sunting') }}</a>
    </td>
</tr>
