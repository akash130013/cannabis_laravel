//Add new driver validation
$("#add_Driver").validate({
    ignore: [],
    rules: {
        name: {
            required: true,
            maxlength: 150
        },
        email: {
            required: true,
            email: true,
            remote: {url: $("#search_existing_email_route").val(), type : "get"}
        },
        mobile_number: {
            required: true,
            phoneUS : true,
            remote: {url: $("#search_existing_email_route").val(), type : "get"},
           // pattern : "^(1\s?)?((\([0-9]{3}\))|[0-9]{3})[\s\-]?[\0-9]{3}[\s\-]?[0-9]{4}$",
        },
        gender: {
            required: true,
        },
        address: {
            required: true,
        },
        city: {
            required: true,
            maxlength: 150

        },
        state: {
            required: true,
            maxlength: 150

        },
        pincode: {
            required: true,
            maxlength: 6,
            number: true
        },
        profile_image: {
            required: true,
            accept: "image/*"
        },
        "proofs[license]": {
            required:true,
            accept:"image/*, application/pdf"
            // required: function (e) {
            //     var required = 1;
            //     $.each($('.proofs').get(), function (i, val) {
            //
            //         if (val.files[0] !== '' && val.files[0] !== undefined)
            //         {
            //             var mimeType = val.files[0].type;
            //             if(mimeType != 'application/pdf' || mimeType != 'image/*')
            //             {
            //                 return false;
            //             }
            //             required++;
            //         }
            //     })
            //     if (required == 1) {
            //         return true
            //     } else {
            //         return false
            //     }
            // }
        },
        "proofs[valid_proof]":{
            accept:"image/*, application/pdf"
        },
        "proofs[other]":{
            required:true,
            accept:"image/*, application/pdf"
        }

    },
    errorPlacement: function(error, element) {
        if (element.attr("name") == "gender") {
           error.insertAfter("#gender-error");
        } else {
           error.insertAfter(element);
        }
      },
    messages: {
        "proofs[license]": {
            required: "Please upload license proof",
            accept: "File format not supported"

        },
        "proofs[valid_proof]":{
            accept:"File format not supported"
        },
        "proofs[other]":{
            required: "Please upload vehicle Image",
            accept:"File format not supported"
        },
        email:{
            required: "Please enter driver valid email",
            remote : "This email address is already taken."
        },
        mobile_number:{
            required: "Please enter driver mobile number",
            remote : "This mobile number is already taken"
        },
        name: {
            required: "Please enter driver name",
        },
        gender: {
            required: "Please select driver gender",
        },
        address: {
            required: "Please enter driver address",
        },
        city: {
            required: "Please enter driver city",
        },
        state: {
            required: "Please enter driver state",
        },
        pincode: {
            required: "Please enter driver pincode",
        },
        profile_image: {
            required: "Please upload driver profile image",
        }
    },
    // errorPlacement: function (error, element) {
    //     error.insertAfter(element);
    //     if (element.context.name == "gender") {
    //         error.appendTo(element.parent().parent().parent().siblings('.error_message'))
    //     }
    //     if (element.context.name == "proofs[license]") {
    //         error.appendTo(element.parent().parent().siblings('.error_message'))
    //     }
    //
    // },
    submitHandler: function (form) {
        $("#spinner").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
        $("#spinner").prop('disabled',true);
        form.submit();
    }
});
//edit driver validation
$("#edit_Driver").validate({
    ignore: [],
    rules: {
        name: {
            required: true,
            maxlength: 150
        },
        email: {
            required: true,
            email: true,
        },
        mobile_number: {
            required: true,
            minlength: 10,
            number: true
        },
        gender: {
            required: true,
        },
        address: {
            required: true,
        },
        city: {
            required: true,
            maxlength: 150

        },
        state: {
            required: true,
            maxlength: 150

        },
        pincode: {
            required: true,
            maxlength: 6,
            number: true
        },
        "proofs[license]": {
            accept: "image/*, application/pdf"
        },
        "proofs[valid_proof]":{
            accept:"image/*, application/pdf"
        },
        "proofs[other]":{
            accept:"image/*, application/pdf"
        }
    },
    messages: {
        "proofs[license]": {
            accept: "File format not supported"
        },
        "proofs[valid_proof]":{
            accept:"File format not supported"
        },
        "proofs[other]":{
            accept:"File format not supported"
        },
        name: {
            required: "Please enter driver name",
        },
        email: {
            required: "Please enter driver valid email",
        },
        gender: {
            required: "Please select driver gender",
        },
        address: {
            required: "Please enter driver address",
        },
        city: {
            required: "Please enter driver city",
        },
        state: {
            required: "Please enter driver state",
        },
        pincode: {
            required: "Please enter driver pincode",
        },
        profile_image: {
            required: "Please upload driver profile image",
        },
        mobile_number: {
            required: "Please enter driver mobile number",
        },
    },
    errorPlacement: function (error, element) {
        error.insertAfter(element);
        if (element.context.name == "gender") {
            error.appendTo(element.parent().parent().parent().siblings('.error_message'))
        }
        if (element.context.name == "proofs[license]") {
            error.appendTo(element.parent().parent().siblings('.error_message'))
        }

    },
    submitHandler: function (form) {
        $("#spinner").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
        $("#spinner").prop('disabled',true);
        form.submit();
    }
});


/**
 * profile image upload
 */

var _URL = window.URL || window.webkitURL;
var fileOnChange = $('#upload_img');
fileOnChange.change(function () {
    var inputFile;
    inputFile = this;
    readURL(inputFile);

    // checkDimension(500, 500, inputFile);
});

function checkDimension(width, height, input) {
    var file, img;
    if ((file = input.files[0])) {
        img = new Image();
        img.onload = function () {
            readURL(input);

            // if (this.width == width && this.height == height) {
            readURL(input);
            // } else {
            //     $('#upload_img').val('');
            //     swal('Invalid Image dimension, Please choose a ' + width + 'x' + height + ' image');
            // }
        };
        img.onerror = function () {
            alert("not a valid file: " + file.type);
        };
        img.src = _URL.createObjectURL(file);
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        $('#img-preview').parent('div').show();
    }
}


$('#fileToUpload_1').on('change', function () {
    $('#fileToUpload_name_1').val(this.files[0].name)
})

$('#fileToUpload_2').on('change', function () {
    $('#fileToUpload_name_2').val(this.files[0].name)
})

$('#fileToUpload_3').on('change', function () {
    $('#fileToUpload_name_3').val(this.files[0].name)
})

$('.proofs, .driver_profile_img').on('change', function () {
    let form = $(this).closest('form').attr('id')
    $('#'+form).valid()
})
