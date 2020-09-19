@extends('layouts.app')

@section('title', __('Buat Pengguna'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between mb-4">
                    <a class="btn btn-outline-secondary" href="{{ route('user.index') }}">&laquo; {{ __('Kembali') }}</a>
                </div>
                <div class="card">
                    <div class="card-header bg-umy">{{ __('Buat Pengguna') }}</div>
                    <div class="card-body">
                        <form action="{{ route('user.store') }}" method="post" x-data="data()">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="name">{{ __('Nama Pengguna') }}</label>
                                <input type="text" name="name" required id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('Alamat E-Mail') }}</label>
                                <input type="email" name="email" required id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Kata Sandi') }}</label>
                                <input type="password" name="password" required id="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role">{{ __('Role') }}</label>
                                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" x-model="role" @change="roleOnChange" required>
                                    <option value="super-admin">{{ __('Super Admin') }}</option>
                                    <option value="admin">{{ __('Admin') }}</option>
                                    <option value="operator">{{ __('Operator') }}</option>
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
                                                    <option value="{{ $study->id }}">{{ $study->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('study_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </template>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ __('Buat') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('body')
    <script type="text/javascript">
        function data() {
            return {
                role: 'super-admin',
                isNotSuperAdmin: false,
                roleOnChange(el) {
                    this.isNotSuperAdmin = this.role !== 'super-admin';
                }
            }
        }
    </script>
@endpush
