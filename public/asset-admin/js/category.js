/**
 * @desc used to custom validation of jquery for
 * @date 08/02/2019
//  */
// $.validator.addMethod("checkImage", function (value, element) {
//   alert("");
//     var cflag = true;
//  var checkImage=$("input[name=imgUploadCheck]").val();
// //   alert("1");
// // console.log("availableCount="+availableCount+"userCount="+userCount);
//    if(checkImage==0){
//     cflag=false;
//    }
//     return cflag;
// }, );

/**
 * validation of the form
 */
$("#admin_category").validate({
    ignore: [],
    rules: {
        category_name: {
            required : true,
            maxlength : 150
        },
        status : {
            required : true
        },
        imgUploadCheck : {
            required : true
        },
      
       
    },
    submitHandler: function ( form ) {
        $("#submit-btn").attr('disabled',true);
        $("#submit-btn").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
       form.submit();
    }
});

var _URL = window.URL || window.webkitURL;

$("#thumbImage").change(function(e) {
    var file, img;
    

    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function() {
            // alert(this.width + " " + this.height);
            if(!(this.width==100 && this.height==100)){
                alert("Please upload (100X100)Px size Image");
                $("#thumbImage").val('');
                return false;
            }
           
            // s3_upload_directly_BackgroundImage();
            s3_upload_directly_BackgroundImage('thumbImage','error_file','thumbUrl','','','upload_preview_id');
            // readURL(this);
            
           
        };
        img.onerror = function() {
            alert( "not a valid file: " + file.type);
        };
        img.src = _URL.createObjectURL(file);


    }

});






/**
             * image preview script
             *
             */
            function readURL(input, id) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.image_preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".imgprev").change(function () {
                
                var id = $(this).attr('id');
                readURL(this, id);
            });

//   $("#imgInp").change(function() {
//     readURL(this);
//   });