@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @php
        $feedbacks = App\Models\UserFeedback::getFeedbackList(Auth::id());
    @endphp

    @auth
    <div class="container">
        <div class="row justify-content-center">
                <div class="col-md-12">
                    @if (Auth::user()->isMaster())
                        @include('components.profile_navigation', ['section' => 'feedback'])
                    @else
                        <h1>Основные данные:</h1>
                    @endif
                    
                    @if (count($feedbacks) > 0)
                        @foreach ($feedbacks as $feedback)
                            <div class="feedback-list">
                                <div class="feedback-name">{{ $feedback->name }} :</div>

                                <div class="feedback-date">
                                    {{ date('d-m-Y', strtotime($feedback->updated_at)) }}
                                </div>

                                <div>
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php 
                                            $src = ($i <= $feedback->value) ? '/img/star.svg' : '/img/star_off.svg'; 
                                        @endphp
                    
                                        <img src="{{ $src }}" width="16" alt="star" id="feedbackStar{{ $i }}">
                                    @endfor
                                </div>

                                <div class="feedback-content">
                                    {{ $feedback->content}}
                                </div>

                            </div>    
                        @endforeach    
                    @else
                        Пока никто не оставлял о вас отзывы...
                    @endif
                    
                    
            </div>
        </div>
    @endauth    
    @endsection
