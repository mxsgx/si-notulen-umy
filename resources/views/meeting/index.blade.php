@extends('layouts.app')

@section('title', __('Jenis Rapat'))

@section('content')
    <div class="container">
        <form action="{{ route(Route::currentRouteName()) }}" class="d-flex justify-content-end mb-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="{{ __('Nama jenis rapat') }}" name="cari">
                <div class="input-group-append" id="button-addon4">
                    <button class="btn btn-outline-success" type="submit">{{ __('Cari') }}</button>
                    <a class="btn btn-success" href="{{ route('meeting.create') }}">{{ __('Tambah Jenis Rapat') }}</a>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-header bg-umy">{{ __('Daftar Jenis Rapat') }}</div>
            <div class="card-body">
                <div class="table-responsive py-2">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Nama') }}</th>
                                <th scope="col">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @each('meeting.index.row', $meetings, 'meeting', 'meeting.index.empty')
                        </tbody>
                    </table>
                </div>
                @if($meetings->lastPage() > 1)
                    <div class="d-flex justify-content-center">
                        {{ $meetings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('body')
    <x-modal type="form"
             id="delete"
             method="delete"
             :title="__('Konfirmasi Penghapusan')"
             classes="modal-dialog-centered modal-dialog-scrollable"
             :message="__('Ingin menghapus jenis rapat ini? Semua data yang berelasi dengan jenis rapat ini akan terhapus!')">
    </x-modal>

    <script type="text/javascript">
        $('#delete').on('show.bs.modal', function (e) {
            let refBtn = e.relatedTarget;
            e.currentTarget.querySelector('form').action = refBtn.href;
        }).on('hide.bs.modal', function (e) {
            e.currentTarget.querySelector('form').action = '#';
        });
    </script>
@endpush
