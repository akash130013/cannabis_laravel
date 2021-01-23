@extends('Store::register.layout')
@section('content')
<!-- Internal Container -->
<figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt="logo"></figure>
<div class="internal-container">
   <!-- Form Container -->
   <div class="form-container">
      <div class="frm-lt-sd">
         <div class="ins-frm-lt-sd">
            <span class="hd">OTP verify</span>
            <div class="shd sign">OTP successfully sent to <span>{{$second_step_input['email']}}</span></div>
            <form action="{{route('store.register.step-four')}}" id="step_three_verification">
               <div class="frm-sec-ins">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" maxlength="6" name="otp" id="otp_input" class="disable-autocomplete"  placeholder="Enter OTP">
                              <div><span id="timer"></span></div>
                              <span class="error" id="opt_validation_error"></span>
                              <span class="success" style="color:green;" id="opt_resent_error"></span>
                           </div>
                           @if(Session::has('errors'))
                           <span class="error fadeout-error">{{ Session::get('errors')->first('otp') }}</span>
                           @endif
                           @if(Session::has('otperror'))
                           <span class="error fadeout-error">{{ Session::get('otperror') }}</span>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <button type="button" class="green-fill btn-effect" id="submit_button_otp">Submit</button>
                        <button type="button" class="disable_input ch-shd back line_effect" disabled="disabled" id="resent_api_button" data-resent="<?php echo base64_encode((serialize($second_step_input))); ?>">
                        Resend <span id="show_tool_tip_message">?</span>
                        </button>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="trm-cond-sec">
                           By signing up you agree to Cannabis <a href="{{route('store.static.cms.page',['slug'=>'terms-conditions'])}}">Terms & Conditions</a> and 
                           <a href="{{route('store.static.cms.page',['slug'=>'privacy-policy'])}}">Privacy Policy</a>
                        </div>
                     </div>
                  </div>
               </div>
               <input type="hidden" name="email" value="{{$second_step_input['email']}}">
               <input type="hidden" name="first_name" value="{{$second_step_input['first_name']}}">
               <input type="hidden" name="second_name" value="{{$second_step_input['second_name']}}">
               <input type="hidden" name="password" value="{{$second_step_input['password']}}">
               <input type="hidden" id="otp_has_pass" name="otphash" value="{{$otp}}">
            </form>
         </div>
      </div>
      <div class="frm-rt-sd">
         <figure class="ico"><img src="{{asset('asset-store/images/user.svg')}}" alt=""></figure>
         <p class="para otp">Let’s quickly verify your account
         </p>
      </div>
   </div>
   <!-- Form Container End -->
</div>
<input type="hidden" id="hidden_resent_url" value="{{route('store.reset.password.resend')}}">
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{ asset('js/disableBackButton.js')}}"></script>
<script src="{{asset('asset-store/js/mobile.number.custom.validation.js')}}"></script>
@endsection
@endsection