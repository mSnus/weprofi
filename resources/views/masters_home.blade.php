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
                    <h1><a href="/user/{{Auth::user()->id}}">Ваш профиль</a>:</h1>

                    <div class="card-body d-flex flex-nowrap">

                        <x-form :action="route('master.update', Auth::user()->id)" class=" d-flex flex-wrap w-100 mb-4 mr-4 form-with-map form-profile">
                            @method('PUT')

                            @include('auth.register-fields', ['password_required' => false])

                            <div class="mt-4">
                                <x-form-input id="tagline" label="Краткое описание" class="block mt-1 w-full" 
                                type="text" name="tagline" :value="$master->tagline ?? old('tagline')"/>
                            </div>

                            <div class="mt-2">
                                <x-form-textarea id="content" label="Подробное описание" class="block mt-1 w-full"
                                    type="text" name="content">
                                    {{ $master->content ?? old('content') }}
                                </x-form-textarea>
                            </div>

                            <div class="mt-2">
                                <x-form-textarea id="pricelist" label="Прайс (образец для красивого оформления: 'Услуга__100sh/час')" class="block mt-1 w-full"
                                    type="text" name="pricelist">
                                    {{ $master->pricelist ?? old('pricelist') }}
                                </x-form-textarea>
                            </div>                            


                            <div class="offer-actions d-flex flex-nowrap align-items-start">
                                <x-form-submit class="ml-4 button-primary">
                                    Сохранить
                                </x-form-submit>

                                <button class="secondary" onclick="window.location.href='/logout'; return false;">
                                    Выйти
                                </button>
                            </div>

                        </x-form>
                    </div>

                @endauth
            </div>
        </div>
    @endsection
