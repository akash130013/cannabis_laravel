@extends('Store::layouts.master')
@push('css')
<link href="{{asset('asset-store/css/profile.css')}}" rel="stylesheet">


@endpush
@section('content')
<span class="profile-menu">
   <img src="/asset-store/images/menu-line.svg" alt="profile menu">
</span>
<div class="full_custom_container profile-view">
   @include('Store::layouts.pending-alert')
   <div class="wrap-row-full">
      @include('Store::profile.profile-sidebar')
      <!--Profile Detail Col update store image-->
      <div class="right-col-space ">
         <div class="white_wrapper">
            <form action="{{route('store.update.images')}}" method="post" id="submit_store_images">
               <input type="hidden" name="_token" value="{{csrf_token()}}">
               <div class="form-container cstm-map stepForm step3 active">
                  <div class="operat-hours">
               <!--banner part -->
                     <div class="bannerImage">
                        <input type="file" id="image-selector-banner" name="fileUpload" accept="image/*">
                        <input type="hidden" name="blobImgBanner" id="cropped_image_preview_banner" value="2">
                        <input type="hidden" name="bannerImage" id="bannerImage" value="">
                        <label for="image-selector-banner" class="upload-icon">
                          Update Store Banner image
                        </label>
                        
                     </div>
                   
                    

            
                     <div class="banner-img-wrap">  
                        <figure id="upload-banner-image">
                             @if(!empty($storeBanner->banner_image_url) && isset($storeBanner->banner_image_url   ))
                              <img class="banner-store-img" src="{{$storeBanner->banner_image_url}}" />
                             @endif
                        </figure>
            
                     </div>
          <!--end banner part -->


                     <div class="storeImages w-100">
                        <!-- <input type="file" name="storeimages" id="upload_file" onclick="this.value=null;" onchange="s3_upload_directly_BackgroundImage(this.id,'error_file','append_section','','laoderupload')"> -->
                        <input type="file" id="image-selector" name="fileUpload" accept="image/*">
                        <input type="hidden" name="blobImg" id="cropped_image_preview" value="2">
                        <label for="image-selector" class="upload-icon">
                        <img src="{{asset('asset-store/images/upload-store.svg')}}" alt="Upload Store Image">
                        Click to upload your store images
                        </label>
                        <div>
                        </div>
                     </div>
                     <span class="error fadeout-error" id="error_file"> @if(Session::has('errors')) {{Session::get('errors')->first('images')}} @endif</span>
                     <div id="append_section" class="uploadImages-row upload-prod-pic-wrap">
                        <ul>
                           @if($images)
                           @foreach($images as $val)
                           <li>
                              <div class="uploadImages" id="_remove{{$val->id}}">
                                 <div class="image">
                                    <img src="{{$val->file_url}}">
                                    <input type="hidden" name="images[]" value="{{$val->file_url}}">
                                    <img src="{{asset('asset-store/images/close.svg')}}" data-id="{{$val->id}}" data-remove="_remove{{$val->id}}" class="close">
                                 </div>
                              </div>
                           </li>
                           @endforeach
                           @endif
                        </ul>
                     </div>
                     <input type="hidden" id="close_icon" value="{{asset('asset-store/images/close.svg')}}">
                     <div class="frm_btn">
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="btn-group m-t-20">
                                 {{-- <a  href="{{route('store.show.working.hours')}}" class="green-fill outline-btn store-bck-btn backbtn">Back</a> --}}
                                 <button type="submit" class="green-fill btn-effect m-l-20">Update</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
      </div>
      </form>
      <!--Profile Detail Col-->
      <input type="hidden" id="hidden_url" value="{{route('store.remove.uploaded.images')}}">
      <input type="hidden" id="store_id" value="{{Auth::guard('store')->user()->id}}">
   </div>
</div>
@endsection
@section('modal')
<div class="modal fade cropperModalBox" id="cropper_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close modal-close trash-ico" data-dismiss="modal">
            <img src="/asset-store/images/close-card.svg"></button>
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
                        <button class="green-fill outline-btn btn-sm" data-dismiss="modal">Cancel</button>  
                        <!-- <a href="https://cannabisdev.appskeeper.com/user/profile" class="outline-fill btn-sm">Cancel</a> -->
                     </li>
                     <li>
                        <button class="green-fill btn-effect btn-sm" id="crop_it">Crop</button>
                        <!-- <button type="submit" class="" id="submit_button">Save</button>  -->
                     </li>
                  </ul>
               </div>
               <!-- <button class="btn success hvr-ripple-out" data-dismiss="modal">Cancel</button>
                  <button class="btn success hvr-ripple-out" id="crop_it">Crop</button> -->
            </div>
         </div>
      </div>
   </div>
</div>


<div class="modal fade cropperModalBox" id="cropper_modal_banner" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close modal-close trash-ico" data-dismiss="modal">
            <img src="/asset-store/images/close-card.svg"></button>
            <h4 class="modal-title">Crop Image</h4>
         </div>
         <div class="modal-body clearfix">
            <div class="col-md-12">
               <div class="img-container">
                  <img id="image-to-crop-banner" src=" " alt="Picture">
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <div class="form_field_wrapper text-center">
               <div class="btn-wrapper">
                  <ul>
                     <li>
                        <button type="button" class="green-fill outline-btn btn-sm" data-dismiss="modal">Cancel</button>  
                       
                     </li>
                     <li>
                        <button type="button" class="green-fill btn-effect btn-sm" id="crop_it_banner">Crop</button>
                       
                     </li>
                  </ul>
               </div>
              
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('script')
<style>
   #cropper_modal .modal-lg {
   max-width: 500px;
   }
   /* .container {
   max-width: 400px;
   margin: 20px auto;
   } */
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
   right: 15px;
   background: #ff8338;
   border-radius: 50%;
   padding: 3px 4px;
   opacity: 1;
   cursor: pointer;
   outline: none;
   border: 2px solid #fff;
   } 
   /* .cropper-view-box,
   .cropper-face {
   border-radius: 50%;
   } */
</style>
<script src="{{asset('asset-admin/js/cropper.js')}}"></script>
<script src="{{asset('asset-admin/js/banner-cropper.js')}}"></script>
<script src="{{asset('asset-admin/js/appinventivCropper.js')}}"></script>
<script src="{{asset('asset-admin/js/circle-loader/src/jCirclize.js')}}"></script>
<script src="{{asset('asset-admin/js/s3.upload.amzon.js')}}"></script>
<script src="{{asset('asset-store/js/custom.cropper.upload.image.js')}}"></script>       
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{ asset('js/disableBackButton.js')}}"></script>
<script src="{{ asset('asset-store/js/s3.upload.js')}}"></script>
<script>
   @if($images->isEmpty())
   
   $("#submit_store_images").validate({
       rules: {
           storeimages: {
               required: true
           }
       },
       messages: {
           storeimages: {
               required: "Please upload your store images"
           }
       }
   });
   
   @endif
   
   var REMOVE_IMAGES = {
   
       __ajax_call_remove_images: function(id,store_id) {
   
           $.ajax({
   
               type: 'GET',
   
               url: $("#hidden_url").val(),
   
               data: {
                   id: id,
                   storeID : store_id
               },
   
               success: function(data) {
   
                   console.log(data);
   
               },
               error: function() {
                   alert("Something went wrong");
                   
               }
   
           });
   
       }
   }
   
   $('body').on('click', '.close', function() {
       var id = $(this).attr("data-remove");
       var newid = $(this).attr('data-id');
       var storeID = $("#store_id").val();
       
       if(!$(this).hasClass('trash-ico')){
   
       swal({
           title: localMsg.BeSure,
           text: "Do you really want to remove this image ?",
           type: "warning",
           buttons: ["No", "Delete It!"],
           closeOnClickOutside: true,
           closeOnEsc: true
       }).then((isConfirm) => {
              if (isConfirm) {
                 REMOVE_IMAGES.__ajax_call_remove_images(newid,storeID);
                 $("#" + id).closest('li').remove();
              }
        })
     } 
       
   });
   
</script>
@endpush