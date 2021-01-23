var sec = 60;
var myTimer = document.getElementById('myTimer');
var REGISTRATION = {

    ERROR_LANG  : 
    {

        NUMBER_ERRO : 'Please enter your mobile number',
        EMAIL_ERR   : 'Please enter your email address',
        PASS_ERR    : 'Please enter your password',
        CPASS_ERR   : 'Please enter your confirm password',
        ADD_ERR     : 'Please enter your address',
        NAME_ERR    : 'Please enter your restaurant name',
        VALID_EMAIL_ERR : 'Please enter valid email address',
        CPASS_NOTMATCH_ERR : "Confirm password doesn't matches",
        PASS_ERR_LENGTH : "Password minimum lenght must be 8 characters",
        CPASS_ERR_LENGTH : "Confirm Password minimum lenght must be 8 characters",
        EXT_EMAIL : 'This email address is already taken.',
        NUMBER_EXIST : "This mobile number is already taken"
    },

    __send_otp_client : function(country_code,mobile,email) {

        $.ajax({
            url: 'send-otp',
            type:"GET",
            dataType:'json',
            data : {'phone_number':mobile,'country_code':country_code,'email':email},
            beforeSend : function(){
                            $(".loader").show();
            },
            success: function(response) {
                            
                    if(parseInt(response.code) == 200) {
                        sec = 60;
                        $("#hidden_otp_value").val(response.result);
                        $("#myTimer").css('opacity',1);
                        countDown();
                        $("#myModal").modal({backdrop: 'static', keyboard: false, show:true});
                    }
                  
            },
            error : function(response) {

                if(parseInt(response.responseJSON.code) == 422) {
                    $("#restaurant_email_error").html(REGISTRATION.ERROR_LANG.EXT_EMAIL);
                    $("#restaurant_email").focus();
                }else if(parseInt(response.responseJSON.code) == 406) {
                    $("#number_error").html(REGISTRATION.ERROR_LANG.NUMBER_EXIST);
                    $("#user_phone_number").focus();
                }
                    
            },
            complete : function(){
                $(".loader").hide();
            }
        });
    },

    __validate_email_mobile_number_exists : function(type,data) {

        var returnVal = true;
        $.ajax({
            url: 'validate-mobile',
            type:"GET",
            dataType:'json',
            async : false,
            data : {'type':type,'data':data},
            success: function(response) {
                    if(parseInt(response.code) == 200) {
                        returnVal = false;
                    }
                  
            }
        });

        return returnVal;

    },

    __load_json_data_from_server_number : function() {
       
        $.getJSON("country.json", function( data ) {
            // console.log(data);
            var items = [];
            var html = "";
            $.each( data, function( key, val ) {
                if(val.dial_code == '+1') {
                    html += "<option selected value='" + val.dial_code + "'>" + val.dial_code + "</option>";
                } else {
                    html += "<option value='" + val.dial_code + "'>" + val.dial_code + "</option>";
                }
                 
            });

            $("#country_code_number").html(html);
            $('.selectpicker').selectpicker('refresh');
           
          });
       

       
    }

}

// focus on first input of otp //
$('.modal').on('shown.bs.modal', function() {
    $(this).find('input:first').focus();
});
// clear all error on key press event //
$('body').on('keypress','input',function(){
    if(!$(this).hasClass('input-block-level')) {
        $(this).next().html('');
        $(this).parent().next().html('');
    }
    
});

$("body").on('change','#terms',function(){
    if($(this).is(':checked')) {
        $("#error_terms_condition").html('');
    }
});




// send otp when user press signup button //
$('body').on('click','#submit_button_signup',function(){
    $(".error-message").html('');
    var number = $("#user_phone_number").val();
    var code   = $("#country_code_number").val();
    var name   = $("#restaurant_name").val();
    var email  = $("#restaurant_email").val();
    var pass   = $("#password_input").val();
    var cpass  = $("#confirm_password").val();
    var address = $("#address").val();
    var terms   = $("#terms").is(':checked');
    var re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    var error = false;
    var errorArr = [];

    if($.trim(name) == "") {
        $("#restaurant_name_error").html(REGISTRATION.ERROR_LANG.NAME_ERR);
        errorArr.push('restaurant_name');
        error = true;
    }

     if($.trim(email) == "") {
        $("#restaurant_email_error").html(REGISTRATION.ERROR_LANG.EMAIL_ERR);
        errorArr.push('restaurant_email');
         error = true;
    }

     else if(!re.test($.trim(email))) {

        $("#restaurant_email_error").html(REGISTRATION.ERROR_LANG.VALID_EMAIL_ERR);
        errorArr.push('restaurant_email');
         error = true;
    }

     if($.trim(number) == "") {
        $("#number_error").html(REGISTRATION.ERROR_LANG.NUMBER_ERRO);
         errorArr.push('user_phone_number');
         error = true;
    }

     if($.trim(pass) == "") {
        $("#password_error").html(REGISTRATION.ERROR_LANG.PASS_ERR);
        errorArr.push('password_input');
         error = true;
    } 

     else if(pass.length < 8) {
        $("#password_error").html(REGISTRATION.ERROR_LANG.PASS_ERR_LENGTH);
        errorArr.push('password_input');
         error = true;
    }

     if($.trim(cpass) == "") {
        $("#confirm_password_error").html(REGISTRATION.ERROR_LANG.CPASS_ERR);
        errorArr.push('confirm_password');
         error = true;
    }

     else if(cpass.length < 8) {
        $("#confirm_password_error").html(REGISTRATION.ERROR_LANG.CPASS_ERR_LENGTH);
        errorArr.push('confirm_password');
         error = true;
    }

     if($.trim(pass) != $.trim(cpass)) {
        $("#confirm_password_error").html(REGISTRATION.ERROR_LANG.CPASS_NOTMATCH_ERR);
        errorArr.push('confirm_password');
         error = true;
    }

  
     if($.trim(address) == "") {
        $("#address_error").html(REGISTRATION.ERROR_LANG.ADD_ERR);
        errorArr.push('address');
         error = true;
    }

    if(!terms) {
        $("#error_terms_condition").html("Please accept terms and conditions.");
        errorArr.push('error_terms_condition');
        error = true;
    }

    if(error) {
        var id = errorArr[0];
        $("#"+id).focus();
        return false;
    }

    REGISTRATION.__send_otp_client(code,number,email);
});

// verify otp entered by the user //

$('body').on('click','#otp_verify_button',function(){
    $("#otp_error_id").html('');
    var otphash = $("#hidden_otp_value").val();
    var sum = 0;
    
    // get otp number //
    $('.otp-field').each(function(i,ele){
        sum = (sum * 10) + parseInt($.trim($(ele).val()));
    });

    if(isNaN(sum)) {
        $("#otp_error_id").html('Please enter otp received');
        return false;
    }
    
    else if(sha256(sum.toString()) != otphash) {
        $("#otp_error_id").html('Please enter valid OTP');
        return false; 
    } 

    $("#myModal").modal('hide');
    $("#form_submit_signup").submit();

});

// change focus on input of opt //
$('body').on('keyup','.otp-field',function(){
    if (this.value.length == this.maxLength) {
        $(this).next('.otp-field').focus();
    }
});

$('#myModal').on('hidden.bs.modal', function (e) {
    $(this)
      .find("input,textarea,select")
         .val('')
         .end()
      .find("input[type=checkbox], input[type=radio]")
         .prop("checked", "")
         .end();
         $("#myTimer").html('');
  })


$(document).ready(function(){

    $('body').on('keyup', '.otp-field', function()
    {
      var key = event.keyCode || event.charCode;
      var inputs = $('.otp-field');
      if(($(this).val().length === this.size) && key != 32)
      {
        inputs.eq(inputs.index(this) + 1).focus();  
      } 
      if( key == 8 || key == 46 )
      {
        var indexNum = inputs.index(this);
        if(indexNum != 0)
        {   
            inputs.eq(inputs.index(this)).val('');
            inputs.eq(inputs.index(this) - 1).focus();
        }
      }

    });
  });

// resend otp if not received //
$('body').on('click','#resent_button_otp',function(){
    $("#otp_error_id").html('');
    $('.otp-field').val('');
    $(this).prop('disabled',true);
    var number = $("#user_phone_number").val();
    var code   = $("#country_code_number").val();
    var email  = $("#restaurant_email").val();
    REGISTRATION.__send_otp_client(code,number,email);
});


// // driver function //

$(document).ready(function(){
  REGISTRATION.__load_json_data_from_server_number();
});



//------------------simple validation functions ---------------//

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
 }


function countDown() 
{
  if (sec < 10) {
    myTimer.innerHTML = "In "+ "0" + sec + " sec";
  } else {
    myTimer.innerHTML = "In "+ sec + " sec";
  }
  if (sec <= 0) {
    $("#resent_button_otp").removeAttr("disabled");
    $("#myTimer").fadeTo(2500, 0);
    return;
  }
  sec -= 1;
  window.setTimeout(countDown, 1000);
}
