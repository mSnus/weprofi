@extends('layouts.app')

@section('title', 'Починим.Онлайн')

@section('content')
	<link rel="stylesheet" type="text/css" href="/css/slick.css" />
	<link rel="stylesheet" type="text/css" href="/css/slick-theme.css" />


    <ul id="icons-slider2" class="container help-icons">
        <li class="help-block">
            <img class="help-icon" src="/img/icon1-near.png" alt="Рядом с вами" title="Рядом с вами">
            <div class="help-text">Рядом с вами! Мастер выполнит работу на парковке, на непроезжей части, в вашем гараже, у дома или рядом с местом вашей работы.</div>
        </li>
        <li class="help-block">
            <img class="help-icon" src="/img/icon2-tools.png" alt="Всё с собой" title="Всё с собой">
            <div class="help-text">Мастер привезет с собой все необходимые инструменты и запчасти для выполнения заказа.</div>
        </li>
        <li class="help-block">
            <img class="help-icon" src="/img/icon3-rouble.png" alt="Не бойтесь ошибиться" title="Не бойтесь ошибиться">
            <div class="help-text">Если вы при заказе вы ошиблись и потребуется больше услуг, мастер оформит дополнительный заказ. Если меньше, мы произведем перерасчет, и вернем остаток.</div>
        </li>
        <li class="help-block">
            <img class="help-icon" src="/img/icon4-mp.png" alt="Следим за чистотой" title="Следим за чистотой">
            <div class="help-text">Мастера убирают за собой и предпринимают все необходимое, чтобы оставить место таким же чистым, каким оно было изначально.</div>
        </li>
    </ul>

    <script type="text/javascript" src="/js/slick.js"></script>
    <script>
        $(document).ready(() => {
            $("#icons-slider2").slick({
                infinite: true,
					 autoplay: true,
					 arrows: false,
					 speed: 300,
            });
        });
    </script>


    <div class="container d-flex justify-content-center section-welcome">



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

                @if (Auth::user()->isMaster())
                    @include('/masters_home');
                @endif
            </div>
        @endif


    </div>

    @if (!Auth::user())
        <div class="container p-4 pt-5">
            <div class="d-flex justify-content-center bg-light-blue align-items-center">
                <!-- регистрация мастера -->
                <div class="">
                    <h2>Мастер? Вы нам нужны!</h2>
                    <button class="btn btn-success" onclick="window.location.href='/master';">Присоединяйтесь!</button>
                </div>
            </div>
        </div>
    @endif
@endsection
