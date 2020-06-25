@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-umy">{{ __('Selamat Datang') }}</div>

                    <div class="card-body text-center">
                        <p>Assalamu'alaikum Warahmatullahi Wabarakaatuh</p>
                        <figure class="figure">
                            <img src="{{ asset('images/logo.png') }}" class="figure-img img-fluid w-25">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
