<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog {{ $classes }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title ?? __('Konfirmasi') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $message ?? __('Anda yakin ingin melanjutkan?') }}
            </div>
            @if($type === 'form')
                <form class="modal-footer" action="{{ $action ?? '#' }}" method="post">
                    @method($method ?? 'POST')
                    @csrf
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Batal') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Ya') }}</button>
                </form>
            @else
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Batal') }}</button>
                    <button type="button" class="btn btn-primary">{{ __('Ya') }}</button>
                </div>
            @endif
        </div>
    </div>
</div>
