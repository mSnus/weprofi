@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8 mt-5">
                <div class="card">
                    <div class="card-header">Ваши заказы:</div>

                    <div class="card-body">
                        <div class="offers-container">
                            @php
                                $client_id = Auth::user()->id;
                                $all_offers = App\Models\Offer::where('client', $client_id)->get();
                            @endphp
                            @foreach ($all_offers as $offer)
                                <div class="offer">

                                    <div class="offer-title">
                                        <b>{{ $offer->title }}</b>
                                        <br>

                                        @php
                                            $masters = $offer->masters;
                                            $btnClass = $masters->count() == 0 ? 'btn-outline-success' : 'btn-success';
                                            $btnText = $masters->count() == 0 ? '' : '(+' . $masters->count() . ')';
                                        @endphp

                                    </div>


                                    <div class="offer-actions d-flex flex-nowrap align-items-start">
                                        <a class="ml-4 btn {{ $btnClass }}" data-toggle="modal" data-target="#offerModal_{{ $offer->id }}">
                                            Посмотреть&nbsp;{{ $btnText }}
                                        </a>
                                    </div>


                                </div>
                                <!-- Modal: {{ $offer->id }} -->
                                <div class="modal fade" id="offerModal_{{ $offer->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ $offer->title }}</h5>
																<a class="ml-4 btn btn-outline-warning" onclick="window.location.href = '{{ route('client.edit-offer', [$offer->id]) }}';">
																	Редактировать
																  </a>
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
                                                        $mapbox['id'] = 'map_' . $offer->id;
                                                    }

                                                @endphp

                                                @if ($offer->location != '')
                                                    @include('mapbox_static', $mapbox)
                                                @endif


                                                @if ($masters->count() > 0)
                                                    <div class="master-list">
                                                        Получены предложения от:
                                                        @foreach ($masters as $master)
                                                            <div class="master-item @if ($offer->master == $master->userid) alert alert-success @endif">
                                                                <div class="master-name">{{ $master->title }}</div>
                                                                <div class="master-descr">{{ $master->descr }}</div>
                                                                <div class="master-score">
																						 @for ($i = 0; $i < $master->score; $i++)
																							  <img src="/img/star.svg" width="15" alt="star">
																						 @endfor

																					 </div>

																					 @if ($offer->master != $master->userid)
                                                                <div class="master-form">
                                                                    <x-form :action="route('client.accept', [$offer->id, $master->userid])" class=" d-flex flex-nowrap w-100 mb-4 justify-content-end">
                                                                        @method('PUT')
																									<x-form-submit class="ml-4">Выбрать</x-form-submit>
                                                                    </x-form>
                                                                </div>
																					 @endif
                                                            </div>

                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
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

            <div class="d-flex justify-content-center mt-5">
                <div class="d-flex justify-content-center">
                    <div class="">
                        @include('requests', ['password_required' => false])
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
