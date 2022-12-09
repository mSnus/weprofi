@extends('layouts.app')

@section('title', 'WeProfi')

@section('content')

    <div class="d-block text-center">
            <div class="user">
                <h1>{{ $user->title }}</h1>

                <div class="user">
                    <div class="avatar"><img src="{{ $user->avatar ?? '/img/avatar.png' }}" alt="User avatar"></div>
                    <div class="rating page">
                        @for ($i = 1; $i <= $user->rating; $i++)
                            <img src="/img/star.svg" alt="star">
                        @endfor
                    </div>                    
                    <div class="tagline page">{{ $user->tagline ?? 'профи' }}</div>
                    <div class="joindate">с нами с {{ $user->join_date }}</div>
                    <div class="description">{!! $user->content !!}</div>
                    <div class="pricelist">{!! $user->pricelist !!}</div>
                </div>

                @if (!is_null($gallery))
                    <div class="gallery">
                        @foreach ($gallery as $image)
                            <div class="gallery-image">
                                <img src="{{ $image->src }}" alt="gallery image" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
    </div>

    @include('components.register')
@endsection
