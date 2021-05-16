<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Починим.Онлайн</title>

	<!-- Fonts -->

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ url('css/app.css') }}">
	<!-- Styles -->

</head>

<body class="antialiased">
	<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
		@if (Route::has('login'))
		<div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
			@auth
			<a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
			@else
			<a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

			@if (Route::has('register'))
			<a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
			@endif
			@endauth
		</div>
		@endif

		<div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
			<div class="flex justify-center pt-8 sm:pt-0">
				<img src="/img/logo1a.svg" width="300">
			</div>

			@if(session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
			@else
			<div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
				<div class="flex">
					<div class="p-6">
						<div class="mt-2 text-gray-600 dark:text-gray-400 text-sm px-8">
							<h1>Починим.Онлайн - сервис, который поможет вам быстро найти человека, способного починить ваш автомобиль.</h1>
							<p>Вы заполняете заявку, вам приходят отклики мастеров, вы выбираете одного из них и принимаете предложение.</p>
							<p>А дальше... дальше всё само собой завертится!</p>
							<h3>Заполните заявку:</h3>
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

			<div class="flex justify-center mt-4 sm:items-center sm:justify-between">
				<div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
					Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
				</div>
			</div>
		</div>

	</div>
</body>

</html>