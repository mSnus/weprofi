<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @hasSection('title')
        <title>@yield('title')</title>
    @else
        <title>Pochinim.online</title>
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    @hasSection('head')
        @yield('head')
    @endif


    <!-- Styles -->
    <link href="{{ asset('css/app-boot.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	 <link href="{{ asset('css/app-mobile.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="head-wrapper">
            <nav class="navbar navbar-expand-md navbar-dark">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        @php
                            if (isset($_REQUEST['rand'])) {
                                $rand = $_REQUEST['rand'];
                            } else {
                                $rand = rand(1, 3);
                            }

                            $logo = $rand == 1 ? 'src="/img/logo1.png" style="margin-left: -85px;"' : 'src="/img/logo' . $rand . '.png" style="margin-top: 20px;margin-left: -18px;"';

                        @endphp
                        <img {!! $logo !!}>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->title() }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/profile">
                                            Профиль
                                        </a>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Выход
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="head-descr text-left" style="margin-top: 27px">
                    <img src="/img/description.png">
                </div>
                <div class="head-texts">
                    <div class="head-text-block head-text1">
                        <div class="head-text-icon"><img src="/img/icon-1.png"></div>
                        <div class="head-text">Указываете марку и модель машины, своими словами описываете неисправность, ставите точку на карте.</div>
                    </div>
                    <div class="head-text-block head-text2">
                        <div class="head-text-icon"><img src="/img/icon-2.png"></div>
                        <div class="head-text">Получаете отклики от Мастеров, выбираете подходящего по дальности, рейтингу и озывам</div>
                    </div>
                    <div class="head-text-block head-text3">
                        <div class="head-text-icon"><img src="/img/icon-3.png"></div>
                        <div class="head-text">Выбранный Мастер согласует с Вами время, детали, приезжает и проводит ремонт на месте. На типовые работы цены фиксированы по <a href="#price"> прайс-листу</a></div>
                    </div>
                </div>
                @if ($rand == 0)
                    <div class="text-center" style="margin-top: 14px">
                        <img src="/img/robot2.png">
                    </div>
                @endif
            </div>
        </div>

        @hasSection('header')
            <header class="">
                <div class="container">
                    @yield('header')
                </div>
            </header>
        @endif

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="footer d-flex justify-content-center w-100 align-items-center">
            <img {!! $logo !!} width="220" class="mr-4 mb-2">
            <div class="">
                &copy; 2021, <span style="color:white;">pochinim</span><span style="color:sandybrown;">.online</span>
            </div>
        </footer>
    </div>
</body>

</html>
