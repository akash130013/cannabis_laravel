

$("body").on('click','#verify_btn',function(){
    
        var old_phone = $("input[name=old_phone]").val();
           console.log(old_phone);
           
    if ((old_phone != iti.getNumber() && iti.isValidNumber() )) 
    {
        var getCode = iti.s.dialCode;
        $("#setDialCodeId").val(getCode);
        SEND_OTP.__submit_new_otp(iti.getNumber(), getCode);

    }  
})

/**
 * @desc used to close model
 */
$('body').on("click", '#closeModel', function (event) {
    var phone = $("input[name=phone]").val();
    $("input[name=old_phone]").val(phone);
    $("#verify_btn").html('');
    
    $("#verify_btn").removeClass('txt-verify');
    $("#verify_btn").addClass('txt-notverify');
    $("#verify_btn").text('verify');
    $("#verify_btn").css("pointer-events", "auto");
    $('#otpModal').modal('hide');
    window.location.reload();
});

function timer(remaining) {
    let timerOn = true;
    var m = Math.floor(remaining / 60);
    var s = remaining % 60;

    m = m < 10 ? '0' + m : m;
    s = s < 10 ? '0' + s : s;
    document.getElementById('timer').innerHTML = m + ':' + s;
    remaining -= 1;

    if (remaining >= 0 && timerOn) {
        setTimeout(function () {
            timer(remaining);
        }, 1000);
        return;
    }

    if (!timerOn) {
        // Do validate stuff here
        return;
    }
    $("#timer").html("");
    $("#otp_has_pass").val("");
    $("#resent_api_button").prop('disabled', false);
}

var SEND_OTP = {
    __submit_new_otp: function (phone, dialCode) {

        $.ajax({
            type: "get",
            url: $("#hidden_resent_url").val(),
            data: {
                "phone": phone,
                "dialCode": dialCode
            },
            cache: false,
            beforeSend: function () {
                $("#verify_btn").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
                $("#opt_resent_error").html("");
            },
            dataType: 'json',
            success: function (response) {
            
                if (parseInt(response.code) == 200) {

                            timer(90);
                            $('#otpModal').modal({backdrop: 'static', keyboard: false});
                            // $(".form-field-group").addClass("error-message");
                            $("#opt_resent_error").html('<div class="alert alert-success"><strong>Success!</strong> ' + response.messages + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                            $("#otp_has_pass").val(response.hash);
                            $("input[name=old_phone]").val(phone);
                            $("input[name=contact_number]").val(phone);
                            $("input[name=dialcode]").val(dialCode);

                } else {
                    $("#error-msg").text(response.messages);
                    $("#verify_btn").html("Verify");
                    $("#verify_btn").removeClass('txt-verify');
                    $("#verify_btn").addClass('txt-notverify');
                    $("#verify_btn").addClass('txt-notverify');}
            },
            error: function () {
                alert('Something went wrong.. Please try again');
            },
            complete: function () {
               
                $("#verify_btn").css("pointer-events", "auto");
            
            }
        });


    }
}


var sha256 = function a(b) {
    function c(a, b) {
        return a >>> b | a << 32 - b
    }
    for (var d, e, f = Math.pow, g = f(2, 32), h = "length", i = "", j = [], k = 8 * b[h], l = a.h = a.h || [], m = a.k = a.k || [], n = m[h], o = {}, p = 2; 64 > n; p++)
        if (!o[p]) {
            for (d = 0; 313 > d; d += p) o[d] = p;
            l[n] = f(p, .5) * g | 0, m[n++] = f(p, 1 / 3) * g | 0
        } for (b += "\x80"; b[h] % 64 - 56;) b += "\x00";
    for (d = 0; d < b[h]; d++) {
        if (e = b.charCodeAt(d), e >> 8) return;
        j[d >> 2] |= e << (3 - d) % 4 * 8
    }
    for (j[j[h]] = k / g | 0, j[j[h]] = k, e = 0; e < j[h];) {
        var q = j.slice(e, e += 16),
            r = l;
        for (l = l.slice(0, 8), d = 0; 64 > d; d++) {
            var s = q[d - 15],
                t = q[d - 2],
                u = l[0],
                v = l[4],
                w = l[7] + (c(v, 6) ^ c(v, 11) ^ c(v, 25)) + (v & l[5] ^ ~v & l[6]) + m[d] + (q[d] = 16 > d ? q[d] : q[d - 16] + (c(s, 7) ^ c(s, 18) ^ s >>> 3) + q[d - 7] + (c(t, 17) ^ c(t, 19) ^ t >>> 10) | 0),
                x = (c(u, 2) ^ c(u, 13) ^ c(u, 22)) + (u & l[1] ^ u & l[2] ^ l[1] & l[2]);
            l = [w + x | 0].concat(l), l[4] = l[4] + w | 0
        }
        for (d = 0; 8 > d; d++) l[d] = l[d] + r[d] | 0
    }
    for (d = 0; 8 > d; d++)
        for (e = 3; e + 1; e--) {
            var y = l[d] >> 8 * e & 255;
            i += (16 > y ? 0 : "") + y.toString(16)
        }
    return i
};

$('#otp_input').on('keyup',function(){
    $("#opt_validation_error").html(""); 
    $("#otp_status").html("");
})

$("body").on('click', '#submit_button_otp', function () {

    var otp = $("#otp_input").val();
    $("#opt_validation_error").html(""); 
    $("#otp_status").html("");
    // $(".form-field-group").removeClass("error-message");
    if (otp.length == 0) {
        // $(".form-field-group").addClass("error-message");
        $("#opt_validation_error").html("Please enter OTP received.");
        return false;
    }


    if (localMsg.BY_PASS_OTP == otp) {
        $("#final_submit_otp").submit();
        return;
    }

    if (sha256(otp.toString()) != $("#otp_has_pass").val()) {

        // $(".form-field-group").addClass("error-message");
        $("#opt_validation_error").html("Your have entered invalid OTP.");
        return false;
    }

    if (iti.isValidNumber()) {
        $("#submit_button_otp").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
        var getCode = iti.s.dialCode;
        $("#setDialCodeId").val(getCode);
        $("#contact_number_final_submit_id").val(iti.getNumber());
        $("#final_submit_otp").submit();
    } else {
        alert("Something went wrong.ry again");
    }



});


var RESEND_MSG_TO_CLIENT = {
    __submit_new_otp: function (phone, dialCode) {
       
        $.ajax({
            type: "get",
            url: $("#hidden_resent_url").val(),
            data: {
                "phone": phone,
                "dialCode": dialCode,
            },
            cache: false,
            beforeSend: function () {
                $("#resent_api_button").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
                $("#opt_resent_error").html("");
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);

                if (parseInt(response.code) == 200) {
                        $("#otp_input").val('');
                        // $(".form-field-group").addClass("error-message");
                        // $("#opt_resent_error").html('<div class="alert alert-success"><strong>Success!</strong> '+ response.messages +'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        $("#opt_resent_error").html('<div class="alert alert-success"><strong>Success!</strong> ' + response.messages + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                        $("#otp_has_pass").val(response.hash);
                        $("input[name=old_phone]").val(phone);
                        $("#phone_number_hidden").val(phone);
                        $("input[name=contact_number]").val(phone);
                        $("input[name=dialcode]").val(dialCode);

                }
            },
            error: function () {

                alert('Something went wrong.. Please try again');
            },
            complete: function () {

                $("#resent_api_button").html('Resend');
                $("#resent_api_button").prop('disabled', true);
                timer(90);
            }
        });


    }
}



$("body").on('click', '#resent_api_button', function () {

    var getCode = iti.s.dialCode;
    RESEND_MSG_TO_CLIENT.__submit_new_otp(iti.getNumber(), getCode);
});


///***button enable and disbale */

$("body").on('keyup', '#phone', function () {

    var new_phone =iti.getNumber();
    var old_phone = $("input[name=old_phone]").val();
   console.log(new_phone+'old='+old_phone);
  

    if (new_phone != old_phone) {
       
        console.log("1");
        
        $("#verify_btn").text('Verify');
        $("#verify_btn").removeClass('txt-verify');
        $("#verify_btn").addClass('txt-notverify');
        $("#verify_btn").css('color','red');
        $("#verify_btn").css("pointer-events", "auto");
    } else {
        $("#verify_btn").text('Verified');
        $("#verify_btn").addClass('txt-verify');
        $("#verify_btn").removeClass('txt-notverify');
        $("#verify_btn").css('color','#8cc83b');
        $("#verify_btn").css("pointer-events", "none");
       
    }
})

$("#verify_btn").css("pointer-events", "none");