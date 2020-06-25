@extends('layouts.app')

@section('title', __('Ubah Jenis Rapat'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between mb-4">
                    <a class="btn btn-outline-secondary" href="{{ route('meeting.index') }}">&laquo; {{ __('Kembali') }}</a>
                    <a class="btn btn-outline-primary" href="{{ route('meeting.create') }}">&plus; {{ __('Tambah Baru') }}</a>
                </div>
                <div class="card">
                    <div class="card-header bg-umy">{{ __('Ubah Jenis Rapat') }}</div>
                    <div class="card-body">
                        <form action="{{ route('meeting.update', compact('meeting')) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="name">{{ __('Nama Jenis Rapat') }}</label>
                                <input type="text" name="name" required id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $meeting->name }}">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="#" data-toggle="modal" data-target="#delete" class="btn btn-danger mr-2">{{ __('Hapus') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Ubah') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('body')
    <x-modal type="form"
             id="delete"
             method="delete"
             :action="route('meeting.delete', compact('meeting'))"
             :title="__('Konfirmasi Penghapusan')"
             classes="modal-dialog-centered modal-dialog-scrollable"
             :message="__('Ingin menghapus jenis rapat ini? Semua data yang berelasi dengan jenis rapat ini akan terhapus!')">
    </x-modal>
@endpush
