@extends('layouts.app')

@section('head')
<!-- MapBox -->
<link href='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js'></script>
<!-- Load the `mapbox-gl-geocoder` plugin. -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
    <script src="{{ asset('js/uploads.js') }}" ></script>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
        
    @php
        $user = App\Models\User::getData(Auth::id())['user'];
        $isMaster = $user->usertype == App\Models\User::typeMaster;
    @endphp

    <div class="container profile">
        <div class="row justify-content-center">
            @auth
                <div class="col-md-12">
                    <h1>Основные данные:</h1>
                    
                    
                    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

                    <div class="w-100">
                        <form 
                            action="/profile.avatar" 
                            class="d-flex flex-wrap w-100 mb-4 mr-4" 
                            id="formAvatar"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            <div class="avatar-container">
                                <div class="avatar"
                                    style="background-image: url({{ $user->avatar ?? '/img/avatar.png' }})"
                                    alt="User avatar"
                                    onclick="uploadAvatar()">
                                    <svg height="1792" viewBox="0 0 1792 1792" width="1792" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1344 1472q0-26-19-45t-45-19-45 19-19 45 19 45 45 19 45-19 19-45zm256 0q0-26-19-45t-45-19-45 19-19 45 19 45 45 19 45-19 19-45zm128-224v320q0 40-28 68t-68 28h-1472q-40 0-68-28t-28-68v-320q0-40 28-68t68-28h427q21 56 70.5 92t110.5 36h256q61 0 110.5-36t70.5-92h427q40 0 68 28t28 68zm-325-648q-17 40-59 40h-256v448q0 26-19 45t-45 19h-256q-26 0-45-19t-19-45v-448h-256q-42 0-59-40-17-39 14-69l448-448q18-19 45-19t45 19l448 448q31 30 14 69z" />
                                    </svg>
                                </div>
                            </div>
                                {{-- document.forms.formAvatar.submit(); --}}
                                
                            <input type="file" id="fileAvatar" name="files[]" style="visibility: hidden;" accept="image/png, image/jpeg">    
                        </form>
                    </div>

                    <div class="card-body d-flex flex-nowrap">
                        <x-form :action="'/profile.update/'.$user->id" class=" d-flex flex-wrap w-100 mb-4 mr-4 form-with-map form-profile">
                            @method('POST')
                            @csrf

                            @include('auth.register-fields', ['password_required' => false])

                            <div class="mt-2">
                                <input id="location" label="Где вы находитесь? Отметьте на карте"
                                     type="hidden" name="location" :value="old('location')" />

                                @php
                                    $mapbox = ['no_autocenter' => true, 'height' => '100%'];
                                    
                                    $location = $user->location;
                                    
                                    if ($location != '') {
                                        $lng = substr($location, 0, strpos($location, ','));
                                        $lat = substr($location, strpos($location, ',') + 1);
                                        $mapbox['lng'] = $lng;
                                        $mapbox['lat'] = $lat;
                                    }
                                    
                                @endphp

                                @include('mapbox', $mapbox)
                            </div>

                            <input type="hidden" name="usertype" id="usertype" value="{{ $user->usertype }}">

                            @if (!$isMaster)
                                <div id="userButtons" class="offer-actions d-flex flex-nowrap align-items-start mt-4">
                                    <x-form-submit class="ml-4 button-primary mr-4">
                                        Сохранить
                                    </x-form-submit>

                                    <button type="button" class="secondary"
                                        onclick="window.location.href='/logout'; return false;">
                                        Выйти
                                    </button>
                                </div>
                            @endif


                            <div class="card-body">
                                @if (!$isMaster)
                                    <h3 class="mt-4">Вы профессионал? </h3>
                                    <script>
                                        function showProfiFields() {
                                            document.getElementById('usertype').value = {{ App\Models\User::typeMaster }};

                                            $('#profiButton').hide();
                                            $('#profiFields').show('slow');
                                            // $('#userButtons').hide();
                                        }
                                    </script>

                                    <button type="button" id="profiButton" class="tertiary m-auto"
                                        onclick="showProfiFields();">Заполнить анкету профи</button>

                                @endif

                                <div id="profiFields" style="display: {{ $isMaster ? 'block' : 'none' }}">
                                    <div class="profi-fields">
                                        @include('auth.professional-fields')
                                    </div>


                                    <div class="form-group row mt-4">
                                        <label for="tagline" class="col-md-12">Краткое описание</label>
                                        <input id="tagline" name="tagline" label="Краткое описание" class="form-control block mt-1 w-full" type="text" 
                                        value="{{ $user->tagline ?? '' }}">
                                    </div>
                                    
                                    
                                    <div class="form-group row mt-2">
                                        <label for="tagline" class="col-md-12">Подробное описание</label>
                                        <textarea id="content" name="content" label="Подробное описание" class="form-control block mt-1 w-full" type="text" 
                                        style="height: 12rem;">{{ $user->content_raw ?? '' }}</textarea>
                                    </div>
                                    
                                    <div class="form-group row mt-2">
                                        <label for="tagline" class="col-md-12">Прайс-лист</label>
                                        <div class="form-hint">Для красивого оформления пишите по образцу:<br>
                                            'Навзвание услуги__100 sh/час'<br>
                                            <i>название услуги, два нижних подчеркивания, цена, sh</i>
                                        </div>
                                        <textarea id="pricelist" name="pricelist"  class="form-control block mt-1 w-full" type="text" 
                                        style="height: 12rem;">{{ $user->pricelist_raw ?? '' }}</textarea>
                                    </div>      
                                    
                                    <div class="form-group row mt-2">
                                        <label for="tagline" class="col-md-12">Галерея работ</label>
                                        <div class="form-hint">Вы можете закачать до 10 файлов размером не более 10Мб</i>
                                        </div>
                                    
                                        <form 
                                            action="/profile.gallery" 
                                            class="d-flex flex-wrap w-100 mb-4 mr-4" 
                                            id="formAvatar"
                                            method="POST"
                                            enctype="multipart/form-data"
                                        >
                                            @csrf
                                            
                                        <div class="button-secondary mt-3 mb-3 m-auto">
                                            <input type="file" id="fileAvatar" name="files[]"  accept="image/png, image/jpeg">    
                                        </div>
                                        </form>
                                    </div>      


                                    <div id="profiButtons" class="offer-actions d-flex flex-nowrap align-items-start">
                                        <x-form-submit class="ml-4 button-primary">
                                            Сохранить
                                        </x-form-submit>

                                        <button type="button" class="secondary ml-2" onclick="window.location.reload();">
                                            Отмена
                                        </button>
                                    </div>
                                </div>
                                
                            </div>

                        </x-form>
                    </div>



                @endauth
            </div>
        </div>
    @endsection
