<tr>
    <td>{{ $study->name }}</td>
    <td>{{ $study->faculty->name }}</td>
    <td>
        <a href="{{ route('study.delete', compact('study')) }}" class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#delete">{{ __('Hapus') }}</a>
        <a href="{{ route('study.edit', compact('study')) }}" class="btn btn-sm btn-success m-1">{{ __('Sunting') }}</a>
    </td>
</tr>
