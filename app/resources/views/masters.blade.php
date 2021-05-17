@extends('layouts.app', ['header' => 'Регистрация мастера'])

@section('title', 'Регистрация мастера')

@section('content')
	<!-- Validation Errors -->
	<x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form action="" method="post" action="{{ route('master.store') }}">
        <!-- CROSS Site Request Forgery Protection -->
        @csrf

        @include('auth.register-fields')

        <!-- Имя -->
        <div class="mt-4">
            <x-label for="title" :value="__('Как к вам обращаться?')" />

            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Уже зарегистрированы?') }}
            </a>

            <x-button class="ml-4">
                {{ __('Регистрация') }}
            </x-button>
        </div>
    </form>
@stop
