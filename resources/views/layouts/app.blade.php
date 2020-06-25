<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')@yield('title') - @endif{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('head')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-white shadow-sm bg-umy">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/icon.png') }}" width="30" height="30" class="d-inline-block align-bottom mr-1">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @if(auth()->user()->role === 'super-admin')
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Data') }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-left">
                                        <a class="dropdown-item" href="{{ route('user.index') }}">{{ __('Pengguna') }}</a>
                                        <a class="dropdown-item" href="{{ route('faculty.index') }}">{{ __('Fakultas') }}</a>
                                        <a class="dropdown-item" href="{{ route('study.index') }}">{{ __('Program Studi') }}</a>
                                        <a class="dropdown-item" href="{{ route('lecturer.index') }}">{{ __('Dosen') }}</a>
                                        <a class="dropdown-item" href="{{ route('meeting.index') }}">{{ __('Jenis Rapat') }}</a>
                                        <a class="dropdown-item" href="{{ route('room.index') }}">{{ __('Ruangan') }}</a>
                                    </div>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('minute.index') }}">{{ __('Notulen') }}</a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if(session('notice'))
                <div class="container">
                    <x-alert
                        :dismissible="session('notice')['dismissible'] ?? false"
                        :content="session('notice')['content'] ?? null"
                        :type="session('notice')['type']">
                    </x-alert>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('body')
</body>
</html>
