<!-- Name -->
<div>
	<x-form-input id="name" label="Как вас зовут" class="block mt-1 w-full" type="text" name="name" :value="(Auth::user() && Auth::user()->id) ? Auth::user()->name : old('name')" required autofocus />
</div>

<!-- Телефон -->
<div class="mt-4">
	<x-form-input id="phone" label="Телефон" class="block mt-1 w-full" type="phone" name="phone" :value="(is_object(Auth::user()) && Auth::user()->id) ? Auth::user()->phone : old('phone')" required />
</div>

@if (isset($isMaster) && $isMaster) 
<div class="mt-0 mb-4 form-checks">
	<div>на этом номере</div>
	<input type="checkbox" name="is_whatsapp" class="form-check-input" value="1"  {{ isset($user->is_whatsapp) && ($user->is_whatsapp==1) ? ' checked' : ''}}>
	<label for="is_whatsapp">есть Whatsapp</label>
	<input type="checkbox" name="is_telegram" class="form-check-input" value="1"  {{ isset($user->is_telegram) && ($user->is_telegram==1) ? ' checked' : ''}}>
	<label for="is_whatsapp">есть Telegram</label>
</div>

<div class="mt-4">
	<x-form-input id="phone2" label="Второй телефон (если есть)" class="block mt-1 w-full" type="phone" name="phone2" :value="(is_object(Auth::user()) && Auth::user()->id) ? Auth::user()->phone2 : old('phone2')" />
</div>

<div class="mt-0 mb-4 form-checks">
	<div>на этом номере</div>
	<input type="checkbox" name="is_whatsapp2" class="form-check-input" value="1"  {{ isset($user->is_whatsapp2) && ($user->is_whatsapp2==1) ? ' checked' : ''}}>
	<label for="is_whatsapp2">есть Whatsapp</label>
	<input type="checkbox" name="is_telegram2" class="form-check-input" value="1"  {{ isset($user->is_telegram2) && ($user->is_telegram2==1) ? ' checked' : ''}}>
	<label for="is_whatsapp2">есть Telegram</label>
</div>
@endif

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

