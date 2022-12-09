<script src="{{ asset('js/suggestions.js') }}"></script>
<div class="d-flex justify-content-center">
				@if (isset($mode) && $mode == 'edit')
				<h3>Редактирование заявки:</h3>
				@else

				@endif

</div>

<div class="d-flex justify-content-center section-requests">

	 <div class="newoffer-form mr-0">
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

		<form method="post" action="{{ (isset($mode) && $mode == 'edit') ? route('offer.update', $offer_id) : route('offer.store') }}" id="formNewOffer" class="form-with-map">
			 <!-- CROSS Site Request Forgery Protection -->
			 @csrf
			 @if (isset($mode) && $mode == 'edit')
				 @method('PUT')
			 @endif


			 <div class="h1">Мы - профи. Кто вам нужен?</div>
			 <div class="subhead">начните печатать, а мы попробуем угадать и подсказать</div>

			 @php
				$specs = App\Models\Spec::get()->all(); 
			 @endphp
			 @foreach ($specs as $spec)
				 <div class="spec">{{ $spec->title}} </div>
			 @endforeach


			 <div class="mt-4">
				  <x-form-textarea id="descr"  class="block mt-1 w-full predictable" type="text" name="descr" required>{{ (isset($mode) && $mode == 'edit') ? $offer_descr : old('descr') }}</x-form-textarea>
			 </div>

			 <div class="suggestions-list" id="suggestions-descr">
			</div>

			 <div class="hints" data-realtarget="descr">
				<div class="hint" data-realvalue="Домашний ремонт / сантехника">Домашний ремонт / сантехника</div>
				<div class="hint" data-realvalue="Ремонт авто">Ремонт авто</div>
				<div class="hint" data-realvalue="Красота и здоровье">Красота и здоровье</div>
				<div class="hint" data-realvalue="Перевод">Перевод</div>
				<div class="hint" data-realvalue="Няни / сиделки">Няни / сиделки</div>
				<div class="hint" data-realvalue="Репетитор">Репетитор</div>
				<div class="hint" data-realvalue="Нотариус">Нотариус</div>
				<div class="hint" data-realvalue="Маклер">Маклер</div>
				<div class="hint" data-realvalue="Страховка">Страховка</div>
				<div class="hint" data-realvalue="Ремонт компьютеров и телефонов">Ремонт компьютеров и телефонов</div>
				<div class="hint" data-realvalue="Уборка">Уборка</div>
				<div class="hint" data-realvalue="Доставка">Доставка</div>
				<div class="hint" data-realvalue="Разнорабочие">Разнорабочие</div>
			</div>


			 <div class="mt-4">
				  <x-form-input id="location" type="hidden" name="location" :value="old('location')" required />
			 </div>

			 @guest

			 <h3>Как с вами связаться?</h3>
			 <div class="subhead">имя и фамилия, ваш телефон и Телеграм</div>

			 <div class="mt-4">
				  <x-form-input id="fullname" placeholder="Как к вам обращаться?" class="block mt-1 w-full" type="text" name="fullname" :value="old('fullname')" autocomplete="name" required />
			 </div>

			 <div class="mt-4">
				<x-form-input id="name" placeholder="Номер телефона (+7 xxx xxx-xxxx)" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autocomplete="phone" required />
		  	</div>

			 <p class="subhead">наш бот пришлёт пароль и известит об откликах Мастеров:</p>
			 <p><a href="https://telegram.me/PochinimOnline_bot?start=welcome"><img src="/img/telegram.png" width="200"></a></p>

			 @endguest

			 <div class="d-flex justify-content-end mt-4 align-items-center">
				 @guest
				  <a class="pt-3 pr-3" href="{{ route('login') }}">
						{{ __('Уже зарегистрированы?') }}
				  </a>
				  @endguest

				   @if (isset($mode) && $mode == 'edit')
				  		<x-form-submit class="ml-4">
						 	Сохранить
						</x-form-submit>
					@else
						<img src="/img/big_request.png" onclick="submit();" style="width: 217px; cursor: pointer;">
					 @endif

			 </div>

			 <div class="map-container">
				<h3>Где вы находитесь?</h3>
				<div class="subhead">поставьте точку на карте</div>
				 @include('mapbox')
			</div>
		</form>
  </div>
</div>

