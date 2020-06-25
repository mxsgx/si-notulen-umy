<tr>
    <th scope="row">{{ $user->name }}</th>
    <td>{{ $user->email }}</td>
    <td>{{ $user->role }}</td>
    <td>{{ $user->study ? $user->study->name : '-' }}</td>
    <td>
        <a href="{{ route('user.delete', compact('user')) }}" class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#delete">{{ __('Hapus') }}</a>
        <a href="{{ route('user.edit', compact('user')) }}" class="btn btn-sm btn-success m-1">{{ __('Sunting') }}</a>
    </td>
</tr>
