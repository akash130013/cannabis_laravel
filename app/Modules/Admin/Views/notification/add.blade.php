@extends('Admin::includes.layout')

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

   /* .cropper-view-box,
         .cropper-face {
         border-radius: 50%;
         } */
    </style>
<div class="wrapper">
        <!-- Side menu start here -->
        
        @include('Admin::includes.sidebar')
        <!-- Side menu ends here -->
        <div class="right-panel">
                @include('Admin::includes.header')

            <div class="inner-right-panel">
                <div class="breadcrumb-section">
					<ul class="breadcrumb">
                        <li><a href="{{route('admin.notification.index')}}">Notification</a></li>
                        <li class="active">Add Notification</li> 
                    </ul>
				</div>
                <section>
                  
                    <form action="{{route('admin.notification.store')}}" id="admin_notification" method="post">
                       @csrf
                    <!-- Inner Right Panel Start -->
                    {{-- <input type="hidden" name="notification_id" value="{{old('id',$data != null?$data->id:'')}}"> --}}

                    <div class="inner-right-panel">
                        <div class="white_wrapper formgroup-fields">
                            <div class="flex-row">
                                <!-- left form filled start-->
                                <div class="flex-col-sm-6">
                                    <div class="formwrap">
                                        <div class="formfilled-wrapper mb15">
                                            <label>Title</label>
                                            <div class="textfilled-wrapper">
                                                <input type="text" maxlength="50" placeholder="Enter notification title" name="title" value="{{old('title',$data != null?$data->title:'')}}"/>
                                            </div>
                                            <span></span>
                                            @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('title') }}</span>
                                            @endif
                                        </div>
                                        <div class="formfilled-wrapper mb15" id="checkNotifyType">
                                            <label>Destination Page</label>
                                            <div class="textfilled-wrapper">
                                                    <input type="text" id="searchNotifyType" class=" pl-210 searchNotifyType" placeholder="Search the product you wish to add">
                                                    <input type="hidden" id="notification_type_id" name="notify_type_id">
                                                    <div class="cross" id="search_loader"></div>
                                                    <span class="error" id="error_product_search"></span>
                                             </div>
                                             <span></span>
                                             @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('notify_type_id') }}</span>
                                            @endif
                                        </div>
                                        <div class="formfilled-wrapper mb15">
                                                <label>Description</label>
                                                <div class="textfilled-wrapper">
                                                    <textarea type="text" maxlength="150" name="description">{{old('description',$data != null?$data->description:'')}}</textarea>
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('description') }}</span>
                                                @endif
                                            </div>

                                    </div>
                                </div>
                                <!-- left form filled end-->
                                <!-- right form filled start-->
                                <div class="flex-col-sm-6">
                                    <div class="formwrap m0">
                                        <div class="select-dropdown mb15">
                                            <label>Notification Type</label>
                                            <div class="select_picker_wrapper">
                                                <select name="notify_type" class="selectpicker" id="notifyType">
                                                   {{-- <option value="" disabled selected>Select Notification Type</option> --}}
                                                    @foreach ($notificationTypes as $key => $type)
                                                        <option value="{{$type}}" @if(old('notify_type',$data != null?$data->notify_type:'') == $type) {{'selected'}} @endif>{{str_replace('_',' ',$key)}}</option>
                                                    @endforeach
                                                    {{-- <option value="product" @if(old('notify_type',$data != null?$data->notify_type:'') == 'product') {{'selected'}} @endif>Product</option>
                                                    <option value="category" @if(old('notify_type',$data != null?$data->notify_type:'') == 'category') {{'selected'}} @endif>Category</option> --}}
                                                </select>
                                            </div>
                                            <span></span>
                                            @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('notify_type') }}</span>
                                            @endif
                                        </div>
        
                                        <div class="select-dropdown mb15">
                                                <label>Platform</label>
                                                <div class="select_picker_wrapper">
                                                    <select name="platform" class="selectpicker">
                                                        <option value="both" @if(old('platform',$data != null?$data->platform:'') == 'both') {{'selected'}} @endif>Both</option>
                                                        <option value="ios" @if(old('platform',$data != null?$data->platform:'') == 'ios') {{'selected'}} @endif>IOS</option>
                                                        <option value="android" @if(old('platform',$data != null?$data->platform:'') == 'android') {{'selected'}} @endif>Android</option>
                                                    </select>
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('platform') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                </div>
                                <!-- right form filled end-->
                            </div>
                            <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group thumbnailprogress">
                                                <input type="hidden" name="singleImage" id="singleImage" value="1">
                                                <input type="hidden" name="thumbUrl" id="thumbUrl" value="{{$data->thumb_url ?? ''}}">
                                            <label class="form-label">Upload Thumbnail Image(100 x 100)Px</label>
                                            <input type="file" name="thumbImage" id="thumbImage" accept="image/x-png,image/gif,image/jpeg" />
                                            <span id="error_file" style="color:red"></span> 
                                            <div id="upload_preview_id" class="thumbnail_box">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            <!-- Add Cancel Buttons -->
                            <div class="mt20 text-center">
                                <a href="{{route('admin.notification.index')}}">  <button type="button" class="green-fill-btn mr10 green-border-btn" >Cancel</button></a>
                                <button class="green-fill-btn" type="submit">Send Notification</button>
                            </div>
                            <!-- Add Cancel Buttons -->

                        </div>
                    </div>
                    </form>
                </section>
            </div>
        </div>
</div>

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
     
     
     @section('pagescript')
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script> 
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
     <script src="{{asset('asset-admin/js/category.js')}}"></script>
     <script src="{{asset('asset-admin/js/cropper.js')}}"></script>
     <script src="{{asset('asset-admin/js/appinventivCropper.js')}}"></script>
     <script src="{{asset('asset-admin/js/circle-loader/src/jCirclize.js')}}"></script>
     <script src="{{asset('asset-admin/js/s3.upload.amzon.js')}}"></script>
     <script src="{{asset('asset-admin/js/custom.cropper.step.one.js')}}"></script>
     <script src="{{asset('asset-admin/js/autocomplete.js')}}"></script>
     <link rel="stylesheet" href="{{asset('asset-store/css/jquery.ui.css')}}">  
     <script>
        
            $("#admin_notification").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 50,
                        minlength: 3,
                    },
                    notify_type_id: {
                        required: true,
                    },
                    description: {
                        required: true,
                        maxlength: 200
                    },
                    notify_type: {
                        required: true,
                    },
                    platform: {
                        required: true,
                    },
                    
                },
            
                highlight: function (element) {
                    $(element).parent('div').addClass('error-message');
                },
                unhighlight: function (element) {
                    $(element).parent().parent().removeClass('error-message');
            
                },
                errorPlacement: function (error, element) {
                    error.appendTo($(element).parents('.textfilled-wrapper').next());
               },
                messages: {
                    promo_name: {
                        required: "Please enter offer name",
                    },
                    title: {
                        required: "Please enter notification title",
                    },
                    notify_type_id: {
                        required: "please select notify type",
                    },
                    description: {
                        required: "Please enter description",
                    },
                    notify_type: {
                        required: "Please select destination page",
                    },
                    platform: {
                        required: "Please choose platform",
                    },
                   
                },
                submitHandler: function (form, event) {
                    // if (iti.isValidNumber()) {
                        // $("input[name='phone_code']").val(iti.s.dialCode);
                        $("#signup_button").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
                        form.submit();
            
                    // }
                }
            });
        </script>
     @endsection
@endsection