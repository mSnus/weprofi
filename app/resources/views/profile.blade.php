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

                        <div class="card-body d-flex flex-nowrap">

                            <x-form :action="route(Auth::user()->user_role_string.'.update', Auth::user()->user_role->id)" class=" d-flex flex-wrap w-100 mb-4 mr-4 form-with-map form-profile">
                                @method('PUT')

                                @include('auth.register-fields', ['password_required' => false])

                                <div class="mt-2">
                                    <x-form-input id="title" label="Как к вам обращаться?" class="block mt-1 w-full" type="text" name="title" value="{{ Auth::user()->user_role->title }}" required />
                                </div>

                                @if (Auth::user()->isMaster())

                                    <div class="mt-2">
                                        <x-form-textarea id="descr" label="О вас (коротко, но ёмко)" class="block mt-1 w-full" type="text" name="descr">
													{{ Auth::user()->user_role->descr }}
													</x-form-textarea>
                                    </div>


                                    <div class="mt-2">
                                        <x-form-input id="location" label="Где вы находитесь? Отметьте на карте" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                                    </div>
                                @endif


                                @php
                                    $tgButtonClass = Auth::user()->telegram_id != '' ? 'btn-light' : 'btn-warning';
                                @endphp
                                <div class="d-flex flex-nowrap align-items-center">
                                    <p class="mr-2">Напишите <b>START</b> в диалоге с нашим ботом, чтобы получать уведомления</p>
                                    <a href="https://telegram.me/PochinimOnline_bot?start=welcome_{{ Auth::user()->id }}" class="btn {{ $tgButtonClass }} shadow p-2 telegram-button" target="blank">
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

                            @if (Auth::user()->isMaster())
                                @php
                                    $mapbox = ['no_autocenter' => true, 'height' => '100%'];

                                    $location = Auth::user()->master()->location;

                                    if ($location != '') {
                                        $lng = substr($location, 0, strpos($location, ','));
                                        $lat = substr($location, strpos($location, ',') + 1);
                                        $mapbox['lng'] = $lng;
                                        $mapbox['lat'] = $lat;
                                    }

                                @endphp

                                @include('mapbox', $mapbox)
                            @endif
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    @endsection
