@extends('layouts.app')

@section('title', __('Ubah Pengguna'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between mb-4">
                    <a class="btn btn-outline-secondary" href="{{ route('user.index') }}">&laquo; {{ __('Kembali') }}</a>
                    <a class="btn btn-outline-primary" href="{{ route('user.create') }}">&plus; {{ __('Buat Baru') }}</a>
                </div>
                <div class="card">
                    <div class="card-header bg-umy">{{ __('Ubah Pengguna') }}</div>
                    <div class="card-body">
                        <form action="{{ route('user.update', compact('user')) }}" method="post" x-data="data()">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="name">{{ __('Nama Pengguna') }}</label>
                                <input type="text" name="name" required id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Alamat E-Mail') }}</label>
                                <input type="email" name="email" required id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role">{{ __('Role') }}</label>
                                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" x-model="role" @change="roleOnChange" required>
                                    <option value="super-admin" @if($user->role === 'super-admin') selected @endif>{{ __('Super Admin') }}</option>
                                    <option value="admin" @if($user->role === 'admin') selected @endif>{{ __('Admin') }}</option>
                                    <option value="operator" @if($user->role === 'operator') selected @endif>{{ __('Operator') }}</option>
                                </select>
                                @error('role')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <template x-if="isNotSuperAdmin">
                                <div class="form-group">
                                    <label for="study_id">{{ __('Prodi') }}</label>
                                    <select name="study_id" id="study_id" class="form-control @error('study_id') is-invalid @enderror" required>
                                        @foreach(\App\Faculty::all() as $faculty)
                                            <optgroup label="{{ $faculty->name }}">
                                                @foreach($faculty->studies as $study)
                                                    <option value="{{ $study->id }}" @if($user->study_id === $study->id) selected @endif>{{ $study->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('study_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </template>
                            <hr>
                            <div class="form-group">
                                <label for="password">{{ __('Ganti Kata Sandi') }}</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
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
             :action="route('user.delete', compact('user'))"
             :title="__('Konfirmasi Penghapusan')"
             classes="modal-dialog-centered modal-dialog-scrollable"
             :message="__('Ingin menghapus pengguna ini?')">
    </x-modal>

    <script type="text/javascript">
        function data() {
            return {
                role: '{{ $user->role }}',
                isNotSuperAdmin: {{ $user->role !== 'super-admin' ? 'true' : 'false' }},
                roleOnChange(el) {
                    this.isNotSuperAdmin = this.role !== 'super-admin';
                }
            }
        }
    </script>
@endpush
