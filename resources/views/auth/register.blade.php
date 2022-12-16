@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <h1>{{ __('Register') }} пользователя</h1>

                <div class="form-register">
                    <form method="POST" action="{{ route('register') }}" id="formRegister">
                        @csrf

                        <div class="form-group row">
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

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Номер телефона') }}</label>

                            <div class="col-md-8">
                                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <input type="hidden" name="usertype" id="usertype" value="{{ App\Models\User::typeClient }}">

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                
                                <button type="submit" class="primary">
                                    {{ __('Register') }} 
                                </button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8">
                                <h2>Вы профессионал?</h2>
                            </div>
                        </div>

                        @php
                            $specs = \App\Models\Spec::get()->all();
                            $subspecs = \App\Models\Subspec::get()->all();
                            $subspecs_arr = [];
                            foreach ($subspecs as $subspec) {
                                $subspecs_arr[] = (object) [
                                    'id' =>       $subspec->id,
                                    'title' =>    $subspec->title,
                                    'spec_id' =>  $subspec->spec_id
                            ];
                            }
                            
                        @endphp

                        <script>
                            function showSubspecs(select, spec){
                                const subspecs = {!! json_encode($subspecs_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_LINE_TERMINATORS ) !!};

                                const filtered = subspecs.filter(el => el.spec_id == spec);
                                const options = filtered.map((el) =>{ return {key: el.id, value: el.title}});
                                console.log(filtered);

                                if (filtered.length > 0) {
                                    const obj = $('#'+select);
                                    obj.empty();

                                    obj.append($("<option></option>")
                                                        .attr("value", 0)
                                                        .text('- без уточнения -'
                                                        )); 

                                    $.each(options, function(key, value) {   
                                        obj.append($("<option></option>")
                                                        .attr("value", value.key)
                                                        .text(value.value
                                                        )); 
                                    });

                                    $('#'+select+'_row').show();
                                } else {
                                    $('#'+select+'_row').hide();
                                }
                            }
                        </script>

                        <div class="form-group row" id="spec1_row">
                            <label for="spec1" class="col-md-4 col-form-label text-md-right">{{ __('Вид деятельности') }}</label>

                            <div class="col-md-8">
                                <select id="spec1" class="form-control" name="spec1" 
                                        onclick="showSubspecs('subspec1', this.options[this.selectedIndex].value)"
                                        onselect="showSubspecs('subspec1', this.options[this.selectedIndex].value)"
                                >
                                    @foreach ($specs as $spec)
                                        <option value="{{ $spec->id }}">{{ $spec->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                  
{{-- 

                            <div class="col-md-8">
                                <button class="primary" onclick="$('#spec2_row').show('slow');">+ ещё</button>
                            </div> --}}
                        </div>

                        <div class="form-group row" id="subspec1_row"style="display: none">
                            <label for="subspec1" class="col-md-4 col-form-label text-md-right">{{ __('Можно уточнить') }}</label>

                            <div class="col-md-8">
                                
                                <select id="subspec1" class="form-control" name="subspec1">
                                </select>
  
                            </div>
                        </div>    

                        <div class="form-group row">
                            <label for="region" class="col-md-4 col-form-label text-md-right">{{ __('Регион работы') }}</label>

                            <div class="col-md-8">
                                
                                <select id="region" class="form-control" name="region" multiple>
                                    <option value="acre" selected>Акко</option>
                                    <option value="haifa">Хайфа</option>
                                    <option value="naharia">Нагария</option>
                                    <option value="karmiel">Кармиэль</option>
                                    <option value="holon">Холон</option>
                                    <option value="ta">Тель-Авив</option>
                                    <option value="israel">весь Израиль</option>
                                </select>
  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="language" class="col-md-4 col-form-label text-md-right">{{ __('Языки') }}</label>

                            <div class="col-md-8">
                                
                                <select id="language" class="form-control" name="language" multiple>
                                    <option value="ru" selected>Русский</option>
                                    <option value="en">Английский</option>
                                    <option value="il">Иврит</option>
                                </select>
  
                            </div>
                        </div>

                        <script>
                            function registerProfi() {
                                const form = document.getElementById('formRegister');
                                form.usertype.value = '{{ App\Models\User::typeMaster }}';
                                form.submit();
                            }
                        </script>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                
                                <button type="button" class="tertiary" onclick="registerProfi()">
                                    Создать&nbsp;профиль
                                </button>
                            </div>
                        </div>
                    </form>

            </div>
        </div>
    </div>
</div>
@endsection
