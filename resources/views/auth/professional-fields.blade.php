
<!-- professiona-fields -->

<script src="{{ asset('js/subspecs.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="{{ asset('css/select2-materialize.css') }}" rel="stylesheet" />

@php
    // $cities = App\Models\City::get()->sortByDesc('slug')->all();
    
    $languages = ['ru' => 'Русский', 'en' => 'Английский', 'il' => 'Иврит', 'ar' => 'Арабский'];

    $specs = \App\Models\Spec::orderBy('ordering')->orderBy('title')->get()->all();
    $subspecs = \App\Models\Subspec::get()->all();
    $subspecs_arr = [];
    
    foreach ($subspecs as $subspec) {
        $subspecs_arr[] = (object) [
            'id' =>       $subspec->id,
            'title' =>    $subspec->title,
            'spec_id' =>  $subspec->spec_id
    ];
    }


    $user_cities = [App\Models\City::DEFAULT_REGION]; 
    $default_city = App\Models\City::DEFAULT_REGION;
    $user_specs = [];
    $user_subspecs = [];
    $user_languages = ['ru'];

    $user_subspecs1 = [];

    if (Auth::id()) {
        $user = App\Models\User::getData(Auth::id())['user'];

        $user_cities = explode(',', Auth::user()->region);
        $user_languages = explode(',', Auth::user()->language);

        $default_city = reset($user_cities) ?? App\Models\City::DEFAULT_REGION;

        $user_specs = Auth::user()->specs();
        $user_subspecs = Auth::user()->subspecs();

        $spec1 = reset($user_specs);
        $user_subspecs1 = empty($user_subspecs) ? [] : (
            isset($user_subspecs[$spec1]) ? $user_subspecs[$spec1] : []
        );
    }

    $cities = App\Models\City::getOptions($default_city);

    // dd($city_options, $default_city, $user_cities, $cities);
@endphp

<script>
function showSubspecs(select, spec){
    const subspecs = {!! json_encode($subspecs_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_LINE_TERMINATORS ) !!};
    const user_subspecs =  {{ '['. join(',', $user_subspecs1) . ']' }};
    return showSubspecsList(select, spec, subspecs, user_subspecs);
}

document.addEventListener("DOMContentLoaded", ()=>{
    //загрузить подкатегории соответствующий первому в списке категорий
    const spec1 = document.getElementById('spec1');
    showSubspecs(showSubspecs('subspec1', spec1.options[spec1.selectedIndex].value))

    //делаем нормальные  списки
    $('#spec1').select2({
        placeholder: "", //варианты ответа
        minimumResultsForSearch: -1,
        tags: false,
    });

    $('#subspec1').select2({
        placeholder: "", //варианты ответа
        minimumResultsForSearch: -1,
        tags: false,
    });

    $('#region').select2({
        placeholder: "", //варианты ответа
        minimumResultsForSearch: -1,
        tags: false,
    });

    $('#language').select2({
        placeholder: "", //варианты ответа
        minimumResultsForSearch: -1,
        tags: false,
    });

    //setDefaultSelection();
});


</script>

<div class="form-group row" id="spec1_row">
    <label for="spec1" class="col-md-12 col-form-label text-md-left mb-3">{{ __('Вид деятельности') }}</label>
    
    <div class="col-md-12">
        <select id="spec1" class="form-control" name="spec1" 
                onchange="showSubspecs('subspec1', this.options[this.selectedIndex].value)"
        >
            @foreach ($specs as $spec)
                <option value="{{ $spec->id }}">{{ $spec->title }}</option>
            @endforeach

            @foreach ($specs as $spec)
                @if (in_array($spec->id, $user_specs))
                    <script>
                        document.addEventListener("DOMContentLoaded", ()=>{
                            $('#spec1').val({{ $spec->id }}).trigger('change');
                        });
                    </script>
                @endif
            @endforeach
        </select>
    </div>

{{-- 

    <div class="col-md-12">
        <button class="primary" onclick="$('#spec2_row').show('slow');">+ ещё</button>
    </div> --}}
</div>

<div class="form-group row" id="subspec1_row"style="display: none">
    <label for="subspec1" class="col-md-12 col-form-label text-md-left mt-4">{{ __('Уточнение') }}</label>
    <span class="profile-small-hint">(можно выбрать несколько или вообще не уточнять)</span>

    <div class="col-md-12">
        
        <select id="subspec1" class="form-control" name="subspec1[]" multiple>
        </select>

    </div>
</div>    

<div class="form-group row">
    <label for="region" class="col-md-12 col-form-label text-md-left">{{ __('Регион работы') }} </label>
    <span class="profile-small-hint">(можно выбрать несколько)</span>

    <div class="col-md-12">        
        <select id="region" class="form-control" name="region[]" multiple>
            @foreach ($cities as $city)
                <option value="{{ $city->slug }}" {{ (in_array($city->slug, $user_cities)) ? ' selected' : '' }}> {{$city->title}} </option>    
            @endforeach
        </select>

    </div>
</div>

<div class="form-group row">
    <label for="language" class="col-md-12 col-form-label text-md-left">{{ __('Языки') }} </label>
    <span class="profile-small-hint">(можно выбрать несколько)</span>

    <div class="col-md-12">        
        <select id="language" class="form-control" name="language[]" multiple>
            @foreach ($languages as $slug => $language)
                <option value="{{ $slug }}" {{ (in_array($slug, $user_languages)) ? ' selected' : '' }}> {{$language}} </option>    
            @endforeach
        </select>

    </div>
</div>

