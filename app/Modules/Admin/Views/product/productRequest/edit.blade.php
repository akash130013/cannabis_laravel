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
                        <li><a href="{{route('admin.product.request')}}">Product</a></li>
                        <li class="active">Edit Requested Product</li>
                    </ul>
				</div>
                <section>
                  
                    <form action="{{route('admin.product.request.update',['id'=>encrypt($data->id)])}}" id="admin_products" method="post">
                        @csrf
                        <input type="hidden" name="store_id" value="{{$data->store_id}}">
                        <div class="detail-section">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Product Name</label>
                                    <input type="text" maxlength="50" name="product_name" class="form-control" placeholder="Name" value="{{old('product_name',$data->product_name)}}">
                                    </div>

                                    @if(Session::has('errors'))
                                        <span class="error">{{ Session::get('errors')->first('product_name') }}</span>
                                    @endif

                                </div>
                               
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Category</label>
                                        <div>
                                        <select name="category" id="category">
                                            <option value="" selected disabled>Select</option>
                                            @if($category)
                                             @foreach($category as $val)
                                                <option value="{{$val->id}}" @if(isset($data->category) && $data->category->id==$val->id) {{'selected'}} @endif>{{ucfirst($val->category_name)}}</option>
                                             @endforeach
                                            @endif
                                        </select>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                                    <label class="mb-20">Packings Available</label>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label class="form-label">Quantity Unit</label>
                                        <div class="row m-b-12">
                                            <div class="col-md-3 col-sm-3 col-xs-3 pd-r-0">
                                                <div class="form-group quantity">
                                                    <select name="qty[unit][]" class="unit">
                                                        <option value="grams">Grams</option>
                                                        <option value="milligrams">MilliGrams</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-9 col-sm-9 col-xs-9">
                                                <div class="input-group control-group">
                                                    <input type="number" max="1000" name="qty[quant_units][]" class="form-control qtyValidate" placeholder="Size" onkeypress="return isNumber(event)" required>
                                                    <div class="input-group-btn"> 
                                                        <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row after-add-more"></div>
                                        <span class="error fadeout-error" id="qty_error">@if(Session::has('errors')){{Session::get('errors')->first('qty_error')}} @endif</span>

                                    @if(Session::has('errors'))
                                    <span class="error">{{Session::get('errors')->first('qty')}}</span>
                                    @endif

                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">THC Percentage</label>
                                                <input type="number" maxlength="5" onkeypress="return isFloatNumber(this,event)" name="thc_per" class="form-control" placeholder="THC %" value="{{old('thc_per',$data->thc)}}">
                                            </div>


                                            @if(Session::has('errors'))
                                                 <span class="error">{{Session::get('errors')->first('thc_per')}}</span>
                                            @endif


                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">CBD Percentage</label>
                                                <input type="number" maxlength="5" onkeypress="return isFloatNumber(this,event)" name="cbd_per" class="form-control" placeholder="CBD %" value="{{old('cbd_per',$data->cbd)}}">
                                            </div>
                                            @if(Session::has('errors'))
                                                    <span class="error">{{Session::get('errors')->first('cbd_per')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Product Description</label>
                                    <textarea name="product_desc" class="form-control" cols="30" rows="10">{{old('product_desc',$data->product_desc)}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Upload Product Image</label>
                                            <input type="file" id="image-selector" accept="image/*">
                                            <input type="hidden" name="blobImg" id="cropped_image_preview" value="2">

                                            <div class="upload-prod-pic-wrap">
                                                <ul>
                                                
                                                </ul>
                                            </div>
                                        @if(Session::has('errors'))
                                            <span class="error">{{Session::get('errors')->first('product_images')}}</span>
                                       @endif
                                       
                                       <input type="hidden" name="imgUploadCheck" id="imgUploadCheck">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <div class="btn-holder clearfix text-center">
                                    <a href="{{route('admin.product.request')}}"> <button type="button" class="green-fill-btn mr10  green-border-btn">Back</button></a>

                                        <button type="submit" class="green-fill-btn" id="submit-btn">Approve & Save</button>
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

   

    <div class="copy hide">
        <div class="form-group">
            <div class="control-group input-group" style="margin-top:10px">
                <select name="qty[unit][]">
                    <option value="grams">Grams</option>
                    <option value="milligrams">MilliGrams</option>
                </select>
                <input type="text" maxlength="10" name="qty[quant_units][]" class="form-control" placeholder="Size" onkeypress="return isNumber(event)" required>
                <div class="input-group-btn"> 
                    <button class="btn btn-danger remove" type="button">
                        <i class="glyphicon glyphicon-minus"></i>
                    </button>
                </div>
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

@endsection
    @section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{asset('asset-admin/js/product_add.js')}}"></script>
<script src="{{asset('asset-admin/js/cropper.js')}}"></script>
<script src="{{asset('asset-admin/js/appinventivCropper.js')}}"></script>
<script src="{{asset('asset-admin/js/circle-loader/src/jCirclize.js')}}"></script>
<script src="{{asset('asset-admin/js/s3.upload.amzon.js')}}"></script>
<script src="{{asset('asset-admin/js/custom.cropper.step.one.js')}}"></script>
@endsection