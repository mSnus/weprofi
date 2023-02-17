<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('title')
        <title>@yield('title')</title>
    @else
        <title>WeProfi</title>
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">


    @hasSection('head')
        @yield('head')
    @endif

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=1">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=1">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=1">
    <link rel="manifest" href="/site.webmanifest?v=1">
    <link rel="mask-icon" href="/safari-pinned-tab.svg?v=1" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon.ico?v=1">
    <meta name="msapplication-TileColor" content="#603cba">
    <meta name="theme-color" content="#ffffff">

    <!-- Styles -->
    <link href="{{ asset('css/app-boot.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app-mobile.css') }}" rel="stylesheet">

    <script>
        window._csrf_token = '{{ csrf_token() }}';
    </script>
</head>

<body>
    <div id="app">
        @auth
            <div class="topbar">
                <div class="cabinet-wrapper">
                    <div class="cabinet">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"
                            fill="#b79e6d" width="24" height="24">
                            <g><path d="M500,10C228.8,10,10,228.8,10,500c0,271.3,218.8,490,490,490c271.3,0,490-218.8,490-490C990,228.8,771.3,10,500,10z M804.5,822C794,657.5,619,613.8,619,613.8s106.8-71.8,68.3-217c-19.3-75.3-91-131.3-189-131.3c-98,0-169.7,56-189,131.3c-38.5,145.2,68.2,217,68.2,217S202.5,652.3,192,822C109.7,739.7,57.3,626,57.3,500C57.3,255,255,57.3,500,57.3C745,57.3,942.8,255,942.8,500C942.8,626,890.2,739.7,804.5,822z"/></g>
                        </svg>
                        <a href="/profile">{{Auth::user()->name}}</a>
                    </div>
                </div>
                @auth
                <div class="logout-wrapper">
                    <div class="logout">
                        @include('svg/exit')
                        <a href="/logout">Выход</a>
                    </div>
                </div>
                @endauth
            </div>
        @endauth


        <div class="top-logo mt-4">
            <a href="{{ url('/') }}">
                <img src="/img/logo3-full.svg" alt="Logo">
            </a>
        </div>
        {{--
        <div class="head-wrapper">
            <nav class="navbar navbar-expand-md navbar-dark">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">Вход</a>
                                    </li>
                                @endif
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name() }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/profile">
                                            Профиль
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Выход
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </div> --}}

        @hasSection('header')
            <header>
                <div class="container">
                    @yield('header')
                </div>
            </header>
        @endif

        <main class="py-4">
            <div class="container d-block text-center">
              @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

                @yield('content')





            </div>

        </main>

        <footer class="footer d-flex justify-content-center w-100 align-items-center">

            <div class="footer-copy">
                &copy; 2022-{{ date('Y') }} <a href='/' class="mt-1"><img src="/img/logo3-base.svg" width="160" class="mr-4 mb-2"  alt="Logo"></a>
            </div>
            <div class="footer-links"><a href="/contact">Обратная связь</a></div>
            @php
                $stat = App\Http\Controllers\StatsController::updateSimpleUtm();
            @endphp
        </footer>
    </div>
</body>

</html>
