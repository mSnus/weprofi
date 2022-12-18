
<!-- professiona-fields -->

<script src="{{ asset('js/subspecs.js') }}"></script>

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
    
    $cities = App\Models\City::get()->sortByDesc('slug')->all();
    $user_cities = explode(',', Auth::user()->region);

    $languages = ['ru' => 'Русский', 'en' => 'Английский', 'il' => 'Иврит'];
    $user_languages = explode(',', Auth::user()->language);

    $user_specs = Auth::user()->specs();
    $user_subspecs = Auth::user()->subspecs();
    $spec1 = reset($user_specs);
    $subspec1 = $user_subspecs[$spec1];
@endphp

<script>
function showSubspecs(select, spec){
    const subspecs = {!! json_encode($subspecs_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_LINE_TERMINATORS ) !!};
    const user_subspecs =  {{ '['. join(',', $subspec1) . ']' }};
    return showSubspecsList(select, spec, subspecs, user_subspecs);
}

window.addEventListener('load', function(event) { 
    const spec1 = document.getElementById('spec1');
    showSubspecs(showSubspecs('subspec1', spec1.options[spec1.selectedIndex].value))
});
</script>

<div class="form-group row" id="spec1_row">
    <label for="spec1" class="col-md-12 col-form-label text-md-left">{{ __('Вид деятельности') }}</label>
    
    <div class="col-md-12">
        <select id="spec1" class="form-control" name="spec1" 
                onchange="showSubspecs('subspec1', this.options[this.selectedIndex].value)"
        >
            @foreach ($specs as $spec)
                <option value="{{ $spec->id }}" {{ in_array($spec->id, $user_specs) ? 'selected=\''.$spec->id.'\'' : '' }}>{{ $spec->title }}</option>
            @endforeach
        </select>
    </div>

{{-- 

    <div class="col-md-12">
        <button class="primary" onclick="$('#spec2_row').show('slow');">+ ещё</button>
    </div> --}}
</div>

<div class="form-group row" id="subspec1_row"style="display: none">
    <label for="subspec1" class="col-md-12 col-form-label text-md-left">{{ __('Можно уточнить') }}</label>

    <div class="col-md-12">
        
        <select id="subspec1" class="form-control" name="subspec1[]" multiple>
        </select>

    </div>
</div>    

<div class="form-group row">
    <label for="region" class="col-md-12 col-form-label text-md-left">{{ __('Регион работы') }} (можно выбрать несколько)</label>

    <div class="col-md-12">        
        <select id="region" class="form-control" name="region[]" multiple>
            @foreach ($cities as $city)
                <option value="{{ $city->slug }}" {{ (in_array($city->slug, $user_cities)) ? ' selected' : '' }}> {{$city->title}} </option>    
            @endforeach
        </select>

    </div>
</div>

<div class="form-group row">
    <label for="language" class="col-md-12 col-form-label text-md-left">{{ __('Языки') }} (можно выбрать несколько)</label>

    <div class="col-md-12">        
        <select id="language" class="form-control" name="language[]" multiple>
            @foreach ($languages as $slug => $language)
                <option value="{{ $slug }}" {{ (in_array($slug, $user_languages)) ? ' selected' : '' }}> {{$language}} </option>    
            @endforeach
        </select>

    </div>
</div>