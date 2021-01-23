@extends('User::register.layout')
@section('header')
<header>
        <div class="header_inner">
            <!-- Branding -->
        <a href="{{route('user.home')}}" class="branding"><img src="{{asset('asset-user/images/logo.svg')}}" alt=""></a>
            <!-- Branding End -->
            <!-- Right Container -->
            <div class="header-right-container">
                <a href="{{route('users.login')}}" class="log-sign-btn line">Login</a>
                <a href="{{route('user.register')}}" class="log-sign-btn fill">Sign Up</a>
            </div>
            <!-- Right Container End -->
        </div>
    </header>
@endsection
    @section('content')
        <!--Onboarding flow--->
        <div class="form-container">
        <div class="formBgWrapper formBgWrapperright">
            <div class="custom_container flex-row align-items-center">
                

            

            
                <div class="frm-rt-sd">
                        <div class="ins-frm-lt-sd">
                            <span class="hd">OTP Verify</span>
                            <div class="shd sign">OTP successfully sent to <span class="mobile-number">{{$phone}}</span></div>
                            <a class="ch-shd back line_effect" style="margin:0;" href="{{route('user.register')}}?params={{ base64_encode(serialize($first_step_input))}}">Not Right?</a>
                            <form action="{{ route('users.verify.mobile.otp')}}" method="get" id="step_three_verification">

                            <div class="frm-sec-ins">
                                <div class="row">
                                    <div class="col-sm-12">
                                            <div class="form-field-group">
                                                <div class="text-field-wrapper">
                                                <input type="text" maxlength="6" id="otp_input" name="otp" class="disable-autocomplete"  placeholder="Enter OTP">
                                                <div><span id="timer" class="timer"></span></div>
                                        </div>
                                        <span class="error alreadyTaken" id="opt_validation_error"></span>
                                        <span class="success" style="color:green;" id="opt_resent_error"></span>
        
                                            @if(!empty(Request::get('message')))  
        
                                            <div class="alert alert-success alert-dismissible fade show">
                                                    <strong>Success!</strong> {{Request::get('message')}}
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            </div> 
                                                
                                            @endif    
                                            </div>
                                    </div>
        
                                    @if(Session::has('errors'))
                                        <span class="error alreadyTaken">{{ Session::get('errors')->first('otp') }}</span>
                                    @endif
                                </div>
                                
                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="button"  class="custom-btn green-fill getstarted btn-effect" id="submit_button_otp">Submit</button>
                                        <button type="button" class="disable_input ch-shd back line_effect" disabled="disabled" id="resent_api_button" data-resend = "{{$phone}}" href="javascript:void(0);" data-phone_code={{$phone_code}}>Resend?</button>
                                     
                                    </div>
                                </div>
                                <input type="hidden" name="otphash" id="otp_has_pass" value="{{$otp}}">
                                <input type="hidden" name="phone" value="{{$first_step_input['phone']}}">
                                <input type="hidden" name="full_phone" value="{{$first_step_input['full_phone']}}">
                                <input type="hidden" name="user_name" value="{{$first_step_input['user_name'] ?? ''}}">
                                <input type="hidden" name="password" value="{{$first_step_input['password'] ?? ''}}">
                                <input type="hidden" name="email" value="{{$first_step_input['email'] ?? ''}}">
                                <input type="hidden" name="referal_code" value="{{$first_step_input['referal_code'] ?? ''}}">
                                <input type="hidden" name="country_code" value="{{$phone_code ?? ''}}">
    
                                </form>
                                <input type="hidden" id="hidden_resent_url" value="{{route('users.reset.password.resend.mobile')}}">
                            </div>
                </div>
                    </div>

                  

                <div class="frm-lt-sd">
                    <div class="lft-msg onboard-right-content">
                    <div class="lft-ms-ico">
                        <img src="{{asset('asset-user-web/images/cannabis_leaf.svg')}}" alt="Cannabis Logo">
                    </div>
                    <h2>Let’s Quickly verify the 
                        number on which you 
                        would want us to 
                        keep updated 
                    </h2>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!--Onboarding flow close--->
    @endsection
    @section('pagescript')
    <script src="{{asset('asset-admin/js/lang/en/language.js')}}"></script>
    <script src="{{asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
    <script src="{{asset('asset-user/js/user-otp.js')}}"></script>
    @endsection