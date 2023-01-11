@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if (isset($status))
        <div class="alert alert-success" role="alert">
            {!! $status !!}
        </div>
    @endif

    <div class="container">
        <h1>SMS:</h1>
        <div class="row justify-content-center">
            
                <div class="col-md-8 mt-5">
                    <div class="card">

                        <div class="card-header">Шаблон:</div>
                            
                        <div class="card-body text-center">
                            <form method="POST" class="form-group text-center">
                                @csrf

                                @php
                                    $users = \App\Models\User::where('status', 'active')->get();
                                @endphp

                                <select
                                name="user_id"
                                class="form-select mb-4"
                                >
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{$user->name}}</option>
                                @endforeach
                                </select>
                            <textarea
                            name="template"
                            class="form-control"
                            style="width: 100%; height:200px;"
                            >#name#, добро пожаловать в Израильское сообщество профессионалов!. Активируйте профиль (бесплатно): https://weprofi.co.il/#id#/#invite_token#</textarea>
                            <button type="submit" class="button-primary mr-auto ml-auto mt-4">Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>

        </div>
    </div>
@endsection
