<div class="d-flex justify-content-center">
    <div class="newoffer-form mr-4">
        <!-- Validation Errors -->
        @if ($errors->any())
				<div class="alert alert-danger">
					<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
					</ul>
				</div>
			@endif

        <form method="post" action="{{ route('offer.store') }}" id="formNewOffer" class="form-with-map">
            <!-- CROSS Site Request Forgery Protection -->
            @csrf
            <div class="mt-4">
                <x-form-input id="title" label="Какая у вас машина" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
            </div>
            <div class="mt-4">
                <x-form-textarea id="descr" label="Полное описание: что нужно починить" class="block mt-1 w-full" type="text" name="descr" required>{{ old('descr') }}</x-form-textarea>
            </div>
            <div class="mt-4">
                <x-form-input id="location" label="Где находится машина? Отметьте на карте" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
            </div>
				@auth

				@endauth

				@guest
            <div class="mt-4">
                <x-form-input id="fullname" label="Как к вам обращаться" class="block mt-1 w-full" type="text" name="fullname" :value="old('fullname')" autocomplete="name" required />
            </div>

            @include('auth.register-fields')
				@endguest

            <div class="d-flex items-center justify-end mt-4">
					@guest
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Уже зарегистрированы?') }}
                </a>
					 @endguest
                <x-form-submit class="ml-4">
                    Отправить заявку
                </x-form-submit>
            </div>
        </form>
    </div>
    @include('mapbox')
</div>