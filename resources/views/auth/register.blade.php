@extends('layouts.app')
<script src="{{ asset('js/register.js') }}"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <h1>{{ __('Register') }}</h1>

                <div class="form-register">
                    <form method="POST" action="{{ route('register') }}" id="formRegister">
                        @csrf

                        <div class="form-group row register-form-simple">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row register-form-simple">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Номер телефона') }}</label>

                            <div class="col-md-8">
                                <input 
                                    id="phone" 
                                    type="phone" 
                                    class="form-control @error('phone') is-invalid @enderror" 
                                    name="phone" 
                                    value="{{ Session::get('phone') ?? old('phone') }}"
                                    required 
                                    autocomplete="phone"
                                >

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row register-form-simple">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input 
                                    id="password"
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    name="password" 
                                    value="{{ Session::get('password') ?? '' }}"
                                    required 
                                    autocomplete="new-password"
                                >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row register-form-simple">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <input type="hidden" name="usertype" id="usertype" value="{{ App\Models\User::typeClient }}">

                        <div class="form-group row mb-0 register-form-simple">
                            <div class="col-md-8 offset-md-2">
                                
                                <button type="submit" class="primary">
                                    {{ __('Register') }} пользователя 
                                </button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 mt-4">
                                <h2 class="mb-0">Вы профессионал?</h2>
                            </div>
                        </div>

                        <div class="professional-form">    
                            <div class="col-md-10 price-warning">
                                {{ Setting::get('text_free_period') }}
                            </div>

                            @include('auth.professional-fields')
                            
                            <div class="form-group row mb-0">
                                <div class="col-md-8">
                            
                                    <button type="button" class="button-primary m-auto" onclick="registerProfi()">
                                        Регистрироваться&nbsp;как&nbsp;профи
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>
@endsection
