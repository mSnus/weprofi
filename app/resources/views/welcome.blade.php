<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Починим.Онлайн</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
    <!-- Styles -->

	 <script src="{{ asset('js/app.js') }}"></script>

    <!-- MapBox -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
    <!-- Load the `mapbox-gl-geocoder` plugin. -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css">

    <!-- Promise polyfill script is required -->
    <!-- to use Mapbox GL Geocoder in IE 11. -->
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
</head>

<body class="antialiased">
    <header class="text-gray-600 body-font">
        <div class="container mx-auto flex flex-wrap p-0 flex-col md:flex-row items-center">
            <a href="/" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
                <img src="/img/logo1a-horiz.svg" width="200">
            </a>
            @if (Route::has('login'))
                <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 hover:text-indigo-600 mr-5 underline">Профиль</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600 mr-5 underline">Вход</a>


                    </nav>
                    @if (Route::has('register'))
                        <button class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base" onclick="window.location.href='{{ route('register') }}';">Регистрация
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @endif
                @endauth
            @endif
        </div>
    </header>

    <div class="flex  justify-center mb-8">
        <div class="mt-2 text-gray-600 text-sm px-8">
            <h1>Поможем вам быстро найти мастера,<br> который поможет вам с ремонтом автомобиля</h1>
            <p>Заполняете заявку, вам приходят отклики мастеров, вы выбираете одного из них и принимаете предложение.</p>
            <p>А дальше... дальше всё само собой завертится!</p>
        </div>
        <!-- регистрация мастера -->
        <div class="mt-2 text-gray-600 text-sm px-8">
            <h2>Мастер? Вы нам нужны!</h2>
            <button class="bg-indigo-500 text-white active:bg-indigo-600 font-bold uppercase text-base px-8 py-3 rounded shadow-md hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" onclick="window.location.href='/master';">Присоединяйтесь!</button>
        </div>
    </div>

    <div class="relative flex items-top justify-center bg-gray-100 sm:items-center py-4 sm:pt-0">

        <div class="flex">
            <!-- регистрация клиента и новая заявка -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @else
                <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg">
                    <div class="flex">
                        <div class="p-6">
                            <div class="mt-2 text-gray-600 text-sm px-8">
                                <h3>В чём твоя проблема, человек? .[0_0].</h3>
                            </div>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="p-6">
                            @include('requests')
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- footer -->
    <div class="flex justify-center mt-4">
        <img src="/img/icon1a.svg" width="60">
        <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
            &copy; 2021, <span class="text-blue-900">pochinim</span><span class="text-yellow-700">.online</span>
        </div>
    </div>
</body>

</html>
