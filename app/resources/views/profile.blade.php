@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            @auth
                <div class="col-md-12 d-flex">
                    <div class="card">
                        <div class="card-header">Ваш профиль:</div>

                        <div class="card-body">

                            <x-form :action="route(Auth::user()->user_role_string.'.store')" class=" d-flex flex-wrap w-100 mb-4 form-with-map form-profile">
                                @method('PUT')

                                @include('auth.register-fields')

                                <div class="mt-2">
                                    <x-form-input id="title" label="Как к вам обращаться?" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                                </div>

                                @if (Auth::user()->isMaster())
                                    <div class="mt-2">
                                        <x-form-input id="location" label="Где вы находитесь? Отметьте на карте" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                                    </div>
                                @endif


                                <div class="d-flex flex-nowrap align-items-center">
                                    <p class="mr-2">Напишите <b>START</b> в диалоге с нашим ботом, чтобы получать уведомления</p>
                                    <a href="https://telegram.me/PochinimOnline_bot?start=welcome_{{ Auth::user()->id }}" class="btn btn-warning shadow p-2 telegram-button" target="blank">
                                        <img src="/img/tg.svg" height="24">
                                        Нажмите, чтобы открыть чат
                                    </a>

                                </div>

                                <div class="offer-actions d-flex flex-nowrap align-items-start">
                                    <x-form-submit class="ml-4">
                                        Сохранить
                                    </x-form-submit>
                                </div>

                            </x-form>

                        </div>
                    </div>
                    @if (Auth::user()->isMaster())
                        <div class="map-container">@include('mapbox')</div>
                    @endif
                </div>
            @endauth
        </div>
    </div>
@endsection
