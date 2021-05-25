@extends('layouts.app')

@section('title', 'Починим.Онлайн')

@section('content')

    <div class="alert alert-danger text-center">Telegram Bot is ready:
        @php
            $response = Telegram::getMe();

            $botId = $response->getId();
            $botFirstName = $response->getFirstName();
            $botUsername = $response->getUsername();
            echo $botId . ' ' . $botFirstName . ' ' . $botUsername;
        @endphp
    </div>

    <div class="d-flex justify-content-center bg-light-blue">
        <div class="mr-4">
            <h1>Поможем вам быстро найти мастера,<br> который поможет вам с ремонтом автомобиля</h1>
            <p>Заполняете заявку, вам приходят отклики мастеров, вы выбираете одного из них и принимаете предложение.</p>
            <p>А дальше... дальше всё само собой завертится!</p>
        </div>
        <!-- регистрация мастера -->
        <div class="">
            <h2>Мастер? Вы нам нужны!</h2>
            <button class="btn btn-success" onclick="window.location.href='/master';">Присоединяйтесь!</button>
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

            @if (!Auth::user() || Auth::user()->isClient())
                <!-- регистрация клиента и новая заявка -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @else
					 	@include('requests')
                @endif
            @else
						@include('/home');
            @endif
        </div>
    </div>
@endsection
