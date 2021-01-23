
var SAVE_CROPPER_IMAGE_ON_SERVER = {

    

    __show_uploaded_images_on_carousel: function (input) {

        var ImageSrc = $("#" + input).attr('src');

        try {
            if (ImageSrc == "") {
                throw "Image not found";
            }

            SAVE_CROPPER_IMAGE_ON_SERVER.__upload_image_external_location(ImageSrc);

        } catch (err) {
            alert(err);
        }

    },

    base64ImageToBlob: function (str) {
        // extract content type and base64 payload from original string
        var pos = str.indexOf(';base64,');
        var type = str.substring(5, pos);
        var b64 = str.substr(pos + 8);

        // decode base64
        var imageContent = atob(b64);

        // create an ArrayBuffer and a view (as unsigned 8-bit)
        var buffer = new ArrayBuffer(imageContent.length);
        var view = new Uint8Array(buffer);

        // fill the view, using the decoded base64
        for (var n = 0; n < imageContent.length; n++) {
            view[n] = imageContent.charCodeAt(n);
        }

        // convert ArrayBuffer to Blob
        var blob = new Blob([buffer], { type: type });

        return blob;
    },

    __upload_image_external_location: function (file) {

        var blob = SAVE_CROPPER_IMAGE_ON_SERVER.base64ImageToBlob(file);
        
        if (blob) {
            const type = file.split(';')[0].split('/')[1];
            var id = Math.floor(Math.random() * 1000000000) * 3;
            var objKey = id +'_.'+ type;
         
            var params = {
                Key: objKey,
                ContentType: type,
                Body: blob,
                ACL: 'public-read'
            };

            var loader_div = "<div class='progressbar' id='loader_"+id+"'>0%</div>";
            var hidden = "<input id='image_" + id + "' type='hidden' name='image' value='" + aws_config.S3_URL + objKey + "'>";
            $('#image_upload_dispaly').attr('src',file);
            $("#hidden_append_image").html(hidden);
            $('#user-image').prepend(loader_div);

            bucket.upload(params).on('httpUploadProgress', function(evt) {
                // console.log(parseInt((evt.loaded * 100) / evt.total));
                $("#loader_"+id).html(parseInt((evt.loaded * 100) / evt.total) + "%");

                }).send(function(err, data) {
                    $("#loader_"+id).remove();
                });
           

        }
    }


}




// driver function //

$("body").on('click', '#crop_it', function () {
    SAVE_CROPPER_IMAGE_ON_SERVER.__show_uploaded_images_on_carousel('cropped_image_preview');
});

$("body").on('click', '.trash-ico', function () {
    $(this).closest('li').remove();
});





