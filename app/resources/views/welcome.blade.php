@extends('layouts.app')

@section('title', 'Починим.Онлайн')

@section('content')


    <div class="container d-flex justify-content-center section-welcome">



            @if (!Auth::user() || Auth::user()->isClient())
                <!-- регистрация клиента и новая заявка -->
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @else
                    @include('requests', ['password_required' => true])
                @endif
            @else
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

						@if (Auth::user()->isMaster())
							@include('/masters_home');
						@endif
					</div>
            @endif


    </div>

	 @if (!Auth::user())
	 <div class="container p-4 pt-5">
			 <div class="d-flex justify-content-center bg-light-blue align-items-center">
				 <!-- регистрация мастера -->
				 <div class="">
					 <h2>Мастер? Вы нам нужны!</h2>
					 <button class="btn btn-success" onclick="window.location.href='/master';">Присоединяйтесь!</button>
				 </div>
			 </div>
		 </div>
	@endif
@endsection
