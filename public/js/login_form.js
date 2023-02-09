async function resetPasswordInSms(event) {
    event.preventDefault();

    if ($('.button-reset').hasClass("button-disabled"))
        return;

    $('.button-reset').addClass("button-disabled");
    $('.reset-result').hide('fast')

    setTimeout(() => {
        $('.button-reset').removeClass("button-disabled");
        $('.reset-result').hide('slow')
    }, 6000)

    let phone = $('#phone').val() + '';
    phone = phone.replace('/[^0-9\-]/', '');

    if (phone.length < 9)
        return alert("Введён некорректный номер");

    let link = '/reset/' + phone;
    let response = await axios.get(link);

    let result = '';
    // console.log('RESPONSE>>', response);

    if (response.status == 200) {
        result = `<div class="reset-ok">${response.data}</div>`
    } else {
        result = `<div class="reset-failed">${response.data}</div>`
    }

    $('.reset-result').html(result);
    $('.reset-result').show('fast')

}


function goRegister() {
    login = $('#phone').val();
    password = $('#password').val();

    let form = document.createElement("form");
    form.action = '/quickregister';
    form.name = "redirectForm";
    form.method = "POST";

    let input1 = document.createElement("input");
    input1.type = "hidden";
    input1.name = "login";
    input1.value = login;

    form.appendChild(input1);

    let input2 = document.createElement("input");
    input2.type = "hidden";
    input2.name = "password";
    input2.value = password;

    form.appendChild(input2);

    let input3 = document.createElement("input");
    input3.type = "hidden";
    input3.name = "_token";
    input3.value = window._csrf_token;

    form.setAttribute("target", "_self");
    form.appendChild(input3);
    
    document.body.appendChild(form);

    form.submit();
}
