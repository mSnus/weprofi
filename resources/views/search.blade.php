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
                @include('components.profi-list', $persons)
            @endif

        </div>
    </div>

    @include('components.register')

@endsection
