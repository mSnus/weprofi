@extends('layouts.app')

@section('title', 'WeProfi')

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
             $h1_link = (isset($subspec_id) && $subspec_id  > 0) ? '/spec/'.$spec_id : '/';
             $h1_pre = ((isset($spec_id) && $spec_id  > 0) || (isset($subspec_id) && $subspec_id  > 0)) ? '<img src=/img/left.svg width="16" height="16" class="cat-header__back">' : '';
            @endphp

            <h1 class="cat-header" onclick="window.location.href='{{ $h1_link }}'">{!! $h1_pre !!}&nbsp;{{ $spec->title }}</h1>

            @include('components.search')


            {{-- список категорий --}}

            @php
                $subspec_count = count($spec->subspecs);
            @endphp
            
            <div class="specs{{ ($subspec_count < 4 ? ' single-column' : '') }}">

                @if ($subspec_count > 0)
                    @foreach ($spec->subspecs as $subspec)
                        <div class="spec {{ $subspec->id == $subspec_id ? 'subspec-current' : ''}}">
                            <a href="/spec/{{ $spec->id }}/{{ $subspec->id }}">{{ $subspec->title }}</a>
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
