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



            @php
                $spec = App\Models\Spec::where('id', $spec_id)->first();
            @endphp

            <div class="specs">
                <h1>{{ $spec->title }}</h1>

                <div class="search">
                    <input type="text" name="spec_search" id="specSearch">
                    <img src="/img/go.svg" alt="Search" width="32" height="32">
                </div>

                @if (!is_null($persons))
                    <div class="users">

                        @foreach ($persons as $person)
                            <div class="user" onclick="window.location.href='/user/{{ $person->user_id }}'">
                                {{ $person->title}}
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-result">Тут пока никого нет</div>
                @endif

            </div>

        </div>
    </div>
@endsection
