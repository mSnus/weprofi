@section('head')
    <script src="{{ asset('js/subspecs.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="{{ asset('css/select2-materialize.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/path.js') }}"></script>
@endsection

    <form method="GET" class="formSearch" onsubmit="doSearch(); return false;">
        <div class="search">
            <input type="text" name="spec_search" id="specSearch" value="{{ $term ?? ''}}">
            <img src="/img/go.svg" alt="Search" width="32" height="32" class="button-search" onclick="return doSearch()" >
        </div>

        @if (isset($region_options))
        <div class="region-search-container">
            <div>город/регион: </div>
            <select name="region_search" id="regionSearch" style="width: 150px;" onchange="handleRegionChange(event)">
                @foreach ($region_options as $option)
                        <option value="{{ $option->value }}" {{ $option->default ? 'selected' : '' }}> {{ $option->title }} </option>
                @endforeach
            </select>
            <div class="search-clear" onclick="chooseIsrael(event)"><img src="/img/close-circle.svg"></div>
        </div>
        @endif
    </form>



<script>
    function doSearch() {
        let input = document.getElementById('specSearch');

        if (input.value.length > 2) {
            window.location.href = encodeURI('/search/' + input.value);
        } else {
            return false;
        }
    }

    function handleRegionChange(event) {
            goPath(event, {{ $spec_id }}, {{ $subspec_id }});
    }

    function chooseIsrael(event){
        goPath(event, {{ $spec_id }}, {{ $subspec_id }}, '')
    }

    document.addEventListener("DOMContentLoaded", ()=>{
        $('#regionSearch').select2({
            placeholder: "весь Израиль", 
            minimumResultsForSearch: 1,
            tags: false,
            width: 'element'
        });
    });

</script>