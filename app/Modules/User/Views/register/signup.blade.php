@extends('User::register.layout')
@section('header')
<header>
   <div class="header_inner">
      <!-- Branding -->
   <a href="{{route('user.home')}}" class="branding"><img src="{{asset('asset-user-web/images/logo.svg')}}" alt="Kingdom"></a>
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
         <div class="frm-rt-sd form-lt-sd">
            <div class="ins-frm-lt-sd">
               <form action="{{route('user.show.otp.verification')}}" method="GET" id="user_login" autocomplete="off">
                  <div class="frm-rt-sd">
                     <div class="ins-frm-lt-sd">
                        <span class="hd">Create Account</span>
                        <span class="shd">Enter your email and create a password.</span>
                        <div class="frm-sec-ins">
                           <div class="flex-row">
                              <div class="flex-col-sm-12">
                                 <div class="form-field-group">
                                    <div class="text-field-wrapper">
                                       <input type="text" class="{{ $errors->has('user_name') ? ' is-invalid' : '' }}"
                                          placeholder="Full Name *" name="user_name" maxlength="50"
                                          value="{{ empty($previousData['user_name']) ? old('user_name') : $previousData['user_name'] }}">
                                    </div>
                                    <span></span>
                                    @if(Session::has('errors'))
                                    <span
                                       class="error alreadyTaken">{{ Session::get('errors')->first('user_name') }}
                                       </span>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <div class="flex-row">
                              <div class="flex-col-sm-12">
                                 <div class="form-field-group">
                                    <div class="text-field-wrapper">
                                       <input type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                          placeholder="Email (Optional)" maxlength="100" name="email" multiple pattern="^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$"
                                          value="{{ empty($previousData['email']) ? old('email') : $previousData['email'] }}" data-msg="Please enter a valid email address">
                                    </div>
                                    <span></span>
                                    @if(Session::has('errors'))
                                    <span class="error fadeout-error">{{ Session::get('errors')->first('email') }}</span>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <input type="hidden" name="phone_code" id="phone_code">
                           <div class="flex-row">
                              <div class="flex-col-sm-12">
                                 <div class="form-field-group">
                                    <div class="text-field-wrapper">
                                       <input type="tel" maxlength="16" id="phone" name="phone"
                                          class="{{ $errors->has('phone') ? ' is-invalid' : '' }} pl-90 padding-left"
                                          placeholder="Mobile Number *" value="{{old('full_phone')}}">

                                    </div>
                                    <span></span>
                                    <span id="valid-msg" class="hide"></span>
                                    <span id="error-msg" class="hide error-message"></span>
                                    <span id="otp_status"></span>

                                    @if(Session::has('errors'))
                                    <span class="error fadeout-error">{{ Session::get('errors')->first('phone') }}</span>
                                    @endif
                                    @if(Session::has('error'))
                                    <span class="error">{{ Session::get('error')['messages'] }}</span>
                                    @endif
                                   
                                 </div>
                              </div>
                           </div>
                           
                           <div class="flex-row">
                              <div class="flex-col-sm-12">
                                 <div class="form-field-group">
                                    <div class="text-field-wrapper  {{ $errors->has('password') ? ' error-message' : '' }}">
                                       <input type="password" name="password" autocomplete="off" minlength="6"
                                          class="{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                          placeholder="Password *" id="password_type"
                                          value="{{ empty($previousData['password']) ? old('password') : $previousData['password'] }}"
                                          autocomplete="new-password">
                                          
                                          <span id="show_eye" class="detect-icon" onclick="showPassword()" style="display:none"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                          <span id="hide_eye" class="detect-icon" onclick="showPassword()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
   
                                          {{-- <span class="dropmenu info">
                                             <img src="{{asset('asset-user-web/images/info.png')}}">
                                          </span> --}}
                                          {{-- <span class="dropmessage">
                                                <p>1 Alphabet</p>
                                                <p>1 Special Character</p>
                                                <p>1 Upper & Lower Case</p>
                                          </span> --}}

                                    </div>
                                    
                                   <span></span>
                                  {{-- <span id="password-strength-status" style="color:red;"></span> --}}
                                    @if(Session::has('errors'))
                                    <span class="error">{{ Session::get('errors')->first('password') }}</span>
                                    @endif
                                    
                                 </div>
                                
                              </div>
                           </div>
                           
                           <div class="flex-row">
                              <div class="flex-col-sm-12">
                                 <div class="form-field-group">
                                    <div class="text-field-wrapper {{ $errors->has('referal_code') ? ' error-message' : '' }}">
                                       <input type="text" name="referal_code" placeholder="Referral Code (Optional)" maxlength="30"
                                          value="{{ empty($previousData['referal_code']) ? old('referal_code') : $previousData['referal_code'] }}">
                                         {{-- value="{{ empty(old('referal_code')) ? $previousData['referal_code'] : old('referal_code') }}"> --}}

                                          <span id="spinner" class="detect-icon"></span>
                                    </div>
                                    <span id="refer" class="error"></span>
                                    @if(Session::has('errors'))
                                        <span class="error fadeout-error">{{ Session::get('errors')->first('referal_code') }}</span>
                                    @endif
                                  
                                     
                                 </div>
                              </div>
                           </div>
                           <div class="flex-row">
                              <div class="flex-col-sm-12 mt-20 mobile-space">
                                 <button type="submit" class="custom-btn green-fill getstarted btn-effect"
                                    id="signup_button">Sign Up</button>
                               
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <input type="hidden" name="otp_has_pass" id="otp_has_pass">
               </form>

               <input type="hidden" id="hidden_OTP_url" value="{{route('users.reset.password.resend.mobile')}}">

               <div class="ins-from-terms">
                  <div class=""> 
                     <p class="note-line">
                        By signing up you agree to 420 Kingdom <a href="{{route('user.terms-condition.page')}} " target="_blank" class="link"> Terms &amp;
                           Conditions </a> and
                        <a href="{{route('user.privacy-policy.page')}}" class="link" target="_blank"> Privacy Policy </a>
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="frm-lt-sd">
            <div class="lft-msg onboard-right-content">
               <div class="lft-ms-ico">
                  <img src="{{asset('asset-user-web/images/cannabis_leaf.svg')}}" alt="Cannabis Logo">
               </div>
               <h2>Connecting the best cannabis
                  stores & products.
               </h2>
               <ul class="pointer">
                  <li>
                     Find the best storefronts
                  </li>
                  <li>
                     See who delivers to your  neighbourhood
                  </li>
                  <li>
                     Discover awesome deals
                  </li>
                  <li>
                     Enjoy peace of mind
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<input type="hidden" id="refer_url" value="{{route('user.referal.validity')}}">
<!--Onboarding flow close--->
@endsection

@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{asset('asset-store/js/addmethod.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset-store/js/intl-tel-input-master/build/css/intlTelInput.css')}}">
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/intlTelInput.min.js')}}"></script>
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/utils.js')}}"></script>
<script src="{{asset('asset-user/js/user-signup.js')}}"></script>
@endsection
<!--footer-->

