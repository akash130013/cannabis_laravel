@extends('User::register.layout')
@section('header')
<header>
        
    <div class="header_inner">
            <!-- Branding -->
    <a href="{{route('user.home')}}" class="branding"><img src="{{asset('asset-user/images/logo.svg')}}" alt=""></a>
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

         <!--Onboarding flow--->
         <div class="form-container">
                <div class="formBgWrapper">
                    <div class="custom_container flex-row align-items-center">
                        <div class="frm-lt-sd">
                            <div class="lft-msg">
                                <div class="lft-ms-ico">
                                    <img src="{{asset('asset-user-web/images/cannabis_leaf.svg')}}" alt="Cannabis Logo">
                                </div>
                                <h2>Welcome Back. Here’s a quick update for you</h2>
                                <ul class="pointer">
                                    <li>
                                        Everyday new stores to explore
                                    </li>
                                    <li>
                                        Spreading happiness around
                                    </li>
                                    <li>
                                        New Products to help in revealing to yourself
                                    </li>
                                    <li>
                                        Customized deals to give you extra wings always
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                     
                            <div class="frm-rt-sd">
                                <form action="{{ route('users.login.submit') }}" id="smoke_validation_form" method="POST" autocomplete="off">
                                    @csrf
                                    <input type="hidden" name="country_code">

                                <div class="ins-frm-lt-sd">
                                    <span class="hd">Welcome</span>
                                    <span class="shd">Please fill the details  and login to your account</span>
                                    @if (Session::has('message'))
                                    <div class="alert alert-danger remove-alert" role="alert">
                                        {{Session::get('message')}}
                                        {{-- {{ __('A fresh verification link has been.') }} --}}
                                    </div>
                                @endif 
                                    <div class="frm-sec-ins">
                                        <div class="flex-row">
                                            <div class="flex-col-sm-12">

                                                <div class="form-field-group">
                                                    <div class="text-field-wrapper {{ $errors->has('email') ? ' error-message' : '' }}">
                                                      <input type="tel" name="email" id="phone" value="{{ old('contact_number') }}" placeholder="Mobile number" class="padding-left" autofocus autocomplete="off" >
                                                       
                                                    </div> 
                                                       <span></span>
                                                       
                                                        <span id="valid-msg" class="hide"></span>
                                                        <span id="error-msg" class="hide error-message"></span>

                                                     @if ($errors->has('email'))
                                                         <span class="error">{{ $errors->first('email') }}</span>
                                                     @endif
                                                 
                                                </div>

                                            </div>
                                        </div>
                                    <div class="flex-row">
                                        <div class="flex-col-sm-12">
                                             <div class="form-field-group">
                                                 <div class="text-field-wrapper {{ $errors->has('password') ? ' error-message' : '' }}">
                                                    
                                                    <input id="password" type="password" readonly onfocus="this.removeAttribute('readonly');" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" autocomplete="false">
                                                    <span id="show_eye" class="detect-icon" onclick="showPassword()" style="display:none"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                                    <span id="hide_eye" class="detect-icon" onclick="showPassword()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>

                                                </div>
                                                <span id="pass"></span>
                                                    @if ($errors->has('password'))
                                                    <span class="error">{{ $errors->first('password') }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            </div>
                                        </div>
                                        <div class="flex-row">
                                            <div class="flex-col-sm-12 mt-50 mobile-space">
                                            <button type="submit" class="custom-btn green-fill getstarted btn-effect" id="spinner">{{ __('Login') }}</button>
                                               <a class="ch-shd back line_effect"  href="{{ route('users.password.request') }}">Forgot password?</a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                    
                    </div>
                </div>
            </div>
         <!--Onboarding flow close--->

         @section('pagescript')
         {{-- <script src="{{asset('asset-user/js/smoke/js/smoke.js')}}"></script> --}}
         <link rel="stylesheet" href="{{asset('asset-store/js/intl-tel-input-master/build/css/intlTelInput.css')}}">
         <script src="{{asset('asset-store/js/intl-tel-input-master/build/js/intlTelInput.min.js')}}"></script>
         <script src="{{asset('asset-store/js/intl-tel-input-master/build/js/utils.js')}}"></script>
         <script src="{{asset('asset-user/js/mobile.validation.intelinput.js')}}"></script>

         <script src="{{asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
         <script>
            $("#smoke_validation_form").validate({
            errorClass:'error',
            errorElement:'span',
			rules: {
				password: {
                    required : true,
                    maxlength : 50,
                    minlength : 3
                },
				email: {
					required: true,
                    maxlength : 150
                }
            },
            highlight: function (element) {
                  $(element).parent('div').parent("div").addClass('error-message');
            },
             unhighlight: function (element) {
                 $(element).parent().parent().removeClass('error-message');

             },
             errorPlacement: function (error, element) {
                if (element.attr("name") == "password") {
                           error.insertAfter("#pass");
                 }else{
                     error.appendTo($(element).parents('.text-field-wrapper')).next();
                 }
            },
            messages: {
                
                  email: {
                      required: "Please enter valid mobile number",
                  },
                  password:{
                      required: "Password field is required",
                      maxlength: "Please enter less than 50 characters",
                  }
              },
            submitHandler: function (form) {

            if (iti.isValidNumber()) {
                $("input[name='country_code']").val(iti.s.dialCode);
                $("#spinner").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
                form.submit();
            }
    }
		});

function showPassword() {
  var x = document.getElementById("password");
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
setTimeout(function(){
    removeAlertDiv()
}, 5000)
function removeAlertDiv()
{
    $('.remove-alert').remove();
}
         </script>
    @endsection

    <!--footer-->
@endsection