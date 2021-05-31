@extends('layouts.app')

@section('title', 'Починим.Онлайн')

@section('content')

    <div class="container">
        <div class="alert alert-success text-center">Telegram Bot is ready:
            @php
                $response = Telegram::getMe();
                $botId = $response->getId();
                $botFirstName = $response->getFirstName();
                $botUsername = $response->getUsername();
                echo $botId . ' ' . $botFirstName . ' ' . $botUsername;
            @endphp
        </div>
    </div>

    <div class="container p-4 pt-0">
        <div class="d-flex justify-content-center bg-light-blue align-items-center">
            <div class="mr-4 p-5 pt-0 introtext">
                <h1 class="mb-4">Быстро найдём мастера, который поможет вам с выездным ремонтом автомобиля!</h1>
                <p><span class="big-digit">1</span> Указываете марку и модель автомобиля, грузовика, автобуса или спецтехники, своими словами описываете неисправность, указываете местоположение на карте.</p>
                <p><span class="big-digit">2</span> На вашу заявку откликаются мастера, квалификация которых соответствует заявленной вами проблеме и которые находятся ближе к вам</p>
                <p><span class="big-digit">3</span> Вы выбираете мастера, исходя из его рейтинга и отзывов пользователей. Выбранный Мастер согласовывает с Вами время, приезжает и проводит диагностику</p>
                <p>Работы, не связанные со снятием и разборкой узлов и агрегатов, не превышающие по времени 45 минут входят в стоимость. Если по результатам диагностики требуются дополнительные работы и запчасти, то их стоимость согласовывается с мастером. Оплата возможна наличными, с использованием платежных систем, по безналичному расчету.</p>
            </div>
            <!-- регистрация мастера -->
            <div class="">
                <h2>Мастер? Вы нам нужны!</h2>
                <button class="btn btn-success" onclick="window.location.href='/master';">Присоединяйтесь!</button>
            </div>
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
                    @include('requests', ['password_required' => true])
                @endif
            @else
                @if (Auth::user()->isMaster())
                    @include('/masters_home');
                @else

                @endif

            @endif
        </div>
    </div>
@endsection
