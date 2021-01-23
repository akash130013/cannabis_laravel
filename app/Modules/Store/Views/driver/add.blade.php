@extends("Store::layouts.master")

@section('content')
<div class=" custom_container">
   @include('Store::layouts.pending-alert')
   <div class="white_wrapper">
      <div class="block_heading">
         <h1 class="title">Add Driver</h1>
      </div>
      <hr class="full_ruller">
      <div class="p40">
         <form action="{{route('store.driver.save')}}" method="POST" id="add_Driver" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="flex-row mob-row-reverse">
               <div class="flex-col-sm-6">
                  <span class="form_title m-b-20">Basic Detail</span>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" maxlength="50" placeholder="Driver Name" name="name" value="{{old('name')}}">
                     </div>
                     @if($errors->has('name'))
                     <div class="alert-danger">{{ $errors->first('name') }}</div>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" maxlength="30" placeholder="Email ID" name="email"  value="{{old('email')}}">
                     </div>
                     @if($errors->has('email'))
                     <span>{{ $errors->first('email') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="number" maxlength="11" placeholder="Mobile number" name="mobile_number" value="{{old('mobile_number')}}">
                     </div>
                     @if($errors->has('mobile_number'))
                     <span>{{ $errors->first('mobile_number') }}</span>
                     @endif
                  </div>
                  <span class="form_title m-b-20">Gender</span>
                  <div class="form_field_wrapper">
                     <div class="flex-row">
                        <div class="flex-col-sm-6">
                           <div class="input-holder clearfix">
                              <input type="radio" name="gender" id="male" value="1">
                              <label for="male">Male</label>
                           </div>
                        </div>
                        <div class="flex-col-sm-6">
                           <div class="input-holder clearfix">
                              <input type="radio" name="gender" id="female" value="2">
                              <label for="female">Female</label>
                           </div>
                        </div>
                     </div>
                     <span id="gender-error"></span>
                     @if($errors->has('gender'))
                     <span>{{ $errors->first('gender') }}</span>
                     @endif
                     <span class="error_message"></span>
                  </div>
                  <span class="form_title m-b-20">Address Details</span>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="address" placeholder="Address (House No, Building, Street, Area)*" value="{{old('address')}}">
                     </div>
                     @if($errors->has('address'))
                     <span>{{ $errors->first('address') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="city" placeholder="City / District*" value="{{old('address')}}">
                     </div>
                     @if($errors->has('city'))
                     <span>{{ $errors->first('city') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="state" placeholder="State*" value="{{old('state')}}">
                     </div>
                     @if($errors->has('state'))
                     <span>{{ $errors->first('state') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text"  maxlength="6" name="pincode" placeholder="Pincode*" value="{{old('pincode')}}" onkeypress="return isNumber(event)">
                     </div>
                     @if($errors->has('pincode'))
                     <span>{{ $errors->first('pincode') }}</span>
                     @endif
                  </div>
                  <span class="form_title m-b-20">Vehicle Details</span>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="vehicle_number" maxlength="20" placeholder="Vehicle Number" value="{{old('vehicle_number')}}">
                     </div>
                     @if($errors->has('vehicle_number'))
                     <span>{{ $errors->first('vehicle_number') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text"  maxlength="20" name="license_number" placeholder="License Number" value="{{old('license_number')}}">
                     </div>
                     @if($errors->has('license_number'))
                     <span>{{ $errors->first('license_number') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="expiry_date" id="expiry_date" placeholder="Expiry Date" value="{{old('expiry_date')}}">
                     </div>
                     @if($errors->has('expiry_date'))
                     <span>{{ $errors->first('expiry_date') }}</span>
                     @endif
                  </div>
               </div>
               <div class="flex-col-sm-6">
                  <div class="wd-400">
                     {{-- <figure class="upload_store_img m-b-20">
                        <label for="upload_img" class="upload_img">
                        <img src="{{asset('asset-store/images/upload-img.png')}}">
                        <span class=""> Click to upload driver profile image
                        </span>
                        </label>
                        <input type="file" name="profile_image" accept="image/*" id="upload_img" style="display:none;">
                        <div class="show_upload_img" style="display: none;">
                           <label for="upload_img" class="upload_btn">Change Picture</label>
                           <img src="" class="" id="img-preview">
                        </div>
                     </figure> --}}


                      <figure class="upload_store_img m-b-20">
                        <div class="upload-img">
                           <input type="hidden" name="blobImg" id="cropped_image_preview" value="2">
                           <figure>
                           <img src="{{config('constants.DEAFULT_IMAGE.USER_IMAGE')}}" id="imageFile" alt="profile image"/>
                          
                           </figure>
                           <input type="file" style="display:none" id="image-selector" name="fileUpload"
                              accept="image/*">
                          
                              <label for="image-selector" class="camera">
                                 <img src="{{asset('asset-store/images/camera-line.png')}}"
                                    alt="upload image">
                                 </label>
                        </div>
                     </figure>

                       <input type="hidden" name="profile_image" value="" id="profilePic">
                       <input type="hidden" id="is_driver" value="1">

                     <label id="upload_img-error" class="error" for="upload_img"></label>
                     <div>
                        <span class="form_title m-b-20">Upload Proofs</span>
                        <div class="form_field_wrapper">
                           <div class="text_field_wrap">
                              <input type="text" id="fileToUpload_name_1" class="file-box" placeholder="Upload License*" readonly>
                              <span class="remove-file"><img src="assets/images/close-line.svg"></span>
                              <label class="upload-btn" for="fileToUpload_1">Browse</label>
                              <input type="file" class="proofs" name="proofs[license]" id="fileToUpload_1" style="display:none;" accept="image/*,.pdf">
                           </div>
                           <label id="fileToUpload_1-error" class="error" for="fileToUpload_1"></label>
                        </div>
                        <div class="form_field_wrapper">
                           <div class="text_field_wrap">
                              <input type="text"  id="fileToUpload_name_3" class="file-box" placeholder="Vehicle Image*" readonly>
                              <span class="remove-file"><img src="assets/images/close-line.svg"></span>
                              <label class="upload-btn" for="fileToUpload_3">Browse</label>
                              <input type="file" class="proofs" name="proofs[other]" id="fileToUpload_3" style="display:none;" accept="image/*,.pdf">
                           </div>
                           <label id="fileToUpload_2-error" class="error" for="fileToUpload_3"></label>
                        </div>
                        <div class="form_field_wrapper">
                           <div class="text_field_wrap">
                              <input type="text"  id="fileToUpload_name_2" class="file-box" placeholder="Valid Proof (Optional)" readonly>
                              <span class="remove-file"><img src="assets/images/close-line.svg"></span>
                              <label class="upload-btn" for="fileToUpload_2">Browse</label>
                              <input type="file" class="proofs" name="proofs[valid_proof]" id="fileToUpload_2" style="display:none;" accept="image/*,.pdf">
                           </div>
                           <label id="fileToUpload_2-error" class="error" for="fileToUpload_2"></label>
                        </div>
                        <span class="error_message"></span>
                     </div>
                  </div>
               </div>
            </div>
            <div class="flex-row">
               <div class="flex-col-sm-12">
                  <div class="button_wrapper text-right">
                     <ul>
                        <li><a class=" green-fill outline-btn" href="{{route('store.driver.list',['status'=>'all'])}}">Cancel</a> </li>
                        <li><button class="primary_btn green-fill btn-effect" id="spinner">Submit</button> </li>
                     </ul>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<input type="hidden" id="search_existing_email_route" value="{{route('store.driver.check.existing.email')}}">

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

@endsection
@push('script')
<script src="{{asset('asset-admin/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('asset-admin/js/validation.js')}}"></script>
<script src="{{asset('asset-store/js/bootstrap-select.js')}}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{asset('asset-store/js/add-driver.js')}}"></script>

<script src="{{asset('asset-admin/js/cropper.js')}}"></script>
<script src="{{asset('asset-admin/js/appinventivCropper.js')}}"></script>
<script src="{{asset('asset-store/js/profile.upload.js')}}"></script>
<script src="{{asset('asset-admin/js/circle-loader/src/jCirclize.js')}}"></script>
<script src="{{asset('asset-admin/js/s3.upload.amzon.js')}}"></script>

<script src="{{ asset('asset-store/js/s3.upload.js')}}"></script>

<script>
   $('#expiry_date').datetimepicker({
       format: 'YYYY-MM-DD',
       useCurrent: true,
   });
    $('#expiry_date').data("DateTimePicker").minDate(moment().format('YYYY-MM-DD'));
   
</script>
@endpush
@push('css')
<link rel="stylesheet" href="{{asset('asset-store/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" href="{{asset('asset-user-web/css/cannabis-cropper.css')}}">  

@endpush