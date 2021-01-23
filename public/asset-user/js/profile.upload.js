  //Panel Domain Name
  const domain = window.location.hostname;

  //Panel Protocol https/http
  const host = window.location.protocol;

  //Panel used port
  const port = window.location.port;

  // Generated URL
  const URL = host + "//" + domain + ":" + port;

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// alert($('meta[name="csrf-token"]').attr('content'));

var SAVE_CROPPER_IMAGE_ON_SERVER = {
    __ajaxSuccess:function(msg)
    {
        toastr.success(msg, 'Successfully', {
            "closeButton": true,
            "debug": true,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true
        });
    },

    __updateProfile:function(mediaData)
    {
        var data = {
            profilePic:mediaData
        };

        $.ajax({
            method: "POST",
            url:  URL+'/user/upload-profile-pic',
            data: data,
            success: function (res) {
                if(res.code==200){
                    $(".full-loader").css("display","none");
                    // if (res.code == 200) {
                    //     SAVE_CROPPER_IMAGE_ON_SERVER.__ajaxSuccess(res.message);
                    // }else{
                        swal('success',res.message);
                    // }

                }else{
                    alert("Someting went wrong.. Please try again");
                }
            }
        });
    },

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

            bucket.upload(params).on('httpUploadProgress', function(evt) {
                var per = parseInt((evt.loaded * 100) / evt.total);
                $("#loader_").html("<progress max='100' value = '"+per+"' data-label='"+per+" complete'></progress>");

                }).send(function(err, data) {
                   $("#loader_").remove();
                    // var ImageSrc = $("#imageFile"+id).attr('data-src');
                    $("#imageFile").attr('src',file);
                    $('#profilePic').attr('value',aws_config.S3_URL+objKey);
                    // $("#imageFile"+id).attr('src',ImageSrc);
                    //  document.getElementById("submitButton").click();
                    SAVE_CROPPER_IMAGE_ON_SERVER.__updateProfile(aws_config.S3_URL+objKey);
                });
        }
     }
}

$("body").on('click', '#crop_it', function () {
    SAVE_CROPPER_IMAGE_ON_SERVER.__show_uploaded_images_on_carousel('cropped_image_preview');
});


$("body").on('click', '.trash-ico', function () {
   
    
    var values = $("input[name='images[]']")
    .map(function(){return $(this).val();}).get();

    if(values.length==1){
        $("#imgUploadCheck").val("");
    }
   
    $(this).closest('li').remove();
});





