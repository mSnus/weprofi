<!-- Name -->
<div>
	<x-form-input id="name" label="Телефон, используется для входа" class="block mt-1 w-full" type="text" name="name" :value="(Auth::user() && Auth::user()->id) ? Auth::user()->name : old('name')" required autofocus />
</div>

<!-- Email Address -->
<div class="mt-4">
	<x-form-input id="email" label="Email" class="block mt-1 w-full" type="email" name="email" :value="(is_object(Auth::user()) && Auth::user()->id) ? Auth::user()->email : old('email')" required />
</div>

@if (isset($password_required) && $password_required)
<!-- Password required -->
<div class="mt-4">
	<x-form-input id="password" label="Пароль {{(Auth::user() && Auth::user()->id) ? '(оставьте пустым, если не хотите менять)' : ''}}" class="block mt-1 w-full"
						 type="password"
						 name="password"
						 required autocomplete="new-password" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
	<x-form-input id="password_confirmation" label="Подтвердите пароль" class="block mt-1 w-full"
	type="password"
	name="password_confirmation" required
	/>
</div>
@else
<!-- Password optional -->
<div class="mt-4">
	<x-form-input id="password" label="Пароль {{(Auth::user() && Auth::user()->id) ? '(оставьте пустым, если не хотите менять)' : ''}}" class="block mt-1 w-full"
						 type="password"
						 name="password"
						  autocomplete="new-password" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
	<x-form-input id="password_confirmation" label="Подтвердите пароль" class="block mt-1 w-full"
	type="password"
	name="password_confirmation"
	/>
</div>
@endif

