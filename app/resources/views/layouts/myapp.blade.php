<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

	 @hasSection ('head')
	 	@yield('head')
	 @endif


    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body class="">

    <div class="">
        <!--@ include('layouts.navigation')-->
		  <header class="">
			<div class="container m-auto">
				 <a href="/" class="d-flex">
					  <img src="/img/logo1a-horiz.svg" width="200">
				 </a>
				 @if (Route::has('login'))
					  <nav class="text-center">
							@auth
								 <a href="{{ url('/dashboard') }}" class="">Профиль</a>
							@else
								 <a href="{{ route('login') }}" class="">Вход</a>


							</nav>
							@if (Route::has('register'))
								 <button class="btn btn-primary" onclick="window.location.href='{{ route('register') }}';">Регистрация
									  <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24" width="24">
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
        <header class="">
            <div class="container">
					@yield('header')
            </div>
        </header>
		  @endif

        <!-- Page Content -->
        <main>
			<div class="container">
            @yield('content')
			</div>
        </main>
    </div>

    <!-- footer -->
    <div class="flex justify-center">
		<img src="/img/icon1a.svg" width="60">
		<div class="">
			 &copy; 2021, <span class="text-blue-900">pochinim</span><span class="text-yellow-700">.online</span>
		</div>
  </div>
</body>

</html>
