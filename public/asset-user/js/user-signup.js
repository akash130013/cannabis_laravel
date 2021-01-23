
var input = document.querySelector("#phone"),
    errorMsg = document.querySelector("#error-msg"),
    validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
var errorMap = ["Please enter valid mobile number", "Invalid country code", "Mobile number length is too short", "Mobile number length is too long", "Please enter valid mobile number"];

// initialise plugin
var iti = window.intlTelInput(input, {
    hiddenInput: "full_phone",
    onlyCountries: ["us"],
    preferredCountries: ["us"],
    allowDropdown: false,
    utilsScript: "{{asset('asset-store/js/intl-tel-input-master/src/js/utils.js')}}"
});

var reset = function () {
    input.classList.remove("error");
    errorMsg.innerHTML = "";
    errorMsg.classList.add("hide");
    validMsg.classList.add("hide");
};

// on blur: validate
input.addEventListener('blur', function () {
    reset();
    if (input.value.trim()) {
        if (iti.isValidNumber()) {

            validMsg.classList.remove("hide");
        } else {
            input.classList.add("error");
            var errorCode = iti.getValidationError();
            errorMsg.innerHTML = errorMap[errorCode];
            errorMsg.classList.remove("hide");
        }
    }
});

// on keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);


jQuery.validator.addMethod("noSpace", function (value, element) {
    return value.indexOf(" ") < 0 && value != "";
}, "No spaces are allowed");

//====custom email validation===================//
jQuery.validator.addMethod("validate_email", function (value, element) {

    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
        return true;
    } else {
        return false;
    }
}, "Please enter a valid Email.");

//==============custom validation of referal code=====================//
/**
 * @desc used to custom validation of jquery for
 * @date 08/02/2019
 */
$.validator.addMethod("checkReferalCode", function (value, element) {

    var cflag = false;
    var refer_code = Number($("#is_referal_code").val());
    var refer_code_val = $("#referal_code").val();

    $("#refer").text('');
    if (refer_code_val.length == 0) {
        return true;
    }
    console.log(refer_code);

    if (refer_code == 0) {
        cflag = true;
    }

    if (refer_code == 1) {
        cflag = true;
    }

    return cflag;

}, "Please enter a valid referal code");



$.validator.addMethod('checkEmail', function (value) {
    return /^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$/.test(value);
}, 'Please enter a valid email address.');


$("#user_login").validate({
    errorClass: 'error',
    errorElement: 'span',
    ignore: [],
    rules: {
        user_name: {
            required: true,
            maxlength: 50,
            minlength: 3,

        },
        // email: {
        //     checkEmail: true,
        // },
        password: {
            required: true,
            minlength: 6,
        },
        phone: {
            required: true,
        },
        // referal_code:{
        //     remote: {url: $("#refer_url").val(), type : "get"}
        // }

    },

    highlight: function (element) {
        $(element).parent('div').parent("div").addClass('error-message');
    },
    unhighlight: function (element) {
        $(element).parent().parent().removeClass('error-message');

    },
    errorPlacement: function (error, element) {
        error.appendTo($(element).parents('.text-field-wrapper').next());
    },
    messages: {
        user_name: {
            required: "Please enter your name",
        },
        password: {
            required: "Please enter password",
        },
        // email: {
        //     checkEmail: "Please enter a valid email address",
        // },
        phone: {
            required: "Please enter valid mobile number",
        },
        // referal_code:{
        //     remote: "Referal code is not valid",
        // }

    },
    submitHandler: function (form) {
        if (iti.isValidNumber()) {
            $("input[name='phone_code']").val(iti.s.dialCode);
            $("#signup_button").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
            form.submit();

        }
    }
});



////////////////////////////////////////////////////////OTP CLOSE




function checkPasswordStrength() {
    var number = /([0-9])/;
    var alphabets = /([a-z])/;
    var upperCase = /([A-Z])/;
    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;

    if ($('#password_type').val().length >= 6) {

        if ($('#password_type').val().length < 8) {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('weak-password');
            $('#password-strength-status').addClass('error');
            $('#password-strength-status').html("Weak (good to have atleast 8 characters.)");
            // $("#signup_button").prop('disabled', true);
            $('#password-strength-status').css('color', 'red');
            // $('#password-strength-status').addClass('error');

        } else {
            if ($('#password_type').val().match(number) && $('#password_type').val().match(upperCase) && $('#password_type').val().match(alphabets) && $('#password_type').val().match(special_characters)) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('strong-password');
                $('#password-strength-status').html("Strong");
                $('#password-strength-status').css('color', 'green');
                // $("#signup_button").prop('disabled', false);
            } else {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('medium-password');
                $('#password-strength-status').html("Medium (good to have at least 1 alphabet , 1 number , 1 special character , 1 upper case and 1 lower case)");
                // $("#signup_button").prop('disabled', true);
                // $('#password-strength-status').css('color', 'red');
                $('#password-strength-status').addClass('error');

            }
        }
    } else {
        $('#password-strength-status').html('');

    }
}

setTimeout(() => {
    $("#refer_code_error").fadeOut();
}, 3000);


///****debounce function

function debounce(func, wait, immediate) {
    // 'private' variable for instance
    // The returned function will be able to reference this due to closure.
    // Each call to the returned function will share this common timer.
    var timeout;

    // Calling debounce returns a new anonymous function
    return function () {
        // reference the context and args for the setTimeout function
        var context = this,
            args = arguments;

        // Should the function be called now? If immediate is true
        //   and not already in a timeout then the answer is: Yes
        var callNow = immediate && !timeout;

        // This is the basic debounce behaviour where you can call this 
        //   function several times, but it will only execute once 
        //   [before or after imposing a delay]. 
        //   Each time the returned function is called, the timer starts over.
        clearTimeout(timeout);

        // Set the new timeout
        timeout = setTimeout(function () {

            // Inside the timeout function, clear the timeout variable
            // which will let the next execution run when in 'immediate' mode
            timeout = null;

            // Check if the function already ran with the immediate flag
            if (!immediate) {
                // Call the original function with apply
                // apply lets you define the 'this' object as well as the arguments 
                //    (both captured before setTimeout)
                func.apply(context, args);
            }
        }, wait);

        // Immediate mode and no wait timer? Execute the function..
        if (callNow) func.apply(context, args);
    }
}

/////////////////////////////////
// DEMO:

function checkReferalValidity(e) {

    var refer_code = $("#referal_code").val();
    if (refer_code == '') {
        $("#spinner").html("");
        $("#refer").text("");
        return false;
    }

    var data = {
        "refer_code": refer_code,

    };

    $.ajax({
        method: "get",
        url: "/user/referal",
        data: data,
        beforeSend: function () {
            $("#spinner").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
        },
        error: function () {
            alert("Something went wrong Please try again");
            // NProgress.done();
        },
        success: function (res) {
            if (200 == res.code) {
                $("#is_referal_code").val("1");
                $("#spinner").html(`<i class="fa fa-check" aria-hidden="true" style="color: darkseagreen;"></i>`);

                $("#refer").text("");
            } else {
                $("#is_referal_code").val("2");
                $("#refer").css("display", "block");
                $("#refer").text(res.message);
                $("#spinner").html("");
            }
        },
        complete: function () {
            //   $("#spinner").html("");
        }
    });

}

// Define the debounced function
var debouncedMouseMove = debounce(checkReferalValidity, 200);

// document.getElementById("referal_code").addEventListener("keyup", debouncedMouseMove);


function showPassword() {
    var x = document.getElementById("password_type");
    if (x.type === "password") {
        $("#show_eye").show();
        $("#hide_eye").hide();
        x.type = "text";
    } else {
        x.type = "password";
        $("#show_eye").hide();
        $("#hide_eye").show();
    }
}