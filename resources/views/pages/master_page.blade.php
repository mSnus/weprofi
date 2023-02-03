@extends('layouts.app')

@section('title', 'WeProfi')

@section('head')
    <!-- blade:master_page -->

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
                speed: 500,
                swipeToSlide: true
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
            >
            </div>
            
            @if ($user->rating_count > 3)
            <div class="rating page">
                @for ($i = 1; $i <= $user->rating; $i++)
                    <img src="/img/star.svg" alt="star">
                @endfor
            </div>    
            @endif
        
            <div class="tagline page">{{ $user->tagline ?? 'профи' }}</div>
            <div class="joindate">с нами с {{ $user->join_date }}</div>
            @if (!empty($skills))
                <div class="skills">
                    {{ $skills }}
                </div>
            @endif

            <div class="description">{!! $user->content !!}</div>

            <div class="pricelist">{!! $user->pricelist !!}</div>

            @if (!empty($user->timetable))
                <div class="h4">График работы:</div>
                <div class="timetable">{!! $user->timetable !!}</div>    
            @endif
            

            @if (!is_null($gallery) && count($gallery) > 0)
                <div class="gallery" data-slick='{"slidesToShow": 3, "slidesToScroll": 1}'>
                    @foreach ($gallery as $image)
                        <div class="gallery-image">
                            <a href="{{ $image->src }}" data-lightbox="usergallery"><img src="{{ $image->thumb }}"
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

            @if (isset($user->is_show_map) && ($user->is_show_map == 1)) 
                @include('mapbox_static', $mapbox)
            @endif
        </div>
    </div>

    @guest
        <div class="register-block">
            <button class="primary" onclick="window.location.href='/login?return=user/{{ $user->id }}'">Посмотреть&nbsp;контакт</button>
            <div class="need-registration">
                Для просмотра контактов необходимо <a href="/register">зарегистрироваться</a><br>
                 или <a href="/login">войти на сайт</a>
            </div>
        </div>
    @endguest

    @auth
    <div class="profi-contact" id="contact">
        <div class="button-primary" onclick="showContact()">Посмотреть&nbsp;контакт</div>
    </div>

    @if ($user->id != Auth::id())
        <div class="profi-feedback" id="feedback">
            <div class="button-tertiary" onclick="showFeedback()">Оставить отзыв</div>
        </div>    
    @endif
    

    <div class="profi-feedback__form" style="display: none;">
        <form id="feedbackForm" class="form-group" action="/feedback/{{ $user_id }}" method="POST">
            @csrf

            <div class="feedback-stars" id="feedbackStars">
                @for ($i = 1; $i <= 5; $i++)
                    @php 
                        $src = ($i <= $feedback->value) ? '/img/star.svg' : '/img/star_off.svg'; 
                    @endphp

                    <img src="{{ $src }}" width="32" alt="star" id="feedbackStar{{ $i }}" onclick="setRating({{ $i }})">
                @endfor
            </div>

            <input type="hidden" name="feedback_rating" id="feedbackRating" value="5">

            <label for="feedbackForm">Вы можете написать, что вам понравилось или не понравилось:</label>

            <textarea name="feedback_text" id="feedbackText" class="form-control block mt-1 w-full" cols="30" rows="10"
            >{{ $feedback->content }}</textarea>

            <button type="submit" class="button-primary">Отправить отзыв</button>
        </form>
    </div>

    <script>
        function showContact(){
            let div = document.getElementById('contact');
            div.innerHTML = `
            <div class="col-md-10 tell-about-us-warning">
                {{ Setting::get('text_tell_about_us') }}
            </div>

            <div class="contact-phone"  onclick="callPhone('{{ $user->phone }}')">
                0{{ $user->phone }}
            </div>

            <div class="button-primary" onclick="callPhone('{{ $user->phone }}')">
                Позвонить
            </div>

            @if (isset($user->is_whatsapp) && ($user->is_whatsapp == 1)) 
                <div class="button-whatsapp" onclick="tryWhatsapp('{{ $user->phone }}')">WhatsApp</div>
            @endif

            @if (isset($user->is_telegram) && ($user->is_telegram == 1)) 
                <div class="button-telegram" onclick="tryTelegram('{{ $user->phone }}')">Telegram</div>
            @endif
            
            @if (isset($user->phone2) && !empty($user->phone2)) 
            
                <div class="contact-phone"  onclick="callPhone('{{ $user->phone2 }}')">
                    <img src="/img/phone.svg" width="24" height="24">
                    {{ $user->phone2 }}
                </div>                    

                <div class="button-primary" onclick="callPhone('{{ $user->phone2 }}')">Позвонить</div>

                @if (isset($user->is_whatsapp2) && ($user->is_whatsapp2 == 1)) 
                    <div class="button-whatsapp" onclick="tryWhatsapp('{{ $user->phone2 }}')">WhatsApp</div>
                @endif
                
                @if (isset($user->is_telegram2) && ($user->is_telegram2 == 1)) 
                    <div class="button-telegram" onclick="tryTelegram('{{ $user->phone2 }}')">Telegram</div>
                @endif
            @endif
            `
        }

        function callPhone(phone) {
            window.location.href='tel:'+phone.replace('[^0-9\+]','');
        }

        function tryWhatsapp(phone) {
            let waPhone = phone.replace('[^0-9\+]','');
            
            if (phone.substring(0,3) !== '972') {
                if (phone.substring(0,1) === '0'){
                    waPhone = phone.substring(1);
                }
                waPhone = "972" + waPhone;
            } 
            
            window.open('https://api.whatsapp.com/send?phone='+waPhone, '_blank');
        }

        function tryTelegram(phone) {
            let tgPhone = phone.replace('[^0-9\+]','');
            
            if (phone.substring(0,3) !== '972') {
                if (phone.substring(0,1) === '0'){
                    tgPhone = phone.substring(1);
                }
                tgPhone = "972" + tgPhone;
            } 
            
            window.open('https://t.me/+'+tgPhone, '_blank');
        }

        function showFeedback() {
            $('.profi-feedback').hide('slow');
            $('.profi-feedback__form').show('slow');
        }

        function setRating(newValue) {
            console.log(newValue);
            $('#feedbackForm #feedbackRating').val(newValue);

            for (let i = 1; i <= 5; i++){
                const src = (i <= newValue) ? '/img/star.svg' : '/img/star_off.svg';
                $('#feedbackForm #feedbackStar' + i)[0].src = src;
            }
        }
    </script>
    @endauth
@endsection
