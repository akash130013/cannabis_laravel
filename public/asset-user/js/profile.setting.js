 $("#smoke_validation_form").validate({
        errorClass: 'error',
        errorElement: 'span',
        ignore: [],
        rules: {
            username: {
                required: true,
                minlength : 4,
                maxlength:50
            },
            phone: {
                required: true,
            },
            file_name: {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            $(element).parent('div').parent("div").addClass('error-message');
            error.insertAfter(element);
        },
        success: function(label, element) {
            label.parent().parent().removeClass('error-message');
            label.remove();
        },
        submitHandler: function(form, event) {
            
            if (iti.isValidNumber()) {
                
                var getCode = iti.s.dialCode;
                $("#setDialCodeId").val(getCode);
                $("#submit_button").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
                form.submit();
            }
        },
    });

    $("#location").geocomplete({
        details: "form",
        componentRestrictions: {
            country: "us"
        }
    });

  $("body").on("click","#edit-email",function(){
    $("input[name=email]").attr("readonly", false); 
    $("#edit-check").show();
    $("#submit_button_email").prop('disabled',false);
    $("#edit-email").hide();
  })

//   function changeIcon(x) {
      
//     // $("input[name=phone]").attr("readonly", false); 
    
//     // $("#submit_button").prop('disabled',false);
//     // $("#edit-phone").hide();
//     // x.toggleClass("fa-fa-check-circle");
//     x.removeClass("fa fa-pencil-square-o");
//     x.toggleClass("fa fa-check-circle");

//   }

//   changeIcon = function (elm) {
//     // Now the object is $(elm)
//     elm.removeClass("fa fa-pencil-square-o");
//     elm.toggleClass("fa fa-check-circle");
// };

  $("body").on("click","#submit_button_email",function(){
      var old_email=$("#old_email").val();
      var new_email=$("input[name=email]").val();
      if(old_email!=new_email){
         $("#submit_button_email").html(`<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
          RESEND_EMAIL_TO_CLIENT.__submit_new_otp(new_email);
      }
  });


  ///

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
  
  
      $("body").on('click', '#submit_button_otp_email', function() {
  
        setTimeout(() => {
            $("#opt_validation_error_email").fadeOut();
        }, 3000);

          var otp = $("#otp_input_email").val();
          $("#opt_validation_error_email").html("");
  
          if (otp.length == 0) {
              $("#opt_validation_error_email").html("Please enter OTP received.").css('display','block');;
              return false;
          }
  
          if (sha256(otp.toString()) != $("#otp_has_pass_email").val()) {
              $("#opt_validation_error_email").html("Your have entered invalid OTP.").css('display','block');;
              return false;
          }
          $("#updated_email").val($("#email").val());
          $("#final_submit_email").submit();
      });
  
  
      var RESEND_EMAIL_TO_CLIENT = {
          __submit_new_otp: function(email) {
         
              $.ajax({
                  type: "get",
                  url: $("#hidden_resent_url_email").val(),
                  data: {
                      "email": email,
                  },
                  cache: false,
                  beforeSend: function() {
                      $("#resent_api_button_email").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
                      $("#opt_resent_error_email").html("");
                  },
                  dataType: 'json',
                  success: function(response) {
                      if (parseInt(response.code) == 200) {
                        $("#validMail").html(""); 
                        $("#otp_text_email").text("OTP has been sent to "+email);
                        $('#otpModalEmail').modal({backdrop: 'static', keyboard: false}) 
                        $('#otpModalEmail').modal('show');
                        timerEmail(90);
                        $("#opt_resent_error_email").html('<div class="alert alert-success"><strong>Success!</strong> ' + response.messages + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        $("#otp_has_pass_email").val(response.hash);
                      }
                     
                      if(parseInt(response.code)==422){
                          $("#error-email").text(response.messages);
                      }

                  },
                  error: function() {
                      swal('Something went wrong Please try again');
                  },
                  complete: function() {
                      $("#resent_api_button_email").html('Resend');
                      $("#resent_api_button_email").prop('disabled',true);
                      $("#submit_button_email").prop('disabled',false);
                      $("#submit_button_email").html('Update');
                      $("#spinner").html('');
                  }
              });
  
          }
      }
  
  
    //   let timerOn = true;
  
      function timerEmail(remaining) {
        let timerOn = true;
          var m = Math.floor(remaining / 60);
          var s = remaining % 60;
  
          m = m < 10 ? '0' + m : m;
          s = s < 10 ? '0' + s : s;
          document.getElementById('timer_email').innerHTML = m + ':' + s;
          remaining -= 1;
  
          if (remaining >= 0 && timerOn) {
              setTimeout(function() {
                timerEmail(remaining);
              }, 1000);
              return;
          }
  
          if (!timerOn) {
              // Do validate stuff here
              return;
          }
          $("#timer_email").html("");
          $("#otp_has_pass_email").val("");
          $("#resent_api_button_email").prop('disabled',false);
          $("#submit_button_email").prop("disabled",true);
      }
  
     
      /***
       * @desc resend email functionality
       */
      $("body").on('click', '#resent_api_button_email', function() {
        var new_email=$("input[name=email]").val();
         
          RESEND_EMAIL_TO_CLIENT.__submit_new_otp(new_email);
      });




      $('body').on("click",'#closeModelEmail',function(event){
         $("input[name=resend_status]").val("0");
         $('#otpModalEmail').modal('hide');
         $("#submit_button_email").prop("disabled",false);
         $("#validMail").html(""); 
         location.reload();
       });

   
       /**
        * VERIFY Email address 
        */
       $("body").on('click','#verify-user-email',function(){
           
        swal({
            title: localMsg.BeSure,
            text: "Do you really want to varify email address ?",
            icon:"warning",
            buttons: ["No", "Yes!"],
            showCancelButton: true,
            cancelButtonClass: 'btn-danger btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            cancelButtonText: "No",
            cancel:true,
            closeOnClickOutside: true,
            closeOnEsc: true
        }).then((isConfirm) => {
               if (isConfirm) {
                   $("#spinner").html('<i class="fa fa-spinner fa-spin" style="font-size:24px;color:green" aria-hidden="true"></i>');
                  let new_email=$("#email").val();
                  RESEND_EMAIL_TO_CLIENT.__submit_new_otp(new_email);
               }
         })
       })