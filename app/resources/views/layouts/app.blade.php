<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>


    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100">
        <!--@ include('layouts.navigation')-->
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

        <!-- Page Heading -->

		  @hasSection ('header')
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
					@yield('header')
            </div>
        </header>
		  @endif

        <!-- Page Content -->
        <main>
			<div class="container mx-auto flex flex-wrap p-0 flex-col md:flex-row items-center">
            @yield('content')
			</div>
        </main>
    </div>
</body>

</html>
