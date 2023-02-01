{{-- блок регистрации --}}
@guest
<div class="register-block">
    <button class="primary" onclick="window.location.href='/register'">Регистрация</button>
    <div class="already-registered" onclick="window.location.href='/login'">Я уже с вами (Вход)</div>
</div>
@endguest