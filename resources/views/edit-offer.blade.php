@extends('layouts.app')

@section('title', 'Редактирование заявки - Починим.Онлайн')

@section('content')


    <div class="container d-flex justify-content-center">
        <div class="flex shadow p-3 mb-5 bg-white rounded">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Auth::user() && Auth::user()->isClient())
                <!-- регистрация клиента и новая заявка -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
					@endif

					@php
							$mapbox = ['no_autocenter' => true, 'height' => '100%'];
						  	$offer = \App\Models\Offer::find($offer_id);
							$location = $offer->location;

							if ($location != '') {
								$lng = substr($location, 0, strpos($location, ','));
								$lat = substr($location, strpos($location, ',') + 1);
								$mapbox['lng'] = $lng;
								$mapbox['lat'] = $lat;
							}

					@endphp
               @include('requests', ['password_required' => false, 'mapbox' => $mapbox, 'mode'=>'edit', 'offer_title' => $offer->title, 'offer_descr' => $offer->descr, 'offer_id' => $offer_id])



            @endif
        </div>
    </div>
@endsection
