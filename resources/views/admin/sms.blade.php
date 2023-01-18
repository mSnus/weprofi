@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/subspecs.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="{{ asset('css/select2-materialize.css') }}" rel="stylesheet" />
@endsection

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

    <script>        
        document.addEventListener("DOMContentLoaded", ()=>{
            $('#userId').select2({
                placeholder: "", //варианты ответа
                minimumResultsForSearch: 1,
                tags: false,
            });
        });

        function doMassSubmit(){
            if (window.confirm('Точно разослать это по всей базе?')) {
                $('#sendMode').val('mass');
                $('#sendForm').submit();
            } else {
                return false;
            }
        }
    </script>

    <div class="container">
        <h1>SMS:</h1>
        <div class="row justify-content-center">
            
                <div class="col-md-8 mt-5">
                    <div class="card">
                            
                        <div class="card-body text-center">
                            <form method="POST" class="form-group text-center" id="sendForm">
                                @csrf

                                @php
                                    $users = \App\Models\User::where('status', 'active')->orderBy('phone', 'ASC')->get();
                                @endphp

                                <select
                                name="user_id"
                                class="form-select mb-4"
                                id="userId"
                                >
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{$user->phone}} - {{$user->name}}</option>
                                @endforeach
                                </select>
                            <textarea
                            name="template"
                            class="form-control mt-4"
                            style="width: 100%; height:200px;"
                            >{{ Setting::get('text_sms_invite') }}</textarea>
                            <input type="hidden" name="send_mode" value="single" id="sendMode">
                            <button type="submit" class="button-primary mr-auto ml-auto mt-4">Отправить</button>
                            <button 
                                type="button" 
                                class="button-tertiary mr-auto ml-auto mt-4"
                                onclick="return doMassSubmit()"
                                >Массовая рассылка по всем</button>
                            </form>
                        </div>
                    </div>
                </div>

        </div>
    </div>
@endsection
