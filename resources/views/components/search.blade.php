<div class="search">
    <form method="GET" onsubmit="doSearch(); return false;">
    <input type="text" name="spec_search" id="specSearch" value="{{ $term ?? ''}}">
    <img src="/img/go.svg" alt="Search" width="32" height="32" class="button-search" onclick="return doSearch()" >
    </form>
</div>

<script>
    function doSearch() {
        let input = document.getElementById('specSearch');

        if (input.value.length > 2) {
            window.location.href = encodeURI('/search/' + input.value);
        } else {
            return false;
        }
    }
</script>