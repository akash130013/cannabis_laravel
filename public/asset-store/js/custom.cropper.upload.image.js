
var SAVE_CROPPER_IMAGE_ON_SERVER = {

    

    __show_uploaded_images_on_carousel: function (input) {

        var ImageSrc = $("#" + input).attr('src');

        try {
            if (ImageSrc == "") {
                throw "Image not found";
            }

            var imageLength = $('.upload-prod-pic-wrap ul li').length;
            if (imageLength == 5) {
              
                throw "Cannot upload more than five images";
                
            }

            SAVE_CROPPER_IMAGE_ON_SERVER.__upload_image_external_location(ImageSrc);

        } catch (err) {
            alert(err);
        }

    },

    /**for banner */
    __show_uploaded_images_on_carousel_banner: function (input) {

        var ImageSrc = $("#" + input).attr('src');

        try {
            if (ImageSrc == "") {
                throw "Image not found";
            }

            SAVE_CROPPER_IMAGE_ON_SERVER.__upload_image_external_location_banner(ImageSrc);

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
            var hidden = "<div class='uploadImages'><div class='image'><input id='image_" + id + "' type='hidden' name='images[]' value='" + aws_config.S3_URL + objKey + "'>";
            var removeICON = $("#close_icon").val();
            
            $('.upload-prod-pic-wrap ul').append('<li>' + hidden + loader_div+ '<img src="'+removeICON+'" class="close trash-ico"/><a href="' + aws_config.S3_URL + objKey + '" data-lightbox="example-set"><img id="imageFile'+id+'" data-src="' + file + '"></a></div></div></li>')

            bucket.upload(params).on('httpUploadProgress', function(evt) {
                var per = parseInt((evt.loaded * 100) / evt.total);
                $("#loader_"+id).html("<progress max='100' value = '"+per+"' data-label='"+per+" complete'></progress>");

                }).send(function(err, data) {
                   $("#loader_"+id).remove();
                    var ImageSrc = $("#imageFile"+id).attr('data-src');
                    $("#imageFile"+id).attr('src',ImageSrc);
                    $("#hiddenImage").val("1");
                    $("#hiddenImage-error").html("");
                });
        }
    },
    

    /**
     * 
     * @param {*} file
     * @desc for banner only 
     */
    __upload_image_external_location_banner: function (file) {

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
            var hidden = "<div class='uploadImages'><div class='image'><input id='image_" + id + "' type='hidden' name='images[]' value='" + aws_config.S3_URL + objKey + "'>";
            var removeICON = $("#close_icon").val();
            
            $("#bannerImage").val(aws_config.S3_URL + objKey);

            $("#upload-banner-image").css('display','block');
            // $('#upload-banner-image').
            $("#upload-banner-image img:last-child").remove()
            $('#upload-banner-image').append('<img class="banner-store-img" id="imageFile'+id+'" data-src="' + file + '"></div></div>')

            bucket.upload(params).on('httpUploadProgress', function(evt) {
                var per = parseInt((evt.loaded * 100) / evt.total);
                $("#loader_"+id).html("<progress max='100' value = '"+per+"' data-label='"+per+" complete'></progress>");

                }).send(function(err, data) {
                   $("#loader_"+id).remove();
                    var ImageSrc = $("#imageFile"+id).attr('data-src');
                    $("#imageFile"+id).attr('src',ImageSrc);
                    $("#bannerImage-error").html("");
                });
        }
    }

}




/**
 * @desc crop image 
 */
$("body").on('click', '#crop_it', function () {
    SAVE_CROPPER_IMAGE_ON_SERVER.__show_uploaded_images_on_carousel('cropped_image_preview');
});

/**
 * @desc crop banner image
 */
$("body").on('click', '#crop_it_banner', function () {
    SAVE_CROPPER_IMAGE_ON_SERVER.__show_uploaded_images_on_carousel_banner('cropped_image_preview_banner');
});

$("body").on('click', '.trash-ico', function () {
   
    
    var values = $("input[name='images[]']")
    .map(function(){return $(this).val();}).get();

    if(values.length==1){
        $("#imgUploadCheck").val("");
    }
   
    $(this).closest('li').remove();
});

$("body").on('click', '.trash-ico-banner', function () {
   
    $(this).next().remove();
    $(this).remove();
});




