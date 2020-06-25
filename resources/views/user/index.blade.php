@extends('layouts.app')

@section('title', __('Pengguna'))

@section('content')
    <div class="container">
        <form action="{{ route(Route::currentRouteName()) }}" class="d-flex justify-content-end mb-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="{{ __('Nama pengguna atau email') }}" name="cari">
                <div class="input-group-append" id="button-addon4">
                    <button class="btn btn-outline-success" type="submit">{{ __('Cari') }}</button>
                    <a class="btn btn-success" href="{{ route('user.create') }}">{{ __('Buat Pengguna') }}</a>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-header bg-umy">{{ __('Daftar Pengguna') }}</div>
            <div class="card-body">
                <div class="table-responsive py-2">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Nama') }}</th>
                                <th scope="col">{{ __('E-Mail') }}</th>
                                <th scope="col">{{ __('Role') }}</th>
                                <th scope="col">{{ __('Bagian') }}</th>
                                <th scope="col">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @each('user.index.row', $users, 'user', 'user.index.empty')
                        </tbody>
                    </table>
                </div>
                @if($users->lastPage() > 1)
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
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
             :message="__('Ingin menghapus pengguna ini?')">
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
