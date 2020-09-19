<tr>
    <td>{{ $minute->agenda }}</td>
    <td>{{ $minute->meeting->name }}</td>
    <td>{{ $minute->meeting_date->translatedFormat('j F Y') }}</td>
    <td>{{ $minute->start_at->translatedFormat('H:i') . ' - ' . $minute->end_at->translatedFormat('H:i') }}</td>
    <td>
        @can('delete', $minute)
            <a href="{{ route('minute.delete', compact('minute')) }}" class="btn btn-sm btn-danger m-1" data-toggle="modal" data-target="#delete">{{ __('Hapus') }}</a>
        @endcan
        @can('update', $minute)
            <a href="{{ route('minute.edit', compact('minute')) }}" class="btn btn-sm btn-success m-1">{{ __('Sunting') }}</a>
        @endcan
        @if($minute->signature_minute)
            <a href="{{ route('minute.signature', compact('minute')) }}" class="btn btn-sm btn-primary m-1">{{ __('Hasil Rapat') }}</a>
        @else
            @if(auth()->user()->role === 'operator')
                <a href="{{ route('minute.pdf', compact('minute')) }}" class="btn btn-sm btn-primary m-1">{{ __('Hasil Rapat') }}</a>
            @endif
        @endif
    </td>
</tr>
