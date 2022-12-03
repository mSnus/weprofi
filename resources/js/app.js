require('./bootstrap');
import $ from 'jquery';
window.$ = window.jQuery = $;
window.lightslider = require('lightslider');




jQuery(function () {
    /* По клику на хинте вставляем текст хинта через пробел после имеющегося текста */
    $('.hint').on('click', function (event) {
        let oldTitle = $('#formNewOffer #' + event.target.parentNode.dataset.realtarget).val();
        $('#formNewOffer #' + event.target.parentNode.dataset.realtarget).val(oldTitle + (oldTitle == '' ? '' : ' ') + event.target.dataset.realvalue);
    })
});
