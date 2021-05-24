@extends('layouts.app')

		@section('title', 'Починим.Онлайн')


		@section('head')
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
		@endsection

</head>


	@section('head')


    <header class="text-gray-600 body-font">
        <div class="container mx-auto flex flex-wrap p-0 flex-col md:flex-row items-center">
            <a href="/" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
                <img src="/img/logo1a-horiz.svg" width="200">
            </a>
            @if (Route::has('login'))
                <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 hover:text-indigo-600 mr-5 underline">Профиль</a>
                        <a href="{{ route('logout') }}" class="text-sm text-gray-700 hover:text-indigo-600 mr-5 underline">Выход</a>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600 mr-5 underline">Вход</a>
                    @endguest


                </nav>
                @guest
                    @if (Route::has('register'))
                        <button class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base" onclick="window.location.href='{{ route('register') }}';">Регистрация
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @endif
                @endguest
            @endif
        </div>
    </header>
	 @endsection


	 @section('content')
    <div class="d-flex justify-content-center bg-light-blue">
        <div class="mr-4">
            <h1>Поможем вам быстро найти мастера,<br> который поможет вам с ремонтом автомобиля</h1>
            <p>Заполняете заявку, вам приходят отклики мастеров, вы выбираете одного из них и принимаете предложение.</p>
            <p>А дальше... дальше всё само собой завертится!</p>
        </div>
        <!-- регистрация мастера -->
        <div class="">
            <h2>Мастер? Вы нам нужны!</h2>
            <button class="btn btn-secondary" onclick="window.location.href='/master';">Присоединяйтесь!</button>
        </div>
    </div>

    <div class="container d-flex justify-content-center">

        <div class="flex shadow p-3 mb-5 bg-white rounded">
			@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
			@endif
			<!-- регистрация клиента и новая заявка -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @else
						<div class="d-flex justify-content-center">
							<div class="mr-4">
								<div class="mt-2 text-gray-600 text-sm px-8">
									<h3>В чём твоя проблема, человек? .[0_0].</h3>
								</div>
							</div>
					</div>
                <div class="d-flex justify-content-center">

                    <div class="d-flex justify-content-center">
                        <div class="">
                            @include('requests')
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
	 @endsection