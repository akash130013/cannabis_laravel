@extends('User::register.layout')
 <!--App Wrapper-->
         @section('header')
         <header>
            <div class="header_inner">
               <!-- Branding -->
               <a href="#" class="branding"><img src="{{asset('asset-user-web/images/logo.svg')}}" alt="Kingdom"></a>
               <!-- Branding End -->
               <!-- Right Container -->
               <div class="header-right-container">
                    <a href="{{route('users.login')}}" class="log-sign-btn fill">Login</a>
                    <a href="{{route('user.register')}}" class="log-sign-btn line">Sign Up</a>
                </div>
               <!-- Right Container End -->
            </div>
         </header>
         @endsection
@section('content')
   
        <!-- Form Container -->
        <div class="form-container">
            <div class="formBgWrapper">
                <div class="custom_container flex-row align-items-center">
                    <div class="frm-lt-sd">
                        <div class="lft-msg">
                            <div class="lft-ms-ico">
                                <img src="{{asset('asset-user/images/cannabis_leaf.svg')}}" alt="Cannabis Logo">
                            </div>
                            <h2 class="no_brdr">Let’s quickly enter your mobile number and update your new password
                            </h2>
                        </div>
                    </div>

                    
                            <form action="{{ route('users.password.otp') }}" method="get"  role="form" id="otpForm">

                    <div class="frm-rt-sd">
                        <div class="ins-frm-lt-sd">
                            <span class="hd">Forgot Password</span>

                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                            <span class="shd">Enter your Mobile Number and we will send you a OTP to reset your password</span>
                            <div class="frm-sec-ins">
                               
                                <div class="flex-row">
                                        <div class="flex-col-sm-12">
                                             <div class="form-field-group">
                                                    <div class="text-field-wrapper">
                                                         <input type="tel" maxlength="16" id="phone" onkeypress="return isNumber(event)" name="phone" class="{{ $errors->has('phone') ? ' is-invalid' : '' }} pl-90 padding-left" placeholder="Enter Mobile Number" value="{{old('full_phone')}}">       
                                                    </div>
                                                    <span id="valid-msg" class="hide"></span>
                                                    <span id="error-msg" class="hide error-message"></span>
                                                    
                                                    @if(Session::has('errors'))
                                                    
                                                    <span class="error fadeout-error">{{ Session::get('errors')->first('phone') }}</span>
                                                    
                                                        @endif
                                                    
                                                   @if (Session::has('error'))
                                                    
                                                     <span class="error fadeout-error">
                                                    
                                                        {{Session::get('error')['message'] }}
                                                    
                                                        </span>

                                                    @endif
                                            
                                             </div>
                                        </div>
                                </div>

                                 <input type="hidden" name="phone_code">
                                <div class="row">
                                    <div class="col-sm-12 mt-50 mobile-space">
                                        <button class="custom-btn green-fill getstarted btn-effect" id="spinner">Send</button>
                                        <a class="ch-shd back line_effect" href="{{route('users.login')}}">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- Form Container End -->

@endsection
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{asset('asset-store/js/addmethod.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset-store/js/intl-tel-input-master/build/css/intlTelInput.css')}}">
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/intlTelInput.min.js')}}"></script>
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/utils.js')}}"></script>
<script>
var input = document.querySelector("#phone"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

    // here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["Please enter valid mobile number", "Invalid country code", "Mobile number length is too short", "Mobile number length is too long", "Please enter valid mobile number"];

    // initialise plugin
    var iti = window.intlTelInput(input, {
        hiddenInput: "full_phone",
        onlyCountries : ["us"],
        preferredCountries : ["us"],
        allowDropdown : false,
        utilsScript: "{{asset('asset-store/js/intl-tel-input-master/src/js/utils.js')}}"
    });

    var reset = function() {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };

    // on blur: validate
    input.addEventListener('blur', function() {
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




    $("#otpForm").validate({
            errorClass:'error',
            errorElement:'span',
            ignore:[],
			rules: {
                phone:{
                    required:true,
                },
            },
            highlight: function (element) {
                  $(element).parent('div').parent("div").addClass('error-message');
            },
             unhighlight: function (element) {
                 $(element).parent().parent().removeClass('error-message');

             },
             errorPlacement: function (error, element) {
                   error.appendTo($(element).parents('.text-field-wrapper')).next();
            },
			messages: {
                phone:{
                    required:"Please enter valid mobile number",
                }
			
			},
            submitHandler: function(form) {
                if (iti.isValidNumber()) {
                 $("input[name='phone_code']").val(iti.s.dialCode);
                 $("#spinner").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
                form.submit();
          }
     }
		});


</script>
@endsection