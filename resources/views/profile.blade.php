@extends('layouts.app')

@section('head')
    <!-- MapBox -->
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js'></script>
    <!-- Load the `mapbox-gl-geocoder` plugin. -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css"
        type="text/css">
    <script src="{{ asset('js/uploads.js') }}"></script>
    <script src="{{ asset('js/gallery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if (session('status_html'))
        <div class="status-message" role="alert">
            {!! session('status_html') !!}
        </div>
    @endif

    @php
        $profileData = App\Models\User::getData(Auth::id());
        $user = $profileData['user'];
        $gallery = $profileData['gallery'];
        $isMaster = $user->usertype == App\Models\User::typeMaster;

        $stats = App\Models\UserStats::firstOrNew(['user_id' => $user->id]);
        $stats->own_profile_visits = $stats->own_profile_visits+1;
        $stats->save();
    @endphp

    <div class="container profile">
        <div class="row justify-content-center">
            @auth
                <div class="col-md-12 p-0">
                    @if ($isMaster)
                        @include('components.profile_navigation', ['section' => 'main'])
                    @else
                        <h1>Основные данные:</h1>
                    @endif

                    

                    <div class="w-100">
                            <div class="avatar-container" id="avatar"></div>
                        <input type="file" id="fileAvatar" name="files[]" style="visibility: hidden;"
                                accept="image/png, image/jpeg">
                    </div>

                    <script>
                        window._csrf_token = '{{ csrf_token() }}';                       
                    </script>

                    <form action="/profile.gallery" class="d-flex flex-wrap" style="visibility: hidden" id="formGallery"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="fileGallery" style="visibility: hidden;" name="files[]"
                            accept="image/png, image/jpeg" multiple>

                    </form>
                    

                    <div class="card-body d-flex flex-nowrap profile-body">
                        <x-form :action="'/profile.update/' . $user->id" class=" d-flex flex-wrap w-100 mb-4 mr-4 form-with-map form-profile">
                            @method('POST')
                            @csrf

                            @include('auth.register-fields', ['password_required' => false])

                            <div class="mt-4 col-form-label">Карта</div>

                            <div class="mt-2 profile-important-hint">
                                Вы можете отметить своё местоположение на карте. <br>
                                Покажите карту и подвиньте метку на нужное место:
                            </div>

                            <div class="mt-2" id='mapToggler' {!! isset($user->is_show_map) && ($user->is_show_map==1) ? '' : 'style="display:none;"'!!}>
                                <input id="location" label="Где вы находитесь? Отметьте на карте" type="hidden"
                                    name="location" :value="old('location')" />

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

                            <div class="mt-2 mb-4 form-checks">
                                <input 
                                    type="checkbox" 
                                    name="is_show_map" 
                                    id="isShowMap"
                                    class="form-check-input" 
                                    value="1" 
                                    {{ isset($user->is_show_map) && ($user->is_show_map==1) ? ' checked' : ''}}
                                    onclick="if (this.checked) {$('#mapToggler').show(); window.$maps[0].resize();} else {$('#mapToggler').hide()}"
                                >
                                <label for="is_show_map">показывать карту</label>
                            </div>

                            <input type="hidden" name="usertype" id="usertype" value="{{ $user->usertype }}">

                            @if (!$isMaster)
                                <div id="userButtons" class="offer-actions d-flex flex-nowrap align-items-start justify-content-center mt-4">
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
                                    <div class="col-md-10 price-warning">
                                        {{ Setting::get('text_free_period') }}
                                    </div>
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
                                        <input id="tagline" name="tagline" label="Краткое описание"
                                            class="form-control block mt-1 w-full" type="text"
                                            value="{{ $user->tagline ?? '' }}">
                                    </div>


                                    <div class="form-group row mt-2">
                                        <label for="tagline" class="col-md-12 mt-4">Подробное описание</label>
                                        <textarea id="content" name="content" label="Подробное описание" class="form-control block mt-1 w-full" type="text"
                                            style="height: 12rem;">{{ $user->content_raw ?? '' }}</textarea>
                                    </div>

                                    <div class="form-group row mt-2">
                                        <label for="tagline" class="col-md-12">Прайс-лист</label>
                                        <div class="form-hint">Для красивого оформления прайса пишите по шаблону:<br>
                                            'Название услуги__100 sh/час'<br>
                                            <i>название услуги, два нижних подчеркивания, цена, sh</i>
                                        </div>
                                        <textarea id="pricelist" name="pricelist" class="form-control block mt-1 w-full" type="text" style="height: 8rem;">{{ $user->pricelist_raw ?? '' }}</textarea>
                                    </div>

                                    <div class="form-group row mt-4">
                                        <label for="tagline" class="col-md-12 mt-4"><h2>Галерея работ</h2></label>
                                        <div class="form-hint">Вы можете закачать до 10 файлов размером не более 10Мб</i>
                                        </div>

                                        <div class="gallery" id="gallery"></div>            

                                        <div class="button-tertiary mt-3 mb-3 m-auto" onclick="selectAndUploadGallery('fileGallery')">
                                            Выбрать и закачать файлы
                                        </div>
                                    </div>

                                    <div class="form-group row mt-2">
                                        <label for="tagline" class="col-md-12">График работы</label>
                                        <textarea id="timetable" name="timetable" class="form-control block mt-1 w-full" type="text" style="height: 8rem;">{{ $user->timetable ?? '' }}</textarea>
                                    </div>

                                    <div id="profiButtons" class="button-block">
                                        <x-form-submit class="button-primary">
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
