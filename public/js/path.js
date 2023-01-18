function goPath(event, spec_id, subspec_id, elIdRegions = '#regionSearch'){
    event.preventDefault();
    
    let path = '/spec/';
    let region_id = elIdRegions.substring(0,1) == '#'
        ? $(elIdRegions).val() == '_israel' ? false : $('#regionSearch').val()
        : elIdRegions;

    path += (spec_id) ? spec_id + '/' : '';
    path += (subspec_id) ? subspec_id + '/' : '0/';
    path += region_id ? region_id + '/' : '';

    window.location.href = path;
}