<!-- Name -->
<div>
	<x-form-input id="name" label="Телефон, используется для входа" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
</div>

<!-- Email Address -->
<div class="mt-4">
	<x-form-input id="email" label="Email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
</div>

<!-- Password -->
<div class="mt-4">
	<x-form-input id="password" label="Пароль" class="block mt-1 w-full"
						 type="password"
						 name="password"
						 required autocomplete="new-password" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
	<x-form-input id="password_confirmation" label="Подтвердите пароль" class="block mt-1 w-full"
						 type="password"
						 name="password_confirmation" required />
</div>

