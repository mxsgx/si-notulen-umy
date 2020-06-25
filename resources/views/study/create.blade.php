@extends('layouts.app')

@section('title', __('Tambah Program Studi'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between mb-4">
                    <a class="btn btn-outline-secondary" href="{{ route('study.index') }}">&laquo; {{ __('Kembali') }}</a>
                </div>
                <div class="card">
                    <div class="card-header bg-umy">{{ __('Tambah Program Studi') }}</div>
                    <div class="card-body">
                        <form action="{{ route('study.store') }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="name">{{ __('Nama Program Studi') }}</label>
                                <input type="text" name="name" required id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="faculty_id">{{ __('Fakultas') }}</label>
                                <select name="faculty_id" id="faculty_id" class="form-control @error('faculty_id') is-invalid @enderror" required>
                                    @foreach(\App\Faculty::all() as $faculty)
                                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                    @endforeach
                                </select>
                                @error('faculty_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">{{ __('Tambah') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

