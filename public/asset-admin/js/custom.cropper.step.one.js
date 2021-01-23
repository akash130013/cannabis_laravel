
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

            var loader_div = "<div class='progressbar' id='loader_"+id+"'></div>";
            var hidden = "<input id='image_" + id + "' type='hidden' name='product_images[]' value='" + aws_config.S3_URL + objKey + "'>";
            $('.upload-prod-pic-wrap ul').append('<li>' + hidden + loader_div+ '<span class="trash-ico" data-key="'+objKey+'"><i class="fa fa-times" aria-hidden="true"></i></span><a href="' + aws_config.S3_URL + objKey + '" data-lightbox="example-set"><img id="imageFile'+id+'" data-src="' + file + '"></a></li>')

            bucket.upload(params).on('httpUploadProgress', function(evt) {
                // console.log(parseInt((evt.loaded * 100) / evt.total));
                var per = ((evt.loaded / evt.total) * 100).toFixed(2);
                $("#loader_"+id).html("<progress max='100' value = '"+per+"' data-label='"+per+" complete'></progress>");

                }).send(function(err, data) {
                   $("#loader_"+id).remove();
                    var ImageSrc = $("#imageFile"+id).attr('data-src');
                    $("#imageFile"+id).attr('src',ImageSrc);

                });
        }
    }
}

$("body").on('click', '#crop_it', function () {
    SAVE_CROPPER_IMAGE_ON_SERVER.__show_uploaded_images_on_carousel('cropped_image_preview');
});


$("body").on('click', '.trash-ico', function () {
    var key = $(this).attr('data-key');
    var input_value =  $("input[name='product_images[]']");
    var id = $(this);

    // console.log("step 1");
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: true,
      }, function(){

        var values = input_value.map(function(){return id.val();}).get();
        if(values.length==1){
            $("#imgUploadCheck").val("");
        }
        // console.log(values.length);
        // console.log(key);
        $('#crop-image-id li').first().remove();
        if(key==undefined){

            id.closest('li').remove(); 
           return false;
        }
        
        id.closest('li').remove(); 
        var cat_id  = $("#cat_id").val();  // id of the table
        var type    = $("#pageName").val();  
    
        removeImageFromS3BucketCat(key,id,cat_id,type);
      });

});

function removeImageFromS3BucketCat(objKey,id,cat_id,type) {
    
    var params = { Bucket: aws_config.bucket, Key: objKey };
    bucket.deleteObject(params, function (err, data) {
        if (err) {
            alert(err);
        }
        else {
            if(cat_id!==undefined){
                var data = {
                    "id": cat_id,
                    'type':type,
                };
                $.ajax({
                    method: "GET",
                    url:  '/admin/deletefiles3',
                    data: data,
                    success: function (res) {
                        if(res.code==200){
                        //  $("#"+id).html("");
                        id.closest('li').remove();

                        //  $("#"+display).val("");
                        //  $("#"+fileid).val("");
                        }else{
                            flag=false;
                            alert("Someting went wrong.. Please try again");
                        }
                    }
                });
            }

            
        }                   // deleted
    });

}





