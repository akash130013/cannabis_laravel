/**
 * location.js
 */

$('#upload_img').on('change', function (event) {
    var fileName = event.target.files[0].name;
    $('#fileName').val(fileName);
})



$('#save_delivery_location').validate({
    rules: {
        file: {
            required: true,
            accept: "text/csv"
        }
    },
    errorPlacement: function (error, element) {
        error.insertAfter("#upload-error");
    },
    messages: {
        file: {
            required: "Please select a csv/txt file",
            accept: "Please select a csv/txt file only"
        }
    }
});

