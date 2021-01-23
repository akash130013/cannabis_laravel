$('#change_password_form').validate({
    errorElement: 'span',
    errorClass: 'help-text error-message text-danger',
    rules: {
        old_password: {
            required: true,
        },
        password: {
            required: true,
            minlength:8,
            maxlength:20
        },
        password_confirmation: {
            required: true,
            minlength:8,
            maxlength:20,
            equalTo: "#password"
        }
    },
    messages: {

    },
    submitHandler: function(form) {
        form.submit();
    }
});

$(document).on('click', '.edit-profile', function(){
    $('.hide_element').show();
    $('.name-span').hide();
    $('.edit-button').hide();
});

$('#save_profile_form').validate({
    errorElement: 'span',
    errorClass: 'help-text error-message text-danger',
    rules: {
        name: {
            required: true,
            minlength:3,
            maxlength:100
        }
    },
    messages: {

    },
    submitHandler: function(form) {
        form.submit();
    }
});
