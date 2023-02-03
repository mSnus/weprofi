@extends('layouts.app')

<script src="{{ asset('js/login_form.js') }}"></script>

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">Добро пожаловать!</h2>



                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <div class="form-group row">
                        <label for="phone" class="col-md-3 col-form-label text-md-right">{{ __('Телефон') }}</label>
                        <div class="profile-small-hint">в формате 53 456 7899, без 0 или +972</div>
                        <div class="col-md-9">
                            <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') }}" required autocomplete="phone"
                                placeholder="Номер телефона" autofocus>

                            {{-- @if ($errors->any())
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif --}}

                            @error('name')
                                <span role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-9">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input class="form-check-input" type="hidden" name="remember" id="remember" checked>

                    <div class="form-group row mb-0 d-flex">
                        <div class="button-block col-md-8 d-flex" style="column-gap: 1rem;">
                            <button type="submit" class="button-primary">
                                {{ __('Login') }}
                            </button>

                            <button type="button" class="button-tertiary" onclick="window.location.href='/register'">
                                {{ __('Register') }}
                            </button>

                            @if (request()->has('return'))
                                <input type="hidden" name="return" value="{{ request()->return }}">
                            @endif

                            {{-- @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif --}}
                        </div>

                        <div class="col-md-12 d-block mt-4 button-quartiary button-reset">
                            <div class="password-reset" onclick="resetPasswordInSms(event)">
                                Отправить ссылку для входа по SMS
                           </div>
                        </div>

                        <div class="reset-result"></div>
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection
