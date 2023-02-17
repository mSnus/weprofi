@extends('layouts.app')

@section('title', 'WeProfi - '.$spec->title)

@section('head')
<script src="{{ asset('js/path.js') }}"></script>
@endsection

@section('content')

{{--
    uses:
        $spec_id
        $subspec_id
        $persons
 --}}

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

            @php
             $h1_link = (isset($subspec_id) && $subspec_id  > 0) ? '/spec/'.$spec_id.'/0/' : '/';
             $h1_pre = ((isset($spec_id) && $spec_id  > 0) || (isset($subspec_id) && $subspec_id  > 0))
                            ? '<img src=/img/left.svg width="16" height="16" class="cat-header__back" alt="back">'
                            : '';
            @endphp

            <h1 class="cat-header" onclick="window.location.href='{{ $h1_link }}'">{!! $h1_pre !!}&nbsp;{{ $spec->title }} <img src="/img/icons/{{$spec->icon}}" class="subspec-icon"></h1>

            @include('components.search', ['spec' => $spec_id ?? 0, 'subspec' => $subspec_id ?? 0])


            {{-- список категорий --}}

            @php
                $subspec_count = count( (array) $subspecs);
            @endphp

            <div class="specs{{ ($subspec_count < 4 ? ' single-column' : '') }}">

                @if ($subspec_count > 0)
                    @foreach ($subspecs as $subspec)
                        <div class="spec {{ $subspec->id == $subspec_id ? 'subspec-current' : ''}}">
                            <a
                            href="#"
                            onclick="goPath( event, {{$spec->id}}, {{$subspec->id}} )"
                            >{{ $subspec->subspec_title }}</a>
                        </div>
                    @endforeach
                @endif

            </div>

            @if (!is_null($persons) && count($persons))
                @include('components.profi-list', $persons)
            @else
                <div class="empty-result">
                    Тут пока никого нет.
                </div>
                <div class="empty-result__text">{{ Setting::get('text_empty_category') }}</div>
            @endif

        </div>
    </div>

    @include('components.register')

@endsection
