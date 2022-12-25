@php
    $menupoints = [
        'main' => (object)['title' => 'Основные данные', 'link' => '/profile'],
        'feedback' =>  (object)['title' => 'Отзывы', 'link' => '/home'],
    ];
@endphp

<div class="profile-navigation">
@foreach ($menupoints as $menukey => $menupoint)

    @if ( $menukey == $section )
        <div class="profile-navigation__section-current">
            {{ $menupoint->title }}
        </div>
    @else
        <div class="profile-navigation__section">
            <a href="{{ $menupoint->link}}">{{ $menupoint->title}}</a>
        </div>
    @endif    

    @endforeach
</div>
