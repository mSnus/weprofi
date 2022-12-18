@extends('layouts.app')

@section('title', 'WeProfi')

@section('content')

    <div class="d-flex justify-content-center section-requests">

        <div class="newoffer-form mr-0">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- поиск --}}

            <h1 onclick="window.location.href='/'">{{ $spec->title }}</h1>

            @include('components.search')


            {{-- список категорий --}}

            @php
                $subspec_count = count($spec->subspecs);
            @endphp
            
            <div class="specs{{ ($subspec_count < 4 ? ' single-column' : '') }}">

                @if ($subspec_count > 0)
                    @foreach ($spec->subspecs as $subspec)
                        <div class="spec"><a
                                href="/spec/{{ $spec->id }}/{{ $subspec->id }}">{{ $subspec->title }}</a></div>
                    @endforeach
                @endif

            </div>

            @if (!is_null($persons) && count($persons))
                <div class="users">

                    @foreach ($persons as $person)
                        <div class="user" onclick="window.location.href='/user/{{ $person->user_id }}'">
                            
                            <div class="avatar" 
                                style="background-image: url({{ $person->avatar ?? '/img/avatar.png' }})"
                                 alt="User avatar">
                            </div>
                            <div class="title">{{ $person->name }}</div>
                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <img src="/img/star.svg" alt="star">
                                @endfor
                            </div>
                            <div class="tagline">{{ $person->tagline ?? 'профи' }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-result">Тут пока никого нет</div>
            @endif

        </div>
    </div>

    @include('components.register')

@endsection
