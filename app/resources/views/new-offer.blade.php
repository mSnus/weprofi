@extends('welcome')

@section('content')
<div class="flex">
	<!-- регистрация клиента и новая заявка -->
	@if (session('status'))
		 <div class="alert alert-success">
			  {{ session('status') }}
		 </div>
	@else
		 <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg">
			  <div class="flex">
					<div class="p-6">
						 <div class="mt-2 text-gray-600 text-sm px-8">
							  <h3>В чём твоя проблема, человек? .[0_0].</h3>
						 </div>
					</div>
			  </div>
			  <div class="flex">
					<div class="p-6">
						 @include('requests')
					</div>
			  </div>
		 </div>
	@endif
</div>
@endsection