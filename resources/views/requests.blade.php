<script src="{{ asset('js/suggestions.js') }}"></script>
<div class="d-flex justify-content-center">
				@if (isset($mode) && $mode == 'edit')
				<h3>Редактирование заявки:</h3>
				@else

				@endif

</div>

<div class="d-flex justify-content-center section-requests">

    <div class="map-container">
		<h3>Где находится машина?</h3>
		<div class="subhead">поставьте точку на карте</div>
		 @include('mapbox')
	</div>

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

			 <h3>Какая у вас машина?</h3>
			 <div class="subhead">начните вводить марку и модель</div>

			 <div class="mt-4">
				  <x-form-input id="title" placeholder="Марка и модель"  class="block mt-1 w-full predictable" type="text" name="title" :value="(isset($mode) && $mode == 'edit') ? $offer_title : old('title')" required autocomplete="off"/>
			 </div>

			 <div class="suggestions-list" id="suggestions-title">
			 </div>

			 <div class="hints" data-realtarget="title">
				<div class="hint"data-realvalue="легковая">легковая</div>
				<div class="hint"data-realvalue="грузовая">грузовая</div>
				<div class="hint"data-realvalue="кран">кран</div>
				<div class="hint"data-realvalue="автобус">автобус</div>
				<div class="hint"data-realvalue="минивэн">минивэн</div>
				<div class="hint"data-realvalue="Hyundai Solaris">Hyundai Solaris</div>
				<div class="hint"data-realvalue="Volkswagen Polo">VW Polo</div>
				<div class="hint"data-realvalue="Kia">Kia Magentis</div>
				<div class="hint"data-realvalue="Ford Focus">Ford Focus</div>
				<div class="hint"data-realvalue="Газель тентованная">Газель</div>
				<div class="hint"data-realvalue="Mitsubishi Canter">Mitsu Canter</div>
				<div class="hint"data-realvalue="Mercedes-Benz Sprinter">MB Sprinter</div>
				<div class="hint"data-realvalue="Автобус  Икарус">Икарус</div>
				<div class="hint"data-realvalue="Автобус Neoplan">Neoplan</div>
			 </div>

			 <h3>Что надо починить?</h3>
			 <div class="subhead">начните печатать, а мы попробуем угадать и подсказать</div>

			 <div class="mt-4">
				  <x-form-textarea id="descr"  class="block mt-1 w-full predictable" type="text" name="descr" required>{{ (isset($mode) && $mode == 'edit') ? $offer_descr : old('descr') }}</x-form-textarea>
			 </div>

			 <div class="suggestions-list" id="suggestions-descr">
			</div>

			 <div class="hints" data-realtarget="descr">
				<div class="hint" data-realvalue="ремень ГРМ">ремень ГРМ</div>
				<div class="hint" data-realvalue="заменить колодки">заменить колодки</div>
				<div class="hint" data-realvalue="прокачать тормоза">прокачать тормоза</div>
				<div class="hint" data-realvalue="починить пробитое колесо">пробитое колесо</div>
				<div class="hint" data-realvalue="грузовой шиномонтаж">грузовой шиномонтаж</div>
				<div class="hint" data-realvalue="нужен эвакуатор">нужен эвакуатор</div>
				<div class="hint" data-realvalue="заменить свечи">заменить свечи</div>
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
		</form>
  </div>
</div>

