@extends('layouts.app')

@section('title', 'WeProfi')

@section('content')
    @auth
        $auth_id = Auth::id();
        $auth_user = Auth::user()->name;
        $auth_phone = Auth::user()->phone;
    @endauth
    <script>
        document.addEventListener("DOMContentLoaded", ()=>{
            $('#sendForm').action = "/contacts/send";
        })
        //javascript:alert('Please reload!')
    </script>

    <h1>Обратная связь</h1>

    @if (Session::has('status'))
    <div class="alert alert-success" role="alert">
         <p>{{ Session::get('status') }}</p>
    </div>
    <div class="container d-block text-center m-auto">
        <button class="primary" onclick="window.location.href='/'">На главную</button>
    </div>
    @else    
        <form id="sendForm" method="POST" action="/contact/send">
            @csrf
            <input type="hidden" name="user_id" value="{{ $auth_id ?? 0}}">

            <div class="form-group row">  
                <label for="phone">От кого</label>
                <input type="text" class="form-control" name="user" id="user" value="{{ $auth_name ?? ''}}">
            </div>

            <div class="form-group row">  
                <label for="phone">Телефон</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ $auth_phone ?? ''}}">
            </div>

            <div class="form-group row">
                <label for="phone">Сообщение</label>
                <textarea name="message"  class="form-control" id="message" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group row">
                <button class="button-primary" type="submit">Отправить</button>
            </div>
        </form>


    @endif
@endsection
