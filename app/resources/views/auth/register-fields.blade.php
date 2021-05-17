<!-- Name -->
<div>
	<x-label for="name" :value="__('Телефон, используется для входа')" />

	<x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
</div>

<!-- Email Address -->
<div class="mt-4">
	<x-label for="email" :value="__('Email')" />

	<x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
</div>

<!-- Password -->
<div class="mt-4">
	<x-label for="password" :value="__('Пароль')" />

	<x-input id="password" class="block mt-1 w-full"
						 type="password"
						 name="password"
						 required autocomplete="new-password" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
	<x-label for="password_confirmation" :value="__('Подтвердите пароль')" />

	<x-input id="password_confirmation" class="block mt-1 w-full"
						 type="password"
						 name="password_confirmation" required />
</div>

