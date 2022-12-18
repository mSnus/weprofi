
function uploadAvatar(){
   const fileRef = document.getElementById('fileAvatar'); 

   fileRef.value = "";   

    $('#fileAvatar').trigger('click');

    fileRef.onchange = function () {
        if(fileRef.files !== undefined && fileRef.files.length > 0) {
            // let files = new FormData();

            // Array.from(this.files).forEach(function(file){
            //     files.append('files[]', file);
            // });

            // axios.post('/profile.avatar/54', {
            //     files
            // }, {
            //         headers: {
            //         'Content-Type': 'multipart/form-data'
            //         }
            //     }
            // );


            document.forms['formAvatar'].submit();
        } 
    };

    

}



function uploadGallery(){
    const fileRef = document.getElementById('fileGallery'); 
 
    fileRef.value = "";   
 
     $('#fileGallery').trigger('click');
 
     fileRef.onchange = function () {
         if(fileRef.files !== undefined && fileRef.files.length > 0) {

             document.forms['formGallery'].submit();
         } 
     };
 
     
 
 }
 