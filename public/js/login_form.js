async function resetPasswordInSms(event){
    event.preventDefault();

    if ($('.button-reset').hasClass("button-disabled")) 
        return;

    $('.button-reset').addClass("button-disabled");
    $('.reset-result').hide('fast')

    setTimeout(()=>{
        $('.button-reset').removeClass("button-disabled");
        $('.reset-result').hide('slow')
    }, 6000)

    let phone = $('#phone').val()+'';
    phone = phone.replace('/[^0-9\-]/', '');
    
    if (phone.length < 9) 
        return alert("Введён некорректный номер");

    let link = '/reset/'+phone;
    let response = await axios.get(link);

    let result = '';
    console.log('RESPONSE>>', response);

    if (response.status == 200) {
        result = `<div class="reset-ok">${response.data}</div>`
    } else {
        result = `<div class="reset-failed">${response.data}</div>`
    }

    $('.reset-result').html(result);
    $('.reset-result').show('fast')
    
}
