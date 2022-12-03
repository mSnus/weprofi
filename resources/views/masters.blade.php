@extends('layouts.app', ['header' => 'Регистрация мастера'])

@section('title', 'Регистрация мастера')

@section('content')
    <div class="container d-flex justify-content-center">
        <div class="fields-container mr-4">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form action="" method="post" action="{{ route('master.store') }}" class="form-with-map">
                <!-- CROSS Site Request Forgery Protection -->
                @csrf

                @include('auth.register-fields')

                <!-- Имя -->
                <div class="mt-4">
                    <x-form-input id="title" label="Как к вам обращаться?" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                </div>
					 <div class="mt-4">
						<x-form-input id="location" label="Где вы находитесь? Отметьте на карте" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
				  </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Уже зарегистрированы?') }}
                    </a>

                    <x-form-submit class="ml-4">
                        {{ __('Регистрация') }}
                    </x-form-submit>
                </div>
            </form>
        </div>
		  <div class="map-container">@include('mapbox')</div>
    </div>
@stop
