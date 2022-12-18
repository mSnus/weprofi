
function registerProfi() {
    const form = document.getElementById('formRegister');
    form.usertype.value = 22; //'{{ App\Models\User::typeMaster }}';
    form.submit();
}
