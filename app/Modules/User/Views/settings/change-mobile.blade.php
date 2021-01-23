@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')

     
        
@section('content')

@yield('nav-bar')

<section class="inner_centerpanel"> 
            <div class="custom_container">
               <div class="flex-row align-items-center">
                  <div class="flex-col-sm-6 flex-col-xs-6">
                     <h2 class="title-heading m-t-b-30">Account Overview</h2>
                  </div>
                  <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                  <img src="{{asset('asset-user-web/images/menu-line.svg')}}" class="profile-mobile-menu">
                  </div>
               </div>
               <div class="flex-row account_wrapper">
                  <!--Setting Menu Col-->
                  @yield('left-panel')
                  <!--Setting Menu Col Close-->
                  <!--Setting Detail Col-->
                  
                  <div class="account-details-col">
                  <form action="{{route('submit.update.password')}}" id="smoke_validation_form" method="post">
                     @csrf
                     <div class="flex-row m-t-30">
                     <input type="hidden" name="dialcode" id="setDialCodeId">
                    
                           <input type="hidden" name="contact_number" id="contact_number">
                         
                     <div class="flex-col-sm-6">
                            <label class="form_label">Contact Number</label>
                            <div class="form-group">
                                <div class="text-field-wrapper">
                                    <input type="tel" name="phone" id="phone" value="{{Auth::guard('users')->user()->country_code.Auth::guard('users')->user()->phone_number}}" placeholder="Contact Number" data-smk-icon="glyphicon-asterisk" required="required" class="padding-left" readonly>
                                    <span class="detect-icon" id="edit-phone"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                                    
                                 </div>
                                <span id="valid-msg" class="hide error"></span>
                                 <span id="error-msg" class="show error"></span>
                                 <span id="otp_status"></span>

                                @if(Session::has('errors'))
                                 <span class="error fadeout-error">{{Session::get('errors')->first('phone')}}</span>
                                @endif

                            </div>
                        </div>


                     </div>

                     <div class="flex-row">
                        <div class="flex-col-sm-6">
                           <button  type="submit" class="custom-btn green-fill getstarted btn-effect btn-sm" id="submit_button" disabled>Update</button>
                           <span id="spinner"></span>
                        </div>
                     </div>
                     </form>


                     <div class="flex-row m-t-30">
    
                         <div class="flex-col-sm-6">
                            <label class="form_label">Email</label>
                            <div class="form-group">
                                <div class="text-field-wrapper">
                                    <input type="email" name="email"  value="@if(!empty(Auth::guard('users')->user()->email)) {{Auth::guard('users')->user()->email ?? ''}} @endif"  placeholder="Email (abc@xyz.com)" data-smk-type="email" readonly id="email">
                                    <span class="detect-icon" id="edit-email">
                                       <i  class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                       {{-- <i onclick="changeIcon(this)" class="fa fa-pencil-square-o" aria-hidden="true"></i> --}}

                                    </span>
                                   <span id="error-email" class="error"></span>
                              </div>

                                @if(Session::has('errors'))
                                    <span class="error fadeout-error">{{Session::get('errors')->first('email')}}</span>
                                @endif

                            </div>

                        </div>
                           </div>
                             <div class="flex-row">
                                 <div class="flex-col-sm-6">
                                    <button  type="submit" class="custom-btn green-fill getstarted btn-effect btn-sm" id="submit_button_email" disabled>Update</button>
                                   
                                 </div>
                              </div>
                         </div>
                      <!--for email !-->
                         <input type="hidden" id="old_email" value="{{Auth::guard('users')->user()->email}}">
                         <input type="hidden" id="hidden_resent_url_email" value="{{route('user.email.otp')}}">
                         <input type="hidden" name="otphashEmail" id="otp_has_pass_email" value="">
                         <input type="hidden" name="resend_status_email" value="0">
                     <!--end !-->

                     <!--for mobile !-->
                  <input type="hidden" id="hidden_resent_url" value="{{route('user.send.otp')}}">
                  <input type="hidden" name="otphash" id="otp_has_pass" value="">
                  <input type="hidden" name="resend_status" value="1">
                  <input type="hidden" name="old_phone" value="{{Auth::guard('users')->user()->country_code.Auth::guard('users')->user()->phone_number}}">
                      <!--end !-->


                  <!--Setting Detail Col Close-->
               </div>
            </div>
         </section>

       <!--otp model email !-->
         <div class="modal fade" id="otpModalEmail" role="dialog">
               <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close modal-close" id="closeModel"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
                        <h4 class="modal-title">Email Verification</h4>
                     </div>
                     <form action="{{route('user.update.email')}}" id="final_submit_email" method="post">
                           @csrf
                           <input type="hidden" name="email" id="updated_email" value="">
                     <div class="modal-body">
                        <div class="modal-padding">
                           <p class="commn_para" id="otp_text_email"></p>
                           <div class="form-field-group m-t-b-30">
                              <div class="text-field-wrapper">    
                                 <input type="text"  placeholder="Enter OTP" id="otp_input_email" class="disable-autocomplete" name="otp" maxlength="4" onkeypress="return isNumber(event)">
                                 <span class="timer" id="timer_email"></span>
                                 <span class="error alreadyTaken" id="opt_validation_error_email"></span>
                                                  <span class="success" style="color:green;" id="opt_resent_error_email"></span>
                                                    @if(!empty(Request::get('message')))  
                  
                                                      <div class="alert alert-success">
                                                              <strong>Success!</strong> {{Request::get('message')}}
                                                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                      </div> 
                                                         
                                                    @endif    
                              </div>
                           </div>
                           <div class="flex-row">
                              <div class="flex-col-sm-12 mt-50 mobile-space">
                                 <button class="custom-btn green-fill getstarted btn-effect" id="submit_button_otp_email">Submit</button>
                                
                                 <button type="button" class="disable_input ch-shd back line_effect" disabled="disabled" id="resent_api_button_email" href="javascript:void(0);">Resend?</button>
                              </div>
                           </div>
                        </div>
                     </div>

                     </form>

                  </div>
               </div>
            </div>
<!--otp model email end !-->

 <!--otp model phone !-->
         <div class="modal fade" id="otpModal" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <form action="{{route('submit.update.password')}}" id="final_submit_otp" method="post">
               @csrf
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close modal-close" id="closeModel"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
                  <h4 class="modal-title">Phone Number Verification</h4>
               </div>
               <div class="modal-body">
                  <div class="modal-padding">
                     <p class="commn_para" id="mobile-text"></p>
                     <div class="form-field-group m-t-b-30">
                        <div class="text-field-wrapper">    
                           <input type="text"  placeholder="Enter OTP" id="otp_input" class="disable-autocomplete" name="otp" maxlength="6" onkeypress="return isNumber(event)">
                           <span class="timer" id="timer"></span>
                           <span class="error alreadyTaken" id="opt_validation_error"></span>
                                            <span class="success" style="color:green;" id="opt_resent_error"></span>
            
                        </div>
                        <p>
   
                        @if(!empty(Request::get('message')))  
            
                        <div class="alert alert-success">
                              <strong>Success!</strong> {{Request::get('message')}}
                             
                        </div> 
               
                        @endif    
                    </p>
                     </div>
                     <div class="flex-row">
                        <div class="flex-col-sm-12 mt-50 mobile-space">
                           <button type="submit" class="custom-btn green-fill getstarted btn-effect" id="submit_button_otp">Submit</button>
                          
                           <button type="button" class="disable_input ch-shd back line_effect" disabled="disabled" id="resent_api_button" data-resend = "" href="javascript:void(0);" data-phone_code="">Resend?</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <input type="hidden" name="contact_number" id="contact_number_final_submit_id">
            <input type="hidden" name="otphash" id="otp_has_pass_hidden_id" value="">
            <input type="hidden" name="phone" id="phone_number_hidden" value="">
            <input type="hidden" name="dialcode" id="dialcode_id_mobile_pop_up" value="">
            
                  
            </form>
         </div>
      </div>
 <!--otp model phone end !-->



<input type="hidden" name="search_type" value="1">
@endsection
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset-store/js/intl-tel-input-master/build/css/intlTelInput.css')}}">
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/intlTelInput.min.js')}}"></script>
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/utils.js')}}"></script>
<script src="{{asset('asset-user/js/mobile.validation.intelinput.js')}}"></script>
<script src="{{asset('asset-user/js/change-mobile.js')}}"></script>
<script src="{{ asset('asset-user/js/profile.setting.js')}}"></script>
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

@endsection


