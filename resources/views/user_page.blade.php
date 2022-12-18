@extends('layouts.app')

@section('title', 'WeProfi')

@section('head')
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- slick carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
        integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- lightbox -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"
        integrity="sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css"
        integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $('.gallery').slick({
                infinite: false,
                dots: true,
                speed: 500
            })
        });
    </script>


    <!-- MapBox -->
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js'></script>
    <!-- Load the `mapbox-gl-geocoder` plugin. -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
@endsection

@section('content')

    @php
        $cities = App\Models\City::get()->sortByDesc('slug')->all();
        $user_cities = explode(',', $user->region);

        $city_list = [];
        foreach ($cities as $city) {
            if (in_array($city->slug, $user_cities)) {
                $city_list[] = $city->title;
            }
        }
    @endphp

    <div class="d-block text-center">
        <div class="user page">
            <h1 class="mb-0">{{ $user->name }}</h1>

            <div class="tagline page mt-0 mb-3">{{ join(', ', $city_list) }}</div>

            <div class="avatar" 
                style="background-image: url({{ $user->avatar ?? '/img/avatar.png' }})"
                alt="User avatar">
            </div>
            <div class="rating page">
                @for ($i = 1; $i <= $user->rating; $i++)
                    <img src="/img/star.svg" alt="star">
                @endfor
            </div>
            <div class="tagline page">{{ $user->tagline ?? 'профи' }}</div>
            <div class="joindate">с нами с {{ $user->join_date }}</div>
            @if (!empty($skills))
                <div class="skills">
                    {{ $skills }}
                </div>
            @endif

            <div class="description">{!! $user->content !!}</div>

            <div class="pricelist">{!! $user->pricelist !!}</div>

            @if (!is_null($gallery) && count($gallery) > 0)
                <div class="gallery" data-slick='{"slidesToShow": 3, "slidesToScroll": 1}'>
                    @foreach ($gallery as $image)
                        <div class="gallery-image">
                            <a href="{{ $image->src }}" data-lightbox="usergallery"><img src="{{ $image->src }}"
                                    alt="gallery image" /></a>
                        </div>
                    @endforeach
                </div>
            @endif

            @php
                $mapbox = ['no_autocenter' => true, 'height' => '100%'];
                
                $location = $user->location;
                
                if ($location != '') {
                    $lng = substr($location, 0, strpos($location, ','));
                    $lat = substr($location, strpos($location, ',') + 1);
                    $mapbox['lng'] = $lng;
                    $mapbox['lat'] = $lat;
                }

                $mapbox['id'] = 'map_' . $user->id;
                
            @endphp

            @include('mapbox_static', $mapbox)
        </div>
    </div>

    @guest
        <div class="register-block">
            <button class="primary" onclick="window.location.href='/login'">посмотреть контакт</button>
            <div class="need-registration">
                Для просмотра контактов необходимо <a href="/register">зарегистрироваться</a><br>
                 или <a href="/login">войти на сайт</a>
            </div>
        </div>
    @endguest

    @auth
    <div class="profi-contact" id="contact">
        <div class="button-primary" onclick="showContact()">посмотреть контакт</div>
    </div>

    <script>
        function showContact(){
            let div = document.getElementById('contact');
            div.innerHTML = `<div class="contact-phone">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" 
                width="32" height="32" 
                viewBox="0 0 1280.000000 1280.000000" preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)" fill="#68828d" stroke="none">
                <path d="M4202 11749 c-171 -22 -300 -87 -428 -214 -75 -74 -99 -106 -136 -182 -26 -50 -55 -127 -65 -170 -17 -75 -18 -257 -18 -4788 0 -4487 1 -4713 18 -4780 10 -38 38 -113 64 -165 39 -80 59 -108 137 -185 76 -76 106 -99 186 -138 183 -90 -52 -82 2440 -82 2492 0 2257 -8 2440 82 80 39 110 62 186 138 78 77 98 105 137 185 26 52 54 127 64 165 17 67 18 293 18 4785 0 4492 -1 4718 -18 4785 -10 39 -38 113 -64 165 -39 80 -59 108 -137 185 -103 103 -199 160 -333 198 l-78 22 -2175 1 c-1196 1 -2203 -2 -2238 -7z m2686 -701 c18 -18 15 -94 -4 -112 -14 -14 -71 -16 -484 -16 -413 0 -470 2 -484 16 -19 18 -22 94 -4 112 17 17 959 17 976 0z m1852 -4648 l0 -3810 -2340 0 -2340 0 0 3810 0 3810 2340 0 2340 0 0 -3810z m-2270 -4141 c196 -31 349 -185 382 -383 37 -225 -113 -452 -337 -511 -260 -67 -520 103 -566 371 -41 239 132 483 371 523 76 12 77 12 150 0z"/>
                </g>
                </svg>
                {{ $user->phone }}
                </div>
            <div class="button-primary" onclick="callPhone('{{ $user->phone }}')">позвонить</div>`
        }

        function callPhone(phone) {
            window.location.href='tel://'+phone.replace('[^0-9\+]','');
        }
    </script>
    @endauth
@endsection
