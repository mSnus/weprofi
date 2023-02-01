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

            <h1 onclick="window.location.href='/'"><img src=/img/left.svg width="16" height="16" class="cat-header__back" alt="back"> {!! $result !!}</h1>

            @include('components.search', ['term' => $term])


            {{-- результаты поиска --}}

            @php
                $somethingFound = (!is_null($persons) && count($persons)) || (!is_null($specs) && count($specs));
            @endphp

            @if ($somethingFound)
                <h3>Найдены категории:</h3>

                @if (!is_null($specs) && count($specs))
                    <div class="specs {{ (count($specs) < 4 ? ' single-column' : '') }}">
                    @foreach ($specs as $spec)
                        <div class="spec mb-2">
                            @if (!isset($spec->subspec_id))
                                <a href="/spec/{{ $spec->id }}/0/">{{ $spec->title }}</a>
                            @else
                                <a href="/spec/{{ $spec->id }}/{{ $spec->subspec_id }}">{{$spec->title}}: {{ $spec->subspec_title }}</a>
                            @endif
                            
                        </div>
                    @endforeach
                    </div>
                @else
                    <div class="mb-4">Категорий по слову <i> {{ $term }} </i> не найдено     </div>
                @endif

                @if (!is_null($persons) && count($persons))
                    <h3>Найдены профи:</h3>
                    @include('components.profi-list', $persons)
                @endif
            @else 
                По слову <i> {{ $term }} </i> ничего не найдено 
            @endif

        </div>
    </div>

    @include('components.register')

@endsection
