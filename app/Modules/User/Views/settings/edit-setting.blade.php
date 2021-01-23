@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')

<!--header close-->
@section('content')
<style>
#cropper_modal .modal-lg {
        max-width: 500px;
    }

    .container {
        max-width: 400px;
        margin: 20px auto;
    }

    img {
        max-width: 100%;
    }

    .webcam_cropped_image_preview {
        overflow: hidden;
    }

    .cropped_image_preview {
        overflow: hidden;
    }

    .modal-backdrop {
        opacity: 0.1 !important;
    }

    .close {
        width: 32px;
        height: 32px;
        position: absolute;
        top: -10px;
        right: -10px;
        background: #ff8338;
        border-radius: 50%;
        padding: 3px 4px;
        opacity: 1;
        cursor: pointer;
        outline: none;
        border: 2px solid #fff;
    }

    .pac-container {
        z-index: 10000 !important;
    }

    /* .cropper-view-box,
            .cropper-face {
            border-radius: 50%;
            } */

</style>
        
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

            @php
            $ageProofName='';
            $medicalProofName='';
            if(isset($ageProof->file_url) && !empty($ageProof->file_url)){
            $ageProofName =(explode('/',$ageProof->file_url))[3];

            }
            if(isset($medicalProof->file_url) && !empty($medicalProof->file_url)){
            $medicalProofName =(explode('/',$medicalProof->file_url))[3];
            }
            @endphp

               <div class="account-details-col">

                <div class="flex-row">
                     <div class="flex-col-sm-12 m-b-20">
                        <form action="{{route('user.upload.profile.pic')}}" method="POST">
                            @csrf
                            <div class="profile-img">
                                <input type="hidden" name="blobImg" id="cropped_image_preview" value="2">
                                <figure>
                                 <img  src="{{Auth::guard('users')->user()->profile_pic??asset('asset-user-web/images/profile.png')}}" id="imageFile" alt="profile image" class="user-img"  />
                                </figure>
                                 <input type="file" style="display:none" id="image-selector" name="fileUpload" accept="image/*">
                                <div class="edit">
                                    <label for="image-selector" >
                                        <span  id="show-spinner"></span>
                                        <img src="{{asset('asset-store/images/camera-line.png')}}" alt="upload image">
                                    </label>
                                   
                                </div>
                            </div>
                            <input type="hidden" name="profilePic" value="" id="profilePic">
                            <button type="submit" hidden id="submitButton"></button>
                        </form>
                     </div>
                     
                  </div>

                  <form action="{{route('submit.user.account.info')}}" method="post" id="smoke_validation_form" class="disable-autcomplete">
                        @csrf
                    <div class="flex-row">
                        <div class="flex-col-sm-6">
                            <label class="form_label">Full Name</label>
                            <div class="form-group">
                                <div class="text-field-wrapper">
                                    <input type="text" name="username" value="{{Auth::guard('users')->user()->name}}" placeholder="Full Name" data-smk-icon="glyphicon-asterisk" required="required" onkeypress="return removeSpace(event,$(this).val())">
                                </div>

                                @if(Session::has('errors'))
                                <span class="error">{{Session::get('errors')->first('username')}}</span>
                                @endif

                            </div>
                        </div>
                        
                        <div class="flex-col-sm-6">
                            <label class="form_label">Contact Number</label>
                            <div class="form-group">
                                <div class="text-field-wrapper">
                                    <input type="tel" name="phone" disabled id="phone" value="{{Auth::guard('users')->user()->country_code.Auth::guard('users')->user()->phone_number}}" placeholder="Contact Number" data-smk-icon="glyphicon-asterisk" required="required" class="padding-left">
                                    <span id="valid-msg" class="hide"></span>
                                    <span id="error-msg" class="hide error"></span>
                                </div>

                                @if(Session::has('errors'))
                                <span class="error">{{Session::get('errors')->first('phone')}}</span>
                                @endif


                            </div>
                        </div>

                    </div>

                    <div class="flex-row">
                        {{-- <div class="flex-col-sm-6">
                            <label class="form_label">Email</label>
                            <div class="form-group">
                                <div class="text-field-wrapper">
                                    <input type="email" name="email"  value="@if(!empty(Auth::guard('users')->user()->email)) {{Auth::guard('users')->user()->email ?? ''}} @endif" placeholder="Email" data-smk-type="email" readonly>
                                 <span class="detect-icon" id="edit-email"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                                 <span class="detect-icon" style="display:none" id="edit-check"><i class="fa fa-envelope-o" style="color:#ff8338" aria-hidden="true"></i></span> 
                                   <span id="validMail"></span>
                            </div>

                                @if(Session::has('errors'))
                                    <span class="error">{{Session::get('errors')->first('email')}}</span>
                                @endif

                            </div>
                        </div> --}}
                        <div class="flex-col-sm-12">
                            <label class="form_label">Location</label>

                            <!-- form fields add address  -->

                            <div class="form-field-group">
                                <div class="form-group">
                                    <div class="text-field-wrapper">
                                        <input type="text" name="address" class="disable-autocomplete" placeholder="Auto Detect  or Type Location" id="location" value="{{Auth::guard('users')->user()->personal_address}}" data-smk-icon="glyphicon-asterisk" required>
                                        <span class="detect-icon"><img src="{{asset('asset-user-web/images/detect-icon.png')}}"  id="autolocation"></span>
                                    </div>

                                    @if(Session::has('errors'))
                                    <span class="error">{{Session::get('errors')->first('address')}}</span>
                                    @endif

                                </div>

                                <input type="hidden" name="lat" id="lat" value="{{Auth::guard('users')->user()->lat ?? ''}}">
                                <input type="hidden" name="lng" id="lng" value="{{Auth::guard('users')->user()->lng ?? ''}}">
                                <input type="hidden" name="locality" id="locality" >
                                <input type="hidden" name="administrative_area_level_1" id="administrative_area_level_1">
                                <input type="hidden" name="country" id="country">
                                <input type="hidden" name="postal_code" id="postal_code">
                                <input type="hidden" name="street_number" id="street_number">
                                <input type="hidden" name="ip" id="ip">
                                <input type="hidden" name="route" id="route">

                            </div>

                        </div>
                    </div>

                    <div class="flex-row">
                        <div class="flex-col-sm-12">
                            <label class="form_label">Age Proof (Mandatory)</label>

                            <div class="form-field-group">
                                <div class="text-field-wrapper">
                                    <input type="text" name="file_name_age"  readonly id="age_file_name" placeholder="Upload Age Proof" value="{{$ageProof->file_name ?? ''}}" data-smk-icon="glyphicon-asterisk" required="required">

                                    <input type="file" name="age_document_proof" value="{{$ageProof->file_name ?? ''}}" id="age_file_upload" onchange="s3_upload_directly(this.id,'hidden_age_file_input-error','hidden_age_file_input','age_file_name','','delete_display_age')" class="file_upload" placeholder="Upload Proof">
                                    <label for="age_file_upload"  class="upload">
                                        <img src="{{asset('asset-store/images/upload.svg')}}" alt="">
                                    </label>

                                    <input type="hidden" name="file_input_age" id="hidden_age_file_input" value="{{$ageProof->file_url ?? ''}}">
                                    <input type="hidden" name="hidden_age_file_name" id="hidden_age_file_name" value="{{$ageProof->file_name ?? ''}}">
                                    <span class="upload-doc" id="hidden_age_file_input-error"></span>
                                    <!-- <span id="delete_display_age" class="delete_file">
                                        @if (!empty($ageProofName))
                                        <svg id="removeImage" data-pk="{{encrypt($ageProof->id)}}" data-file-name="hidden_age_file_name" data-delete="1" data-remove-url="hidden_age_file_input" data-display="age_file_name" data-file="age_file_upload" data-remove-id="delete_display_age" data-key="{{$ageProofName}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <g>
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path fill="#ff0000" d="M4 8h16v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8zm2 2v10h12V10H6zm3 2h2v6H9v-6zm4 0h2v6h-2v-6zM7 5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v2h5v2H2V5h5zm2-1v1h6V4H9z"></path>
                                            </g>
                                        </svg>
                                        @endif
                                    </span> -->
                                </div>

                                @if(Session::has('errors'))
                                <span class="error">{{Session::get('errors')->first('file_name_age')}}</span>
                                @endif


                            </div>
                        </div>
                    </div>

                        <div class="flex-row">
                            <div class="flex-col-sm-12">
                                <label class="form_label">Medical Proof (Optional)</label>

                                <div class="form-field-group">
                                    <div class="text-field-wrapper">
                                        <input type="text" name="file_name_medical" id="medical_file_name" placeholder="Upload Medical Proof" readonly value="{{$medicalProof->file_name ?? ''}}">
                                        <input type="file" name="medical_document_proof" id="file_upload_medical" onchange="s3_upload_directly(this.id,'hidden_file_input_medical-error','hidden_file_input_medical','medical_file_name','','delete_display_medical')" class="file_upload" placeholder="Upload Proof">
                                        <label for="file_upload_medical" class="upload">
                                            <img src="{{asset('asset-store/images/upload.svg')}}" alt="" >
                                        </label>
                                        <input type="hidden" name="file_input_medical" id="hidden_file_input_medical" value="{{$medicalProof->file_url ?? ''}}">
                                        <input type="hidden" name="hidden_medical_file_name" id="hidden_medical_file_name" value="{{$medicalProof->file_name ?? ''}}">
                                        <span class="upload-doc" id="hidden_file_input_medical-error"></span>
                                        <span id="delete_display_medical" class="delete_file">
                                            @if (!empty($medicalProofName))
                                            <svg id="removeImage" data-file-name="hidden_medical_file_name" data-pk="{{encrypt($medicalProof->id)}}" data-delete="1" data-display="medical_file_name" data-remove-url="hidden_file_input_medical" data-file="file_upload_medical" data-remove-id="delete_display_medical" data-key="{{$medicalProofName}}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <g>
                                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                                    <path fill="#ff0000" d="M4 8h16v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8zm2 2v10h12V10H6zm3 2h2v6H9v-6zm4 0h2v6h-2v-6zM7 5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v2h5v2H2V5h5zm2-1v1h6V4H9z"></path>
                                                </g>
                                            </svg>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    <div class="flex-row m-t-30">
                        <div class="flex-col-sm-6">
                            <div class="btn-wrapper">
                                <ul>
                                    <li> <a href="{{route('user.show.setting.page')}}" class="outline-fill btn-sm">Cancel</a> </li>
                                    <li> <button type="submit" class="custom-btn green-fill getstarted btn-effect btn-sm" id="submit_button">Save</button> </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <input type="hidden" name="dialcode" id="setDialCodeId">
            </form>
            <!--Setting Detail Col Close-->
        <input type="hidden" id="old_email" value="{{Auth::guard('users')->user()->email}}">
        <input type="hidden" id="hidden_resent_url" value="{{route('user.email.otp')}}">
        <input type="hidden" name="otphash" id="otp_has_pass" value="">
        <input type="hidden" name="resend_status" value="0">
        <input type="hidden" id="type" value="verification_image">
        </div>
    </div>

    <div class="modal fade" id="otpModal" role="dialog">
            <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" id="closeModel"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
                     <h4 class="modal-title">Email Verification</h4>
                  </div>
                  <div class="modal-body">
                     <div class="modal-padding">
                        <p class="commn_para" id="otp_text"></p>
                        <div class="form-field-group m-t-b-30">
                           <div class="text-field-wrapper">    
                              <input type="text"  placeholder="Enter OTP" id="otp_input" class="disable-autocomplete" name="otp" maxlength="4" onkeypress="return isNumber(event)">
                              <span class="timer" id="timer"></span>
                              <span class="error alreadyTaken" id="opt_validation_error"></span>
                                               <span class="success" style="color:green;" id="opt_resent_error"></span>
               
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
                              <button class="custom-btn green-fill getstarted btn-effect" id="submit_button_otp">Submit</button>
                             
                              <button type="button" class="disable_input ch-shd back line_effect" disabled="disabled" id="resent_api_button" href="javascript:void(0);">Resend?</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
</section>
<input type="hidden" name="search_type" value="1">
{{-- cropper model --}}
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

                 <div class="btn-wrapper">
                                <ul>
                                    <li>
                                         <button class="outline-fill btn-sm" data-dismiss="modal">Cancel</button>  
                                         <!-- <a href="https://cannabisdev.appskeeper.com/user/profile" class="outline-fill btn-sm">Cancel</a> -->
                                     </li>
                                    <li>
                                    <button class="custom-btn green-fill getstarted btn-effect btn-sm" id="crop_it">Crop</button>
                                       <!-- <button type="submit" class="" id="submit_button">Save</button>  -->
                                    </li>
                                </ul>
                            </div>       

                   
                    
                 </div>
                 
              </div>
           </div>
        </div>
     </div>
@endsection
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset-store/js/intl-tel-input-master/build/css/intlTelInput.css')}}">
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/intlTelInput.min.js')}}"></script>
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/utils.js')}}"></script>
<script src="{{asset('asset-user/js/mobile.validation.intelinput.js')}}"></script>
<script src="{{ asset('asset-store/js/s3.upload.js')}}"></script>
<script src="{{ asset('asset-user/js/location/jquery.geocomplete.js')}}"></script>
<script src="{{ asset('asset-user/js/profile.location.autofill.js')}}"></script>
<script src="{{ asset('asset-user/js/profile.setting.js')}}"></script>

<script src="{{asset('asset-admin/js/cropper.js')}}"></script>
<script src="{{asset('asset-admin/js/appinventivCropper.js')}}"></script>
<script src="{{asset('asset-user/js/profile.upload.js')}}"></script>
<script src="{{asset('asset-admin/js/circle-loader/src/jCirclize.js')}}"></script>
<script src="{{asset('asset-admin/js/s3.upload.js')}}"></script>

@endsection

@push('script')
@endpush