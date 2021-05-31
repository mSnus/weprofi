@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
                @if (Auth::user() && Auth::user()->isMaster())
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Доступные заказы:</div>

                            <div class="card-body">
                                <div class="offers-container">
                                    @foreach (App\Models\Offer::get() as $offer)
                                        <div class="offer">


                                            <div class="offer-title">
                                                <b>{{ $offer->title }}</b> <i>{{ $offer->owner_title }}</i>
                                                <br>

                                                @php
                                                    $masters = $offer->masters;

                                                    $btnClass = $masters->contains('userid', Auth::user()->id) ? 'btn-outline-success' : 'btn-success';

                                                @endphp

                                            </div>


                                            <div class="offer-actions d-flex flex-nowrap align-items-start">
                                                <a class="ml-4 btn {{ $btnClass }}" data-toggle="modal" data-target="#offerModal_{{ $offer->id }}">
                                                    Посмотреть
                                                </a>
                                            </div>


                                        </div>
                                        <!-- Modal: {{ $offer->id }} -->
                                        <div class="modal fade" id="offerModal_{{ $offer->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">{{ $offer->title }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ $offer->descr }}
                                                        <br><br>

																		  @php
																				$mapbox = ['no_autocenter' => true, 'height' => '100%'];

																				$location = $offer->location;

																				if ($location != '') {
																					 $lng = substr($location, 0, strpos($location, ','));
																					 $lat = substr($location, strpos($location, ',') + 1);
																					 $mapbox['lng'] = $lng;
																					 $mapbox['lat'] = $lat;
																					 $mapbox['id'] = 'map_'.$offer->id;
																				}

																		  @endphp

																		  @if ($offer->location != '')
																		  	@include('mapbox_static', $mapbox)
																		  @endif


                                                        @if ($masters->count() > 0)
                                                            Получены предложения от:
                                                            <ul>
                                                                @foreach ($masters as $master)
                                                                    <li>{{ $master->title }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
																		 @if ($masters->contains('userid', Auth::user()->id))
																		 	<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
																		@else
                                                        <x-form :action="route('master.respond', $offer->id)" class=" d-flex flex-nowrap w-100 mb-4 justify-content-end">
                                                            @method('PUT')

                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                            <x-form-submit class="ml-4">Откликнуться</x-form-submit>
                                                        </x-form>
																		  @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Modal: {{ $offer->id }} -->
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-8 mt-5">
                    <div class="card">
                        <div class="card-header">Ваши отклики:</div>

                        <div class="card-body">

										<div class="offers-container">
												<ol>
													@foreach (Auth::user()->offers()->get() as $offer)
														<li>{{ $offer->title }}</li>
													@endforeach
												</ol>
										</div>

                        </div>
                    </div>
                </div>


        </div>
    </div>
@endsection
