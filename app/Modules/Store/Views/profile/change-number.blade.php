@extends('Store::layouts.master')
@section('content')
<span class="profile-menu">
   <img src="/asset-store/images/menu-line.svg" alt="profile menu">
</span>
<div class="full_custom_container profile-view">
   @include('Store::layouts.pending-alert')
   <div class="wrap-row-full">
      @include('Store::profile.profile-sidebar')
      <!--Profile Detail Col-->
      <div class="right-col-space change-phone-number">
         <div class="white_wrapper">
            <div class="col-space">
               <div class="flex-row">
                  <div class="flex-col-sm-4">
                     <div class="form-field-group">
                        <div class="text-field-wrapper">
                           <input type="tel" name="phone" id="phone" value="{{Auth::guard('store')->user()->phone}}" placeholder="Contact Number" data-smk-icon="glyphicon-asterisk" required="required">
                           <span class="txt-verify" id="verify_btn">Verified</span>
                        </div>
                        <span id="valid-msg" class="hide"></span>
                        <span id="error-msg" class="show"></span>
                     </div>
                     {{-- <button class="green-fill" id="submit_button_btn">Submit</button> --}}
                  </div>
               </div>
               </form>
            </div>
         </div>
      </div>
      <!--Profile Detail Col-->
   </div>
</div>
@endsection
@section('modal')
<div class="modal fade" id="otpModal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <form action="{{route('submit.update.mobile')}}" id="final_submit_otp" method="post">
         @csrf
         <input type="hidden" name="old_phone" value="{{Auth::guard('store')->user()->phone}}">
         <input type="hidden" name="dialcode" id="setDialCodeId">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" id="closeModel" class="close modal-close"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
               <h4 class="modal-title">Phone Number Verification</h4>
            </div>
            <div class="modal-body">
               <div class="modal-padding">
                  <div class="form-field-group">
                     <div class="text-field-wrapper">
                        <input type="text" maxlength="6" onkeypress="return isNumber(event)" placeholder="Enter OTP" class="disable-autocomplete" id="otp_input" name="otp">
                        <span class="timer" id="timer"></span>
                        <span class="error alreadyTaken" id="opt_validation_error"></span>
                        <span class="success" style="color:green;" id="opt_resent_error"></span>
                        @if(!empty(Request::get('message')))  
                        <div class="alert alert-success">
                           <strong>Success!</strong> {{Request::get('message')}}
                        </div>
                        <button type="button" id="closeModel" class="close modal-close">
                        <img src="/asset-user-web/images/close-card.svg">
                        </button>
                        @endif    
                     </div>
                  </div>
                  <div class="flex-row">
                     <div class="flex-col-sm-12 mt-50 mobile-space">
                        <button type="button" class="custom-btn green-fill  btn-effect" id="submit_button_otp">Submit</button>
                        {{-- <a class="ch-shd back line_effect" href="javascript:void(0)"  disabled="disabled" id="resent_api_button" data-resend = "">Resend?</a> --}}
                        <!-- <button type="button" class="disable_input green-fill outline-btn custom-btn m-l-20" disabled="disabled" id="resent_api_button" data-resend = "" href="javascript:void(0);" data-phone_code="">Resend <span id="show_tool_tip_message">?</span></button> -->
                        <button type="button" class="disable_input ch-shd back line_effect" disabled="disabled" id="resent_api_button" data-resend = "" href="javascript:void(0);" data-phone_code="">Resend?</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <input type="hidden" name="contact_number" id="contact_number_final_submit_id">
         <input type="hidden" name="otphash" id="otp_has_pass" value="">
         <input type="hidden" name="phone">
      </form>
      <input type="hidden" id="hidden_resent_url" value="{{route('store.reset.password.resend.mobile')}}">
   </div>
</div>
@endsection
@push('script')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset-store/js/intl-tel-input-master/build/css/intlTelInput.css')}}">
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/intlTelInput.min.js')}}"></script>
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/utils.js')}}"></script>
<script src="{{asset('asset-user/js/mobile.validation.intelinput.js')}}"></script>
<script src="{{asset('asset-store/js/store-change-phone.js')}}"></script>
<script>
   $(document).ready(function() {
     $(window).keydown(function(event){
       if(event.keyCode == 13) {
         event.preventDefault();
         return false;
       }
     });
   });
      
</script>
@endpush