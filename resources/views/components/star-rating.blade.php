@php
    $star_value = isset($star_rating) ? $star_rating : 5;
@endphp

@for ($i = 1; $i <= 5; $i++)
    @php 
        $src = ($i <= $star_value) ? '/img/star.svg' : '/img/star_off.svg'; 
    @endphp

    <img src="{{ $src }}" width="32" alt="star" id="feedbackStar{{ $i }}" onclick="setRating({{ $i }})">
@endfor