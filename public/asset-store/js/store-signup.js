jQuery.validator.addMethod("validate_email", function(value, element) {

    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
        return true;
    } else {
        return false;
    }
    }, "Please enter a valid Email.");
    
    //======================for the first step signup=====================================================//
        $("#store_login_validation").validate({
                errorClass:'error',
                errorElement:'span',
                rules: {
                    first_name: {
                        required : true,
                        maxlength : 50,
                        minlength : 3
                    },
                    second_name: {
                        required : true,
                        maxlength : 50,
                        minlength : 3
                    },
                    email: {
                        required: true,
                        maxlength : 150,
                        validate_email: true,
                    },
                    agree: "required"
                },
                // errorPlacement: function (error, element) {
                //        error.appendTo($(element).parents('.text-field-wrapper').next());
                // },
                messages: {
                    first_name: {
                        required : "Please enter your firstname"
                    },
                    second_name:{
                        required : "Please enter your lastname"
                    },
                    email: "Please enter a valid email address",
                    agree: "Please accept our policy",
                }
            });
//===========================first step close=======================================//
             
////for the second signup step----------------------------------------------------///
password('remember_me', 'password_type');

    $("#password_validation").validate({
            errorClass:'error',
            errorElement:'span',
            rules: {
                password: {
                    required: true
                },
            },
        messages: {
            password: {
                required: "Please provide a password"
            },

        }
    });


    function checkPasswordStrength() {
        var number = /([0-9])/;
        var alphabets = /([a-zA-Z])/;
        var upperCase = /([A-Z])/;
        var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
        if ($('#password_type').val().length < 8) {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('error');
            $('#password-strength-status').html("Weak (good to have atleast 8 characters.)");
            // $("#signup_button").prop('disabled',true);
            $('#password-strength-status').css('color','red');
        } else {
            if ($('#password_type').val().match(number) && $('#password_type').val().match(upperCase) && $('#password_type').val().match(alphabets) && $('#password_type').val().match(special_characters)) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('strong-password');
                $('#password-strength-status').html("Strong");
                $('#password-strength-status').css('color','green');
                // $("#signup_button").prop('disabled',false);
            } else {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('error');
                $('#password-strength-status').html("Medium");
                // $("#signup_button").prop('disabled',false);
                $('#password-strength-status').css('color','red');
            }
        }
    }
    ///////second signup close--------------------------------------------------------