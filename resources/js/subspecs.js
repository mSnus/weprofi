
function showSubspecsList(selectId, spec, subspecs, user_subspecs=null){
    const filtered = subspecs.filter(el => el.spec_id == spec);
    
    // console.log(filtered);

    if (filtered.length > 0) {
        const options = filtered.map((el) =>{ return {key: el.id, value: el.title}});
        
        const selectRef = document.getElementById(selectId);
       
        while (selectRef.hasChildNodes()) {
            selectRef.removeChild(selectRef.lastChild)
        }

        
        console.log('user_subspecs>>', user_subspecs);

        let option = document.createElement("option");
        option.value = 0;
        option.text = '- без уточнения -';
        if (user_subspecs === null) { option.selected = true;}
        selectRef.appendChild(option);                            

        for (const val of options)   {
            let option = document.createElement("option");
            option.value = val.key;
            option.text = val.value;
            if (user_subspecs !== null) {
                if (user_subspecs.includes(val.key) ) {
                    console.log(val.value+' is included');
                    option.selected = true;
                } else {
                    console.log(val.value+' is not included');
                }
            }
            selectRef.appendChild(option);
        }



        // $.each(options, function(key, value) {   
        //     selectRef.append($("<option></option>")
        //                     .attr("value", value.key)
        //                     .text(value.value
        //                     )); 
        // });

        $('#'+selectId+'_row').show();
    } else {
        $('#'+selectId+'_row').hide();
    }
}
