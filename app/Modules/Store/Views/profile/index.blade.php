@extends('Store::layouts.master')
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
   top: 10px;
   right: 10px;
   background: #ff8338;
   border-radius: 50%;
   padding: 3px 4px;
   opacity: 1;
   cursor: pointer;
   outline: none;
   border: 2px solid #fff;
   }
   .m-b-15{
   margin-bottom: 15px;
   }
   .pac-container {
   z-index: 10000 !important;
   }
   /* .cropper-view-box,
   .cropper-face {
   border-radius: 50%;
   } */

   @media (max-width: 640px){
      .close{
         right: 0;
      }
   }
</style>
<!-- Header End -->
<!-- Internal Container -->
<span class="profile-menu">
   <img src="{{asset('asset-store/images/menu-line.svg')}}" alt="profile menu">
</span>
<div class="full_custom_container profile-view">
   @include('Store::layouts.pending-alert')
   <div class="wrap-row-full">
      @include('Store::profile.profile-sidebar')
      {{-- {{dump($storeDetails)}} --}}
      <!--Profile Detail Col-->
      <div class="profile-detail-col">
         <div class="white_wrapper">
            <div class="col-space">
               <div class="flex-row mob-row-reverse">
                  <div class="flex-col-sm-8">
                     <div class="flex-row m-b-50">
                         <div class="flex-col-sm-12">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <label class="form_label">Store Owner Name</label>
                                 <span class="show_label">{{ Auth::guard('store')->user()->last_name != null ?
                                 Auth::guard('store')->user()->name. ' '. Auth::guard('store')->user()->last_name : Auth::guard('store')->user()->last_name}}</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="flex-row m-b-50">
                        <div class="flex-col-sm-12">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <label class="form_label">Store Name</label>
                                 <a href="javascript:void(0);" class="action_edit_btn"
                                    id="business-modal-popup">
                                 <img src="{{asset('asset-store/profile/images/pencil-line.svg')}}"
                                    alt="edit" data-toggle="modal"
                                    data-target="#business-modal"/>
                                 </a>
                                 <span class="show_label">{{ $storeDetails->store_name ?? ""}}</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="flex-row m-b-50">
                        <div class="flex-col-sm-12">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <label class="form_label">About Store</label>
                                 <a href="javascript:void(0);" class="action_edit_btn"
                                    id="about-modal-popup">
                                 <img src="{{asset('asset-store/profile/images/pencil-line.svg')}}"
                                    data-toggle="modal"
                                    data-target="#about-modal"/>
                                 </a>
                                 <p class="txt-about">
                                    {{$storeDetails->about_store ?? ""}}
                                 </p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Opening Hours -->
                     <div class="flex-row m-b-50 opening-hrs">
                        <div class="flex-col-sm-4">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <label class="form_label">Opening Hours</label>
                                 <a href="javascript:void(0);" class="action_edit_btn">
                                 <img src="{{asset('asset-store/profile/images/pencil-line.svg')}}"
                                    id="edit_operating_hours"
                                    data-url-delivery-address="{{route('store.get.delivery.address.html')}}"/>
                                 </a>
                                 <ul>
                                    @if($storeTimings)
                                    @foreach($storeTimings as $val)
                                    <li>
                                       <span>{{jddayofweek($val->day -1 , 2)}}</span>
                                       @if($val->working_status == "open")
                                       <span>{{date('h:i A', strtotime($val->start_time))}} - {{date('h:i A', strtotime($val->end_time))}}</span>
                                       @else
                                       <span class="txt-closed">CLOSED</span>
                                       @endif
                                    </li>
                                    @endforeach
                                    @endif
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- Opening Hours -->
                  </div>
                  <div class="flex-col-sm-4 location-detail">
                     <form action="{{route('store.upload.profile.pic')}}" method="POST">
                        @csrf
                        <div class="upload-img">
                           <input type="hidden" name="blobImg" id="cropped_image_preview" value="2">
                           <figure>
                              <img src="{{$profile}}" id="imageFile" alt="profile image"/>
                           </figure>
                           <input type="file" style="display:none" id="image-selector" name="fileUpload"
                              accept="image/*">
                           <label for="image-selector" class="camera">
                           <img src="{{asset('asset-store/images/camera-line.png')}}"
                              alt="upload image">
                           </label>
                        </div>
                        <input type="hidden" name="profilePic" value="" id="profilePic">
                        <button type="submit" hidden id="submitButton"></button>
                     </form>
                     <div class="store-location-detail">
                        <div id="map">
                        </div>
                        <div class="pd-20">
                           <ul>
                              <li class="address">
                                 <p>{{ $storeDetails->formatted_address ?? ""}}</p>
                                 <a href="javascript:void(0);" class="location-edit">
                                 <img src="{{asset('asset-store/profile/images/pencil-line.svg')}}"
                                    alt="edit" id="edit_address_store_update"/>
                                 </a>
                              </li>
                              <li class="call">
                                 <p>{{$storeDetails->contact_number ?? ""}}</p>
                              </li>
                              <li class="email">
                                 <p>{{Auth::guard('store')->user()->email}}</p>
                                 <a href="javascript:void(0);" class="location-edit">
                                 <img id="show-email-modal" src="{{asset('asset-store/profile/images/pencil-line.svg')}}"
                                    alt="edit" 
                                    data-email={{Auth::guard('store')->user()->email}}
                                    id="#email-modal"/>
                                 </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--Profile Detail Col-->
   </div>
</div>
<input type="hidden" name="lat" id="default_lat" value="{{$storeDetails->lat ?? ''}}">
<input type="hidden" name="lat" id="default_lng" value="{{$storeDetails->lng ?? ''}}">
<!---Business Modal Start-->
<div id="business-modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <form action="{{route('store.update.name',encrypt(Auth::guard('store')->user()->id))}}" method="POST">
         @csrf
         @method("PUT")
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close modal-close" data-dismiss="modal">
               <img src="{{asset('asset-store/images/close-card.svg')}}"></button>
               <h4 class="modal-title">Store Name</h4>
            </div>
            <div class="modal-body">
               <div class="modal-padding">
                  <div class="formfilled-wrapper">
                     <p class="commn_para">Enter your business title as it appears to customers
                        in the real world.
                     </p>
                     <div class="text-field-wrapper m-t-15">
                        <input type="text" value="" maxlength="50" id="store_name" name="store_name" minlength="5"
                           placeholder="Store name" class="modal-input" required="required"/>
                     </div>
                     <div class="flex-row m-t-30">
                        <div class="flex-col-sm-12 mt-50 mobile-space">
                           <button class="primary_btn custom-btn green-fill getstarted btn-effect">Save
                           </button>
                           </a>
                           <a class="ch-shd back line_effect" href="javascript:void(0)"  data-dismiss="modal">No, Cancel</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<!---Business Modal End-->
<!---About Store Modal Start-->
<div id="about-modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <form action="{{route('store.update.desc',encrypt(Auth::guard('store')->user()->id))}}" method="POST">
         @csrf
         @method("PUT")
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close modal-close" data-dismiss="modal">
               <img src="{{asset('asset-store/images/close-card.svg')}}"></button>
               <h4 class="modal-title">About The Business</h4>
            </div>
            <div class="modal-body">
               <div class="modal-padding">
                  <div class="formfilled-wrapper">
                     <p class="commn_para">Write a brief description of your business.
                     <p class="txt-count">(750 Words)</p>
                     <div class="text-field-wrapper m-t-15">
                        <!-- <input type="text" placeholder="Urban Leaf Dispensary" class="modal-input" /> -->
                        <textarea id="store_desc_id" name="store_desc" maxlength="750" required="required"></textarea>
                     </div>
                  </div>
                  <div class="flex-row m-t-30">
                     <div class="flex-col-sm-12 mt-50 mobile-space">
                        <button class="primary_btn custom-btn green-fill btn-effect">Save
                        </button>
                        <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal">No, Cancel</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<!---About Store Modal End-->
<!---Location Modal Start-->
<div id="location_modal_store" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close modal-close" onclick="location.reload()">
            <img src="{{asset('asset-store/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Business Location</h4>
         </div>
         <div class="modal-body">
            <div class="modal-padding">
               <div class="formfilled-wrapper">
                  <p class="commn_para m-t-15">Let customers see your business location on Google by adding a
                     street address.
                  </p>
               </div>
               <form action="{{route('store.update.address')}}" method="POST" id="update_store_address">
                  @csrf
                  <div class="flex-row m-t-30">
                     <div class="flex-col-sm-12">
                        <div class="formfilled-wrapper">
                           <div class="textfilled-wrapper">
                              <input type="text" name="formatted_address" id="address" value=""
                                 placeholder="Address (Street, Area)*" class="modal-input"/>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="flex-row">
                     <div class="flex-col-sm-12" id="map_element">
                     </div>
                  </div>
                  <div class="flex-row m-t-30">
                     <div class="flex-col-sm-12 mt-50 mobile-space">
                        <button class="primary_btn custom-btn green-fill getstarted btn-effect">Save
                        </button>
                        <a class="ch-shd back line_effect" href="javascript:void(0)" onclick="location.reload()">No, Cancel</a>
                     </div>
                  </div>
                  <input type="hidden" name="lat" id="lat" value="{{$storeDetails->lat}}">
                  <input type="hidden" name="lng" id="lng" value="{{$storeDetails->lng}}">
                  <input type="hidden" name="postal_code" id="postal_code" value="">
                  <input type="hidden" name="street_number" id="street_number-edit">
                  <input type="hidden" name="ip" id="ip">
                  <input type="hidden" name="route" id="route">
                  <input type="hidden" name="time_zone" id="time_zone" value="{{Auth::guard('store')->user()->time_zone}}">
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!---Location Modal End-->
<!---OTP Modal Start-->
<div id="otp-modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <form action="{{route('update.store.email')}}" method="POST" id="otp_submission_fomr">
         @csrf
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close modal-close" data-dismiss="modal">
               <img src="{{asset('asset-store/images/close-card.svg')}}"></button>
               <h4 class="modal-title">OTP Verify</h4>
            </div>
            <div class="modal-body">
               <div class="modal-padding">
                  <div class="form-field-group">
                     <label id="error_message_email_success m-b-15"></label>
                     <div class="text-field-wrapper">
                        <input type="text" name="otp" id="otp_input_" placeholder="Enter OTP"
                           class="modal-input disable-autocomplete" required="required"/>
                        <span class="error" id="opt_validation_error"> </span>
                     </div>
                  </div>
                  <a href="javascript:void(0)">
                  <button class="custom-btn green-fill getstarted btn-effect" id="submit_otp">Submit</button>
                  </a>
                  <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal">No, Cancel</a>
                  <!-- <button type="button" class="primary_btn trans-fill btn_sm" id="resend_otp">Resend</button> -->
                  <input type="hidden" id="otp_hidden_hash" name="otp_hash">
                  <input type="hidden" id="otp_hidden_email" name="email">
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<!---OTP Modal End-->
<div id="modal_box_edit_delivery_address" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close modal-close" data-dismiss="modal">
            <img src="{{asset('asset-store/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Edit Opening Hours</h4>
         </div>
         <div class="modal-body">
            <div class="modal-padding" id="edit_append_operating_hours_store">
            </div>
         </div>
      </div>
      </form>
   </div>
</div>
<!-- <div id="modal_box_edit_delivery_address" class="modal fade" role="dialog">
   <div class="modal-dialog">
         <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Operating Hours</h4>
               </div>
               <div class="modal-body" id="edit_append_operating_hours">
   
               </div>
         </div>
   </div>
   </div> -->
<!---Email Modal Start-->
<div id="email-modal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <form action="{{route('store.send.otp.email')}}" id="edit_emai_address">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close modal-close" data-dismiss="modal">
               <img src="{{asset('asset-store/images/close-card.svg')}}"></button>
               <h4 class="modal-title">Email ID</h4>
            </div>
            <div class="modal-body">
               <div class="modal-padding">
                  <div class="formfilled-wrapper ">
                     <p class="commn_para">Enter your business email ID as it appears to customers
                        in the real world.
                     </p>
                     <div class="textfilled-wrapper m-t-15">
                        <input type="text" name="email" id="email-input" placeholder="xyz@gmail.com"
                           class="modal-input" required="required"/>
                     </div>
                     <span id="error_message_email"></span>
                  </div>
                  <div class="flex-row m-t-30">
                     <div class="flex-col-sm-12 mt-50 mobile-space">
                        <button type="button"
                           class="primary_btn custom-btn green-fill getstarted btn-effect"
                           id="store_send_email">Update
                        </button>
                        <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal">No, Cancel</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<!---Email Modal End-->
{{-- Cropper Modal :Start --}}
<div class="modal fade cropperModalBox" id="cropper_modal" data-backdrop="static" data-keyboard="false"
   tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close modal-close" data-dismiss="modal">
            <img src="{{asset('asset-store/images/close-card.svg')}}">
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
            <div class="text-center">
               <button class="green-fill custom-btn btn-effect m-t-15" id="crop_it">Crop</button>
               <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal">No, Cancel</a>
            </div>
         </div>
      </div>
   </div>
</div>
{{-- Cropper Image :End --}}
<input type="hidden" value="{{ $storeDetails->store_name}}" id="store-name">
<input type="hidden" value="{{ $storeDetails->about_store}}" id="about-store">
<input type="hidden" value="{{ $storeDetails->formatted_address}}" id="store-address">
<input type="hidden" value="{{Auth::guard('store')->user()->email}}" id="store-email">
@push('script')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{ asset('asset-user/js/location/jquery.geocomplete.js')}}"></script>
<script src="{{asset('asset-store/js/businessHours-master/jquery.businessHours.js')}}"></script>
<script src="{{asset('asset-store/js/character-count/jquery.charactercounter.min.js')}}"></script>
<script src="{{asset('asset-store/js/edit-profile.js')}}"></script>
<script src="{{asset('asset-admin/js/cropper.js')}}"></script>
<script src="{{asset('asset-admin/js/appinventivCropper.js')}}"></script>
<script src="{{asset('asset-store/js/profile.upload.js')}}"></script>
<script src="{{asset('asset-admin/js/circle-loader/src/jCirclize.js')}}"></script>
<script src="{{asset('asset-admin/js/s3.upload.amzon.js')}}"></script>
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{ asset('asset-store/js/s3.upload.js')}}"></script>
<script>
   $('#business-modal-popup').on('click', function () {
       var storeName = $('#store-name').val();
       $('#store_name').val(storeName);
   })
   $('#about-modal-popup').on('click', function () {
       var storeDesc = $('#about-store').val();
       $('#store_desc_id').val(storeDesc);
   
   })
   $( "#show-email-modal" ).click( function () {
      $('#email-modal').modal("show");
      $('#email-input').val($( this ).attr( 'data-email' ));
    } );
   
</script>
@endpush
@endsection