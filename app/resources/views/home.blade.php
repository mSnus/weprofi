@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            @auth
                @if (Auth::user() && Auth::user()->isMaster())
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Доступные заказы:</div>

                            <div class="card-body">
                                <div class="offers-container">
                                    @foreach (App\Models\Offer::listAll() as $offer)
                                        <div class="offer">
                                            <x-form :action="route('master.respond', $offer->id)" class=" d-flex flex-nowrap w-100 mb-4">
                                                @method('PUT')

                                                <div class="offer-title">
                                                    <b>{{ $offer->title }}</b> <i>{{$offer->owner_title}}</i>
                                                    <br>
                                                    {{ $offer->descr }}<br><br>
																	 {{ $offer->location }}
                                                </div>




                                                @if ($offer->master != Auth::user()->user_role->userid)
                                                    <div class="offer-actions d-flex flex-nowrap align-items-start">
																			<a class="ml-4 btn btn-success">
																				Посмотреть
																			</a>
                                                        <x-form-submit class="ml-4">
                                                            Откликнуться
                                                        </x-form-submit>
                                                    </div>
                                                @endif

                                            </x-form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-8 mt-5">
                    <div class="card">
                        @php
                            $offerAlias = Auth::user()->isClient() ? 'заказы' : 'отклики';
                        @endphp
                        <div class="card-header">Ваши {{ $offerAlias }}:</div>

                        <div class="card-body">
                            @if (Auth::user()->offers()->count() > 0)
                                <div class="offers-container">
                                    <ol>
                                        @foreach (Auth::user()->offers() as $offer)
                                            <li> {{ $offer->title }}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            @else
                                <div class="offers-container">
                                    {{ mb_ucfirst($offerAlias) }} не найдены.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if (Auth::user()->isClient())
                    <div class="d-flex justify-content-center">
                        <div class="d-flex justify-content-center">
                            <div class="">
                                @include('requests', ['password_required' => false])
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

        </div>
    </div>
@endsection
