var FORGOT_PASSWORD = {

    ERROR_LANG: {

        EMAIL_ERR: 'Please enter your email address',
        VALID_EMAIL_ERR: 'Please enter valid email address',

    },

    __send_email_client: function (email) {

        $.ajax({
            url: 'password/email',
            type: "POST",
            dataType: 'json',
            data: { 'email': email },
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (response) {
                if (parseInt(response.code) == 200) {
                    $("#restaurant_forgot_email_success").html(response.message);
                } else {
                    $("#restaurant_forgot_email_error").html(response.message);
                }

            },
            complete : function(){
                $(".loader").hide();
            }
        });
    }

}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('body').on('click', '#submit_button_forgot', function () {
    $(".error-message").html('');
    var email = $("#restaurant_forgot_email").val();


    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        $("#restaurant_forgot_email_error").html(FORGOT_PASSWORD.ERROR_LANG.VALID_EMAIL_ERR);
        $("#restaurant_forgot_email").focus();
        return false;
    }


    if ($.trim(email) == "") {
        $("#restaurant_forgot_email_error").html(FORGOT_PASSWORD.ERROR_LANG.EMAIL_ERR);
        $("#restaurant_forgot_email").focus();
        return false;
    }

    FORGOT_PASSWORD.__send_email_client(email);
});

$('body').on('keypress', 'input', function () {
    $(this).next().html('');
});




var RESET_PASSWORD = {

    ERROR_LANG: {

        PASS_ERR: 'Please enter your password',
        CPASS_ERR: 'Please enter your confirm password',
        CPASS_NOTMATCH_ERR: 'Confirm password do not match',
        EMAIL_ERR: "Please enter email address",
        VALID_EMAIL_ERR: "Please enter valid email address"
    },
}

// send otp when user press signup button //
$('body').on('click', '#submit_button_reset', function () {
    $(".error-message").html('');
    var pass = $("#password_input").val();
    var cpass = $("#confirm_password").val();


    if ($.trim(pass) == "") {
        $("#password_error").html(RESET_PASSWORD.ERROR_LANG.PASS_ERR);
        $("#password_input").focus();
        return false;
    }

    else if ($.trim(cpass) == "") {
        $("#confirm_password_error").html(RESET_PASSWORD.ERROR_LANG.CPASS_ERR);
        $("#confirm_password").focus();
        return false;
    }

    else if ($.trim(pass) != $.trim(cpass)) {
        $("#confirm_password_error").html(RESET_PASSWORD.ERROR_LANG.CPASS_NOTMATCH_ERR);
        $("#confirm_password").focus();
        return false;
    }

    $("#reset_submit").submit();
});

$('body').on('click', '#submit_login_button', function () {

    $(".error-message").html('');
    var email = $("#email_address").val();
    var pass = $("#password_input_login").val();
    var re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    var error = false;
    var errorArr = [];

    if ($.trim(email) == "") {
        $("#error_email_address").html(RESET_PASSWORD.ERROR_LANG.EMAIL_ERR);
        errorArr.push('email_address');
        error = true;
    }

    else if (!re.test($.trim(email))) {

        $("#error_email_address").html(RESET_PASSWORD.ERROR_LANG.VALID_EMAIL_ERR);
        errorArr.push('email_address');
        error = true;
    }


    if ($.trim(pass) == "") {
        $("#error_password").html(RESET_PASSWORD.ERROR_LANG.PASS_ERR);
        errorArr.push('password_input_login');
        error = true;
    }

    if (error) {
        var id = errorArr[0];
        $("#" + id).focus();
        return false;
    }

    $("#submit_button_login").submit();

});

