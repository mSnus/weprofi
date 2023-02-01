function confirmRemoveImage(id) {
    if( window.confirm('Удалить фото?') ) {
        displayLoading('gallery');
        axios.get('/profile.removeimage/'+id).then(
        ()=> { refreshGallery() }
        );
    }
}

async function refreshAvatar() {
    let images = await axios.get('/profile.getavatar');
    let avatar = $('#avatar');

    console.log('avatar>>', images);

    displayLoading('avatar');
    let imageSrc = images?.data[0]?.thumb ?? '/img/avatar.png';


    imageHtml = `
    <div class="avatar-container">
        <div class="avatar" style="background-image: url(${imageSrc})"
            title="User avatar" onclick="uploadAvatar()">
            <svg height="1792" viewBox="0 0 1792 1792" width="1792"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M1344 1472q0-26-19-45t-45-19-45 19-19 45 19 45 45 19 45-19 19-45zm256 0q0-26-19-45t-45-19-45 19-19 45 19 45 45 19 45-19 19-45zm128-224v320q0 40-28 68t-68 28h-1472q-40 0-68-28t-28-68v-320q0-40 28-68t68-28h427q21 56 70.5 92t110.5 36h256q61 0 110.5-36t70.5-92h427q40 0 68 28t28 68zm-325-648q-17 40-59 40h-256v448q0 26-19 45t-45 19h-256q-26 0-45-19t-19-45v-448h-256q-42 0-59-40-17-39 14-69l448-448q18-19 45-19t45 19l448 448q31 30 14 69z" />
            </svg>
        </div>
    </div>
    
    `

    avatar.html(imageHtml);
}

async function refreshGallery() {
    let images = await axios.get('/profile.getgallery');
    let gallery = $('#gallery');

    displayLoading('gallery');
    let imageList = '';

    for (const image of images.data) {
        imageList += `<div class="gallery-item"
            onclick="confirmRemoveImage(${image.id})">
            <div class="button-delete">
                <svg id="delete_icon" data-name="delete_icon"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 105.16 122.88"
                    width="20" height="20" fill="#EBD2A2">
                    <path
                        d="M11.17,37.16H94.65a8.4,8.4,0,0,1,2,.16,5.93,5.93,0,0,1,2.88,1.56,5.43,5.43,0,0,1,1.64,3.34,7.65,7.65,0,0,1-.06,1.44L94,117.31v0l0,.13,0,.28v0a7.06,7.06,0,0,1-.2.9v0l0,.06v0a5.89,5.89,0,0,1-5.47,4.07H17.32a6.17,6.17,0,0,1-1.25-.19,6.17,6.17,0,0,1-1.16-.48h0a6.18,6.18,0,0,1-3.08-4.88l-7-73.49a7.69,7.69,0,0,1-.06-1.66,5.37,5.37,0,0,1,1.63-3.29,6,6,0,0,1,3-1.58,8.94,8.94,0,0,1,1.79-.13ZM5.65,8.8H37.12V6h0a2.44,2.44,0,0,1,0-.27,6,6,0,0,1,1.76-4h0A6,6,0,0,1,43.09,0H62.46l.3,0a6,6,0,0,1,5.7,6V6h0V8.8h32l.39,0a4.7,4.7,0,0,1,4.31,4.43c0,.18,0,.32,0,.5v9.86a2.59,2.59,0,0,1-2.59,2.59H2.59A2.59,2.59,0,0,1,0,23.62V13.53H0a1.56,1.56,0,0,1,0-.31v0A4.72,4.72,0,0,1,3.88,8.88,10.4,10.4,0,0,1,5.65,8.8Zm42.1,52.7a4.77,4.77,0,0,1,9.49,0v37a4.77,4.77,0,0,1-9.49,0v-37Zm23.73-.2a4.58,4.58,0,0,1,5-4.06,4.47,4.47,0,0,1,4.51,4.46l-2,37a4.57,4.57,0,0,1-5,4.06,4.47,4.47,0,0,1-4.51-4.46l2-37ZM25,61.7a4.46,4.46,0,0,1,4.5-4.46,4.58,4.58,0,0,1,5,4.06l2,37a4.47,4.47,0,0,1-4.51,4.46,4.57,4.57,0,0,1-5-4.06l-2-37Z" />
                </svg>
            </div>
            <img src="${image.thumb}">
        </div>
        
        `
    }

    gallery.html(imageList);
}

document.addEventListener("DOMContentLoaded", ()=>{
    refreshAvatar();
    refreshGallery();
});