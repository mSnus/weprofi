{{-- 
    uses:
        $persons
 --}}

<div class="users">
    @php
        $randomColors = ['#dff4ff', '#f6eaf8', '#eef8ea', '#f8f6ea', '#eaeef8', '#f9f3ef'];
        $randomColor = $randomColors[rand(0, count($randomColors)-1)];
    @endphp

    @foreach ($persons as $person)
        @php
            $tagline = $person->tagline ?? 'профи';

            if (mb_strlen($tagline) > 55) {
                $tagline = mb_substr($tagline, 0, 55).'...';
            }
            
            $hasAvatar = (intval($person->avatar) > 0);

            $prevColor = $randomColor;
            while ($randomColor == $prevColor) {
                $randomColor = $randomColors[rand(0, count($randomColors)-1)];
            }
        @endphp
        <div class="user" onclick="window.location.href='/user/{{ $person->user_id }}'">
            
            <div class="avatar" 
                style="background-image: url({{ $person->avatar ?? '/img/avatar.png' }}); background-color: {{ $randomColor }}"
            >
            </div>
            <div class="title">{{ $person->name }}</div>
            
            @if ($person->rating_count > 3)
                <div class="rating">
                    @for ($i = 1; $i <= $person->rating; $i++)
                        <img src="/img/star.svg" alt="star">
                    @endfor
                </div>    
            @endif
            
            <div class="tagline">{{ $tagline }}</div>
        </div>
    @endforeach
</div>