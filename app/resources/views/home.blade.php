@extends('layouts.app')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
	 {{ session('status') }}
</div>
@endif

<div class="container">
    <div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
						<div class="card-header">Доступные заказы:</div>

						<div class="card-body">
							<div class="offers-container">
								@foreach (App\Models\Offer::all() as $offer)
									<div class="offer">
										<x-form :action="route('master.respond', $offer->id)" class=" d-flex flex-nowrap">
											@method('PUT')

										<div class="offer-title">
											<b>{{ $offer->title }}</b>
											<br>
											{{ $offer->descr }}
										</div>
										<div class="offer-location">
											{{ $offer->location }}
										</div>

										<div class="offer-actions">
											<x-form-submit class="ml-4">
												Предложить свои услуги
										  </x-form-submit>
										</div>
										</x-form>
									</div>
								@endforeach
							</div>
					</div>
				</div>
			</div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ваши заказы</div>

                <div class="card-body">
						<div class="offers-container">
							@foreach (Auth::user()->offers() as $offer)
								{{ $offer->title }}
							@endforeach
						</div>
               </div>
            </div>
        </div>

    </div>
</div>
@endsection
