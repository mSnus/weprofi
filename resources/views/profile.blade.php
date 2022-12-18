@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
        
    @php
        $user = Auth::user();
    @endphp

    <div class="container profile">
        <div class="row justify-content-center">
            @auth
                <div class="col-md-12">
                    <h1>Основные данные:</h1>

                    <div class="w-100">
                        <div class="avatar"><img src="{{ $user->avatar ?? '/img/avatar.png' }}" alt="User avatar"></div>
                    </div>

                    <div class="card-body d-flex flex-nowrap">
                        <x-form :action="'/profile.update/'.$user->id" class=" d-flex flex-wrap w-100 mb-4 mr-4 form-with-map form-profile">
                            @method('POST')

                            @include('auth.register-fields', ['password_required' => false])

                            <div class="mt-2">
                                <x-form-input id="location" label="Где вы находитесь? Отметьте на карте"
                                    class="block mt-1 w-full" type="text" name="location" :value="old('location')" />

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

                            @if (!$user->isMaster())
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
                                @if (!$user->isMaster())
                                    <h3 class="mt-4">Вы профессионал? {{ $user->isMaster() ? ' да, вижу' : ' увы, нет' }}</h3>
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

                                <div id="profiFields" style="display: {{ $user->isMaster() ? 'block' : 'none' }}">
                                    <div class="profi-fields">
                                        @include('auth.professional-fields')
                                    </div>

                                    <div id="profiButtons" class="offer-actions d-flex flex-nowrap align-items-start">
                                        <x-form-submit class="ml-4 button-primary">
                                            Сохранить
                                        </x-form-submit>

                                        <button type="button" class="secondary" onclick="window.location.reload();">
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
