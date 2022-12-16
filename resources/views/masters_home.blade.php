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
                <div class="col-md-12">
                        <h1>Ваш профиль:</h1>

                        <div class="card-body d-flex flex-nowrap">

                            <x-form :action="route(Auth::user()->user_role_string.'.update', Auth::user()->id)" class=" d-flex flex-wrap w-100 mb-4 mr-4 form-with-map form-profile">
                                @method('PUT')

                                @include('auth.register-fields', ['password_required' => false])


                                @if (Auth::user()->isMaster())

                                    <div class="mt-2">
                                        <x-form-textarea id="descr" label="О вас (коротко, но ёмко)" class="block mt-1 w-full" type="text" name="descr">
													{{ Auth::user()->descr }}
													</x-form-textarea>
                                    </div>


                                    <div class="mt-2">
                                        <x-form-input id="location" label="Где вы находитесь? Отметьте на карте" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                                    </div>
                                @endif


                                <div class="offer-actions d-flex flex-nowrap align-items-start">
                                    <x-form-submit class="ml-4 button-primary">
                                        Сохранить
                                    </x-form-submit>

                                    <button class="secondary" onclick="window.location.href='/logout'; return false;">
                                        Выйти
                                    </button>
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
                    
                @endauth
            </div>
        </div>
    @endsection
