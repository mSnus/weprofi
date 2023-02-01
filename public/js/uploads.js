
function uploadAvatar(){
   const fileRef = document.getElementById('fileAvatar'); 

   fileRef.value = "";   

    $('#fileAvatar').trigger('click');

    fileRef.onchange = function () {
        if(fileRef.files !== undefined && fileRef.files.length > 0) {
            displayLoading('avatar');

            let formData = new FormData();
            let attaches = [];

            for (const file of fileRef.files) {
                formData.append("files[]", file);
            };

            axios.post('/profile.avatar', formData, {
                headers: {
                'Content-Type': 'multipart/form-data',
                '_token': window._csrf_token,
                }
            }).then(
                ()=>{
                    refreshAvatar();
                }
            )
        } 
    }
}

function selectAndUploadGallery(fileRefSlug){
    const fileRef = document.getElementById(fileRefSlug);    
    fileRef.value = "";                    

    fileRef.onchange = function () {
        if(fileRef.files !== undefined && fileRef.files.length > 0) {
            displayLoading('gallery');

            let formData = new FormData();
            let attaches = [];

            for (const file of fileRef.files) {
                formData.append("files[]", file);
            };

            axios.post('/profile.gallery', formData, {
                headers: {
                'Content-Type': 'multipart/form-data',
                '_token': window._csrf_token,
                }
            }).then(
                ()=>{
                    refreshGallery();
                }
            )
        }
    }
    
    $('#fileGallery').trigger('click');
}


function displayLoading(galleryId){
    let gallery = $('#'+galleryId);

    gallery.html('<img src=\'/img/loading.gif\' width=32 height=32>');
}



