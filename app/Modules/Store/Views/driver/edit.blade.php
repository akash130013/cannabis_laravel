@extends("Store::layouts.master")
@section('content')
<div class=" custom_container">
   @include('Store::layouts.pending-alert')
   <div class="white_wrapper">
      <div class="block_heading">
         <h1 class="title">Edit Driver Details</h1>
      </div>
      <hr class="full_ruller">
      <div class="p40">
         <form action="{{route('store.driver.update',$driver->id)}}" method="POST" id="edit_Driver" enctype="multipart/form-data">
            @method('PUT')
            {{ csrf_field() }}
            <div class="flex-row mob-row-reverse">
               <div class="flex-col-sm-6">
                  <span class="form_title m-b-20">Basic Detail</span>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" placeholder="Driver Name" name="name" value="{{old('name',$driver->name)}}">
                     </div>
                     @if($errors->has('name'))
                     <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" placeholder="Email ID" disabled name="email"  value="{{old('email',$driver->email)}}">
                     </div>
                     @if($errors->has('email'))
                     <span>{{ $errors->first('email') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="number" placeholder="Enter Mobile Number" disabled name="mobile_number" value="{{old('mobile_number',$driver->phone_number)}}">
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
                              <input type="radio" name="gender" id="male" value="Male" {{$driver->gender == 'Male' ? 'checked': ''}}>
                              <label for="male">Male</label>
                           </div>
                        </div>
                        <div class="flex-col-sm-6">
                           <div class="input-holder clearfix">
                              <input type="radio" name="gender" id="female" value="Female" {{$driver->gender == 'Female' ? 'checked': ''}}>
                              <label for="female">Female</label>
                           </div>
                        </div>
                     </div>
                     @if($errors->has('gender'))
                     <span>{{ $errors->first('gender') }}</span>
                     @endif
                     <span class="error_message"></span>
                  </div>
                  <span class="form_title m-b-20">Address Details</span>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="address" placeholder="Address (House No, Building, Street, Area)*" value="{{old('address',$driver->address)}}">
                     </div>
                     @if($errors->has('address'))
                     <span>{{ $errors->first('address') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="city" placeholder="City / District*" value="{{old('city',$driver->city)}}">
                     </div>
                     @if($errors->has('city'))
                     <span>{{ $errors->first('city') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="state" placeholder="State*" value="{{old('state',$driver->state)}}">
                     </div>
                     @if($errors->has('state'))
                     <span>{{ $errors->first('state') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="pincode" placeholder="Pincode*" value="{{old('pincode',$driver->zipcode)}}">
                     </div>
                     @if($errors->has('pincode'))
                     <span>{{ $errors->first('pincode') }}</span>
                     @endif
                  </div>
                  <span class="form_title m-b-20">Vehicle Details</span>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="vehicle_number" placeholder="Vehicle Number" value="{{old('vehicle_number',$driver->vehicle_number)}}">
                     </div>
                     @if($errors->has('vehicle_number'))
                     <span>{{ $errors->first('vehicle_number') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="license_number" placeholder="License Number" value="{{old('license_number',$driver->dl_number)}}">
                     </div>
                     @if($errors->has('license_number'))
                     <span>{{ $errors->first('license_number') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="expiry_date" id="expiry_date"  placeholder="Expiry Date" value="{{old('expiry_date',$driver->dl_expiraion_date)}}">
                     </div>
                     @if($errors->has('expiry_date'))
                     <span>{{ $errors->first('expiry_date') }}</span>
                     @endif
                  </div>
               </div>
               <div class="flex-col-sm-6">
                  <div class="wd-400">
                     <figure class="upload_store_img m-b-20">
                        {{-- <label for="upload_img" class="upload_img">
                        <img src="{{asset('asset-store/images/upload-img.png')}}">
                        <span class=""> Click to upload driver profile image
                        </span>
                        </label>
                        <input type="file" name="profile_image" accept="image/*" id="upload_img" style="display:none;">
                        <div class="show_upload_img" >
                           <label for="upload_img" class="upload_btn">Change Picture</label>
                           <img src="{{$driver->profile_image}}" class="" id="img-preview" onerror="imgUserError(this);">
                        </div> --}}
                        <div class="upload-img">
                           <input type="hidden" name="blobImg" id="cropped_image_preview" value="2">
                           <figure>
                           <img src="{{$driver->profile_image}}" id="imageFile" alt="profile image"/>
                          
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

                     <div>
                        <span class="form_title m-b-20">Upload Proofs</span>
                        <div class="form_field_wrapper">
                           <div class="text_field_wrap">
                              <input type="text"  id="fileToUpload_name_1" class="file-box" placeholder="Upload License*" readonly>
                              <span class="remove-file"><img src="assets/images/close-line.svg"></span>
                              <label class="upload-btn" for="fileToUpload_1">Browse</label>
                              <input type="file" class="proofs" name="proofs[license]" id="fileToUpload_1" style="display:none;" accept="image/*,.pdf,">
                           </div>
                           <label id="fileToUpload_1-error" class="error" for="fileToUpload_1"></label>
                        </div>
                        <div class="form_field_wrapper">
                           <div class="text_field_wrap">
                              <input type="text"  id="fileToUpload_name_3" class="file-box" placeholder="Veicle image*">
                              <span class="remove-file"><img src="assets/images/close-line.svg"></span>
                              <label class="upload-btn" for="fileToUpload_3">Browse</label>
                              <input type="file" class="proofs" name="proofs[other]" id="fileToUpload_3" style="display:none;" accept="image/*,.pdf,">
                           </div>
                        </div>
                        <div class="form_field_wrapper">
                           <div class="text_field_wrap">
                              <input type="text"  id="fileToUpload_name_2" class="file-box" placeholder="Valid Proof">
                              <span class="remove-file"><img src="assets/images/close-line.svg"></span>
                              <label class="upload-btn" for="fileToUpload_2">Browse</label>
                              <input type="file" class="proofs" name="proofs[valid_proof]" id="fileToUpload_2" style="display:none;" accept="image/*,.pdf,">
                           </div>
                        </div>
                        <span class="error_message"></span>
                        <h3>Current Documents</h3>
                        <ol>
                           @foreach ($driver->proofs as $item)
                           <li> 
                              <a  target="_blank" href="{{$item->file_url}}">
                              @if($item->type == 'other')
                              Vehicle Image
                              @else
                              {{str_replace('_',' ',$item->type)}}
                              @endif
                              </a>
                           </li>
                           @endforeach
                        </ol>
                     </div>
                  </div>
               </div>
            </div>
            <div class="flex-row">
               <div class="flex-col-sm-12">
                  <div class="button_wrapper text-right">
                     <ul>
                        <li><a class="green-fill outline-btn" href="{{route('store.driver.show',['id'=>$driver->id])}}">Cancel</a> </li>
                        <li><button class="primary_btn green-fill btn-effect" id="spinner">Update</button> </li>
                     </ul>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>

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