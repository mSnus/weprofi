<!-- Name -->
<div>
	<x-form-input id="name" label="Как вас зовут" class="block mt-1 w-full" type="text" name="name" :value="(Auth::user() && Auth::user()->id) ? Auth::user()->name : old('name')" required autofocus />
</div>

<!-- Телефон -->
<div class="mt-4">
	<x-form-input id="phone" label="Телефон" class="block mt-1 w-full" type="phone" name="phone" :value="(is_object(Auth::user()) && Auth::user()->id) ? Auth::user()->phone : old('phone')" required />
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

