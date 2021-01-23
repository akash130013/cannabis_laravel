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
        <div class="form-container">
            <div class="formBgWrapper">
                <div class="custom_container flex-row align-items-center">
                <div class="frm-lt-sd">
                    <div class="lft-msg">
                        <div class="lft-ms-ico">
                            <img src="{{asset('asset-user/images/cannabis_leaf.svg')}}" alt="Cannabis Logo">
                        </div>
                        <h2 class="reset">Let’s quickly create your new password and never be forget again
                        </h2>
                    </div>
                </div>
                <div class="frm-rt-sd">
                    <div class="ins-frm-lt-sd">
                            <span class="hd">Reset Password</span>
                            <span class="shd">Please enter your new password and get use all our products </span>
                            @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                   
                    <form class="form-horizontal frm-sec-ins" role="form" method="POST" action="{{ route('user.reset.password') }}" id="forgetPassFormId">
                        {{ csrf_field() }}
                       
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                           
                             <div class="col-md-12">
                            <input type="hidden" name="email" value="{{$email}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            </div>
                        </div>

                        <div class="flex-row {{ $errors->has('password') ? ' has-error' : '' }}">
                            
                            <div class="flex-col-sm-12">  
                                <div class="form-field-group">
                                    <div class="text-field-wrapper">  
                                        <input type="password" name="password" minlength="6"  placeholder="New password" id="password_type">
                                          
                                        
                                        <span id="show_eye" class="detect-icon" onclick="showPassword()" style="display:none"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                        <span id="hide_eye" class="detect-icon" onclick="showPassword()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
 
                                        {{-- <span class="dropmenu info">
                                            <img src="{{asset('asset-user-web/images/info.png')}}">
                                        </span> --}}
                                  </div>
                                  <span id="pass"></span>
                                
                                {{-- <div id="password-strength-status" style="color:red;"></div>
                                
                                <div class="dropmessage">
                                    <p>1 Alphabet</p>
                                    <p>1 Special Character</p>
                                    <p>1 Upper & Lower Case</p>
                                </div> --}}

                                @if ($errors->has('password'))
                                    <span class="help-block error">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        </div>

                        <div class="flex-row {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                           <div class="flex-col-sm-12">
                              <div class="form-field-group">
                                    <div class="text-field-wrapper"> 
                                      <input id="password-confirm" type="password" placeholder="Confirm Password"  name="password_confirmation" minlength="6">
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block error" >
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                            </div>
                        </div>
                        </div>
                         
                        <div class="flex-row">
                                <div class="col-sm-12">
                                    <button class="btn custom-btn green-fill getstarted btn-effect" type="submit" id="reset_store_btn">Reset Password</button>
                                    
                                </div>
                            </div>
                    </form>
                    </div>
                </div>
            
            </div>
            </div>
        </div>

@endsection
        
@section('pagescript')

<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>

 <script>

function checkPasswordStrength() {
            
            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            var upperCase = /([A-Z])/;
            var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
            if ($('#password_type').val().length >= 6) {

                                 if ($('#password_type').val().length < 8) {
                                     $('#password-strength-status').removeClass();
                                     $('#password-strength-status').addClass('weak-password');
                                     $('#password-strength-status').addClass('error');
                                     $('#password-strength-status').html("Weak (good to have atleast 8 characters.)");
                                     // $("#reset_store_btn").prop('disabled',true);
                                     $('#password-strength-status').css('color','red');
                                 } else {
                                     if ($('#password_type').val().match(number) && $('#password_type').val().match(upperCase) && $('#password_type').val().match(alphabets) && $('#password_type').val().match(special_characters)) {
                                         $('#password-strength-status').removeClass();
                                         $('#password-strength-status').addClass('strong-password');
                                         $('#password-strength-status').html("Strong");
                                         $('#password-strength-status').css('color','green');
                                         // $("#reset_store_btn").prop('disabled',false);
                                     } else {
                                         $('#password-strength-status').removeClass();
                                         $('#password-strength-status').addClass('medium-password');
                                         $('#password-strength-status').html("Medium(Good to have at least 1 alphabet,1 number,1 special character,1 upper case and 1 lower case)");
                                         // $("#reset_store_btn").prop('disabled',true);
                                         // $('#password-strength-status').css('color','red');
                                         $('#password-strength-status').addClass('error');

                                     }
                                 }
            } else {
                $('#password-strength-status').html('');
            }
    }

          
    $("#forgetPassFormId").validate({
        errorClass: 'error',
        errorElement: 'span',
        ignore: [],
        rules: {
            password: {
                required: true,
                minlength:6,
            },
            password_confirmation: {
                required: true,
                equalTo : "#password_type"
            },
        },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "password") {
                           error.insertAfter("#pass");
                 }else{
                     error.appendTo($(element).parents('.text-field-wrapper')).next();
                 }
            },
            submitHandler: function (form) {
            $("#reset_store_btn").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
             form.submit();
        }

    });

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
        
        </script>
@endsection
