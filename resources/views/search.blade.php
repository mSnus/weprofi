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

            <h1 onclick="window.location.href='/'">{!! $result !!}</h1>

            @include('components.search', ['term' => $term])


            {{-- результаты поиска --}}


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
            @endif

        </div>
    </div>

    @include('components.register')

@endsection
