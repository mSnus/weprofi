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
@endsection

@section('content')

    <div class="d-block text-center">
        <div class="user page">
            <h1>{{ $user->title }}</h1>

            <div class="avatar"><img src="{{ $user->avatar ?? '/img/avatar.png' }}" alt="User avatar"></div>
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

            @if (!is_null($gallery))
                <div class="gallery" data-slick='{"slidesToShow": 3, "slidesToScroll": 1}'>
                    @foreach ($gallery as $image)
                        <div class="gallery-image">
                            <a href="{{ $image->src }}" data-lightbox="usergallery"><img src="{{ $image->src }}"
                                    alt="gallery image" /></a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @guest
        <div class="register-block">
            <button class="primary" onclick="window.location.href='/register'">посмотреть контакт</button>
            <div class="need-registration">
                Для просмотра контактов необходимо <a href="/register">зарегистрироваться</a> или <a href="/login">войти на
                    сайт</a>
            </div>
        </div>
    @endguest
@endsection
