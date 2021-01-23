@extends('Admin::includes.layout')

@section('content')
<style>
     input[type=file]{ 
        color:transparent;
    }
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
        float: right;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
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
                        <li><a href="{{route('admin.category.index')}}">Category</a></li>
                        <li class="active">Edit Category</li>
                    </ul>
				</div>
                <section>
                  
                    <form action="{{route('admin.category.update',encrypt($data->id))}}" id="admin_category" method="post">
                       @csrf
                    <input type="hidden" id="cat_id" value="{{encrypt($data->id)}}">
                    <input type="hidden" id="type" value="category">
                    
                        <div class="detail-section">
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Category Name</label>
                                    <input type="text" maxlength="50" name="category_name" class="form-control" placeholder="Name" value="{{old('category_name',$data->category_name)}}">
                                    </div>

                                    @if(Session::has('errors'))
                                        <span class="error">{{ Session::get('errors')->first('category_name') }}</span>
                                    @endif

                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <div>
                                             <select name="status">
                                                 {{-- <option value="" selected disabled hidden>Select</option> --}}
                                                 <option value="active" @if(old('status',$data->status)=='active') {{'selected'}} @endif>Active</option>
                                                 <option value="blocked" @if(old('status',$data->status)=='blocked') {{'selected'}} @endif>Blocked</option>
                                                 
                                             </select>
                                             </div>
                                        </div>
    
                                        @if(Session::has('errors'))
                                            <span class="error">{{ Session::get('errors')->first('status') }}</span>
                                        @endif
    
                                    </div>
                              
                               
                            </div>
                                   
                            <input type="hidden" name="singleImage" id="singleImage" value="1">

                            <input type="hidden" name="thumbUrl" id="thumbUrl" value="{{$data->thumb_url ?? ''}}">
                            <div class="row">                                
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Category Description</label>
                                        <textarea name="product_desc"  maxlength="500" class="form-control" cols="30" rows="10">{{old('product_desc',$data->category_desc)}}</textarea>
                                        </div>
                                    </div>
                                  
                                    @php
                                      $key=[];
                                        if(!empty($data->thumb_url)){
                                         $key=explode('/',$data->thumb_url);
                                        }
                                     
                                    @endphp
                                  
                                </div>

                                @php
                                $objkey=[];
                                  if(!empty($data->image_url)){
                                   $objkey=explode('/',$data->image_url);
                                  }
                               
                              @endphp
                            <div class="row">
                            <div class="col-sm-12">
                                            <div class="form-group thumbnailprogress">
                                                <label class="form-label">Upload Thumbnail Image(100 x 100)Px</label>
                                                <input type="file" name="thumbImage" id="thumbImage" accept="image/x-png,image/gif,image/jpeg" />
                                                <span id="error_file" style="color: red;"></span> 
                                                <div id="upload_preview_id" class="thumbnail_box">
                                                    @if($data->thumb_url)
                                                    <img src="{{asset('asset-store/images/close.svg')}}" class="close trash-ico-thumb" data-key={{$key[3] ?? ''}}>
                                                    <img src="{{$data->thumb_url}}" class="preview">
                                                    @endif
                                                    
                                                </div>
                                            </div>  
                                        </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">Upload Category Image</label>
                                            <input type="file" id="image-selector" accept="image/*">
                                            <input type="hidden" name="blobImg" id="cropped_image_preview" value="2">
                                            <input type="hidden" id="pageName" value="cat_img">

                                            <div class="upload-prod-pic-wrap">
                                                <ul>
                                                    @if(isset($data->image_url))
                                                        <li>
                                                        <input id="image_{{$data->id}}" type='hidden' name='product_images[]' value={{$data->image_url}}>   
                                                                
                                                                <span class="trash-ico" data-key={{$objkey[3] ?? ''}}>
                                                               <i class="fa fa-times" aria-hidden="true">  </i>
                                                                </span>
                                                                <a href="{{$data->image_url}}" data-lightbox="example-set">

                                                                <img id="image_{{$data->id}}" src="{{$data->image_url ?? ''}}">
                                                                </a>
                                                            </li>
                                                        @endif
                                                </ul>
                                            </div>
                                        @if(Session::has('errors'))
                                            <span class="error">{{Session::get('errors')->first('product_images')}}</span>
                                       @endif
                                       <input type="hidden" name="imgUploadCheck" id="imgUploadCheck" value="1">

                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <div class="btn-holder text-center clearfix">
                                        <button type="submit" class="green-fill-btn">Update</button>
                                    <a href="{{route('admin.category.index')}}"> <button type="button" class=" mr10 green-fill-btn green-border-btn">Back</button></a>
                                    </div>
                                </div>
                                </div>
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
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{asset('asset-admin/js/category.js')}}"></script>
<script src="{{asset('asset-admin/js/cropper.js')}}"></script>
<script src="{{asset('asset-admin/js/appinventivCropper.js')}}"></script>
<script src="{{asset('asset-admin/js/circle-loader/src/jCirclize.js')}}"></script>
<script src="{{asset('asset-admin/js/s3.upload.amzon.js')}}"></script>
<script src="{{asset('asset-admin/js/custom.cropper.step.one.js')}}"></script>

@endsection
@endsection