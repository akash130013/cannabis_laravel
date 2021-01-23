@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')

     
         <!--header close-->
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

                
                  <div class="flex-row mob-row-reverse">
                     <div class="flex-col-sm-8">
                           <div class="flex-row">
                              <div class="flex-col-sm-5">
                                 <label class="form_label">Name</label>
                              </div>
                              <div class="flex-col-sm-5">
                                 <span class="show_label">{{Auth::guard('users')->user()->name}}</span>
                              </div>
                          </div>
                           <div class="flex-row m-t-30">
                                 <div class="flex-col-sm-5">
                                    <label class="form_label">Email</label>
                                 </div>
                              
                                 <div class="flex-col-sm-5">
                                    @if(isset(Auth::guard('users')->user()->email_verified_at))
                                         <span class="show_label attach_file wrd-brk verified"><a href="javascript:void(0)" style="cursor:default">{{Auth::guard('users')->user()->email}}</a></span>
                                    @elseif(isset(Auth::guard('users')->user()->email) && !empty(Auth::guard('users')->user()->email))  
                                       <span class="show_label attach_file wrd-brk not-verified"><a href="javascript:void(0)" id="verify-user-email">{{Auth::guard('users')->user()->email}}</a>
                                       <span id="spinner"></span>
                                    @else
                                         <span class="show_label">N/A</span>
                                    @endif
                                 </div>
                              </div>
                        
                           <div class="flex-row m-t-30">
                              <div class="flex-col-sm-5">
                                 <label class="form_label">Age Proof</label>
                              </div>
                           
                              <div class="flex-col-sm-5">
                                 <span class="show_label attach_file"><a class="txt_attach" href="{{$ageProof->file_url ?? 'N/A'}}" target="blank">{{$ageProof->file_name ?? 'N/A'}}</a></span>
                              </div>
                           

                           </div>
                           <div class="flex-row m-t-30">
                              <div class="flex-col-sm-5">
                                 <label class="form_label">Medical Proof</label>
                              </div>

                              @if($medicalProof)
                              <div class="flex-col-sm-5">
                                 <span class="show_label attach_file"><a href="{{$medicalProof->file_url ?? 'N/A'}}" class="txt_attach" target="blank">{{$medicalProof->file_name ?? 'N/A'}}</a></span></span>
                              </div>
                              @else
                                 <div class="flex-col-sm-5">
                                    <span class="show_label">No Medical Proof Uploaded</span></span>
                                 </div>
                              @endif

                           </div>
                           <div class="flex-row m-t-30">
                              <div class="flex-col-sm-5">
                                 <label class="form_label">Contact Number</label>
                              </div>
                              
                              <div class="flex-col-sm-5">
                                 <span class="show_label attach_file verified"><a href="javascript:void(0)" style="cursor:default">{{Auth::guard('users')->user()->country_code}}  -  {{Auth::guard('users')->user()->phone_number}}</a></span>
                              </div>
                           </div>
                           <div class="flex-row m-t-30">
                              <div class="flex-col-sm-5">
                                 <label class="form_label">Date Of birth</label>
                              </div>
                              <div class="flex-col-sm-5">
                                 <span class="show_label">{{\App\Helpers\CommonHelper::dateformat(Auth::guard('users')->user()->dob)}} </span>
                              </div>
                           </div>
                           <div class="flex-row m-t-30">
                              <div class="flex-col-sm-5">
                                 <a href="{{route('user.edit.account.information')}}" class="custom-btn green-fill getstarted btn-effect btn-sm">Edit Profile</a>
                              </div>
                           </div>
                     </div>
                     <div class="flex-col-sm-4"> 
                        <figure class="profile-pic">
                          
                           @if(!empty(Auth::guard('users')->user()->profile_pic))
                           <img src="{{Auth::guard('users')->user()->profile_pic}}" alt="user-profile-image" />
                              @else
                            <img src="{{asset('asset-user-web/images/profile.png')}}" alt="user-profile-image" />
                          @endif
                        </figure>
                       
                     </div>
                  </div>

               </div>
               <!--Setting Detail Col Close--> 
            </div>
         </div>
      </section>
      <input type="hidden" name="search_type" value="1">
   <input type="hidden" id="email" name="email" value="{{Auth::guard('users')->user()->email}}">
   <input type="hidden" id="hidden_resent_url_email" value="{{route('user.email.verify')}}">
   <input type="hidden" name="otphashEmail" id="otp_has_pass_email" value="">
      {{-- Cropper modal --}}
      <div class="modal fade cropperModalBox" id="cropper_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">
                        <img src="{{asset('asset-admin/images/close.svg')}}">
                     </button>
                     <h4 class="modal-title">Crop Image</h4>
                  </div>
                  <div class="modal-body clearfix">
                     <div class="col-md-12">
                        <div class="img-container">
                           <img id="image-to-crop" src=" " alt="Picture">
                        </div>
                     </div>
                     
                  </div>
                  <div class="modal-footer">
                     <div class="form_field_wrapper text-center">
                        <button class="btn success hvr-ripple-out" data-dismiss="modal">Cancel</button>
                        <button class="btn success hvr-ripple-out" id="crop_it">Crop</button>
                     </div>
                     
                  </div>
               </div>
            </div>
         </div>



       <!--otp model email !-->
       <div class="modal fade" id="otpModalEmail" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close modal-close" onclick="location.reload()"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
                  <h4 class="modal-title">Email Verification</h4>
               </div>
               <form action="{{route('user.update.email')}}" id="final_submit_email" method="post">
                     @csrf
               <input type="hidden" name="email" id="updated_email" value="{{Auth::guard('users')->user()->email}}">
               <input type="hidden" name="verify" value="1">
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
                          
                           <button type="button" class="disable_input ch-shd back line_effect" disabled="disabled" id="resent_api_button_email" href="javascript:void(0);" data-verify="1">Resend?</button>
                        </div>
                     </div>
                  </div>
               </div>

               </form>

            </div>
         </div>
      </div>
<!--otp model email end !-->

@endsection
@section('pagescript')
      <script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>

      <script src="{{asset('asset-user/js/profile.setting.js')}}"></script>
@endsection
      