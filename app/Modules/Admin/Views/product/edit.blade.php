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
                        <li><a href="{{route('admin.product.listing')}}">Product</a></li>
                        <li class="active">Edit Product</li>
                    </ul>
				</div>
                <section>
                  
                    <form action="{{route('product.update',['id'=>encrypt($data->id)])}}" id="admin_products" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="deleted_size" id="deleted_size">
                        <input type="hidden" name="deleted_unit" id="deleted_unit">

                        <div class="detail-section">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group product">
                                        <label class="form-label">Product Name</label>
                                    <input type="text" name="product_name" class="form-control" placeholder="Name" value="{{$data->product_name ?? ''}}">
                                    </div>

                                    @if(Session::has('errors'))
                                        <span class="error">{{ Session::get('errors')->first('product_name') }}</span>
                                    @endif

                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group product">
                                        <label class="form-label">Category</label>
                                        <div class="text-field-wrapper">
                                        <select name="category" id="category">
                                            @if($category)
                                             @foreach($category as $val)
                                                <option @if($data->getCategory->id == $val->id) selected="selected" @endif 
                                                    value="{{$val->id}}">{{ucfirst($val->category_name)}}</option>
                                             @endforeach
                                            @endif
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                                    <label class="mb-20">Packings Available</label>
                            <div class="row">
                               @php
                                 $i=0;
                               @endphp
                           
                                 
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="form-label">Quantity Unit</label>
                                    
                                    <div class="form-group package-edit control-group">
                                        <button class="green-fill-btn add-more_edit" type="button">Add Qty Size</button>
                                    </div>


                                     <div class="form-group edit_more after-add-more">
                                        {{-- <button class="btn btn-success " type="button"><i class="glyphicon glyphicon-plus"></i></button> --}}
                                            @foreach (json_decode($data->quantity_json) as $item)
                                            <div class="form-group package-edit control-group">
                                                <div class="row m-b-12">
                                                    <div class="col-md-3 col-sm-3 col-xs-3 pd-r-0">
                                                        <select name="qty[unit][{{$i}}]" class="unit disabledbutton">
                                                            <option value="grams" @if($item->unit=='grams') {{'selected'}} @endif>Grams</option>
                                                            <option value="milligrams" @if($item->unit=='milligrams') {{'selected'}} @endif>MilliGrams</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-9 col-sm-9 col-xs-9 pd-r-0">
                                                        <input type="number" max="1000" maxlength="6" name="qty[quant_units][{{$i}}]" class="form-control qtyValidate disabledbutton" placeholder="Size" value="{{$item->quant_units}}" onkeypress="return isNumber(event)" required>
                                                        <div class="input-group-btn"> 
                                                           
                                                            {{-- @if($i==0)   
                                                            {{-- <button class="btn btn-success add-more_edit" type="button"><i class="glyphicon glyphicon-plus"></i></button> --}}
                                                        
                                                        <button class="btn btn-danger removeedit" id="remove_{{$i}}" type="button" data-size="{{$item->quant_units}}" data-unit="{{$item->unit}}" onclick="addDada($(this).data('size'),$(this).data('unit'),$(this).attr('id'))">
                        
                                                            <i class="glyphicon glyphicon-minus"></i>
                                                            </button>
                                                        {{-- @endif --}}
                                                        </div>
                    
                                                    </div>

                                                </div>
                                            </div>
                                            @php $i=$i+1 @endphp
                                            @endforeach

                                        <input type="hidden" id="lastNum" value="{{$i}}">
                                     </div>
                                   
                                    <!-- <div class="copy hide">
                                        
                                    </div> -->

                                    @if(Session::has('errors'))
                                    <span class="error">{{Session::get('errors')->first('qty')}}</span>
                                    @endif

                                    <span class="error fadeout-error" id="qty_error">@if(Session::has('errors')){{Session::get('errors')->first('qty_error')}} @endif</span>

                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group thcpercent">
                                                <label class="form-label">THC Percentage</label>
                                            <input type="number" onkeypress="return isFloatNumber(this,event)" name="thc_per" class="form-control" placeholder="THC Percentage" value="{{$data->thc_per ?? ' '}}">
                                            </div>


                                            @if(Session::has('errors'))
                                                 <span class="error">{{Session::get('errors')->first('thc_per')}}</span>
                                            @endif


                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group thcpercent">
                                                <label class="form-label">CBD Percentage</label>
                                            <input type="number" onkeypress="return isFloatNumber(this,event)" name="cbd_per" class="form-control" placeholder="CBD Percentage" value="{{$data->cbd_per ?? ''}}">
                                            </div>
                                            @if(Session::has('errors'))
                                                    <span class="error">{{Session::get('errors')->first('cbd_per')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Product Description</label>
                                    <textarea name="product_desc"  maxlength="500" class="form-control" cols="30" rows="10">{{$data->product_desc ?? ''}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                    
                                        <div class="text-field-wrapper">
                                        <select name="status">
                                        <option value="active" @if($data->status=='active') {{'selected'}} @endif>Active</option>
                                        <option value="blocked" @if($data->status=='blocked') {{'selected'}} @endif>Blocked</option>
                                        </select>
                                            </div>                    
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group">
                                        <label class="form-label">Is Trending</label>
                                        <div>
                                         <input type="checkbox" id="is_trending" @if($data->is_trending == true) {{'checked'}} @endif name="is_trending" class="checkFilter" value="true">
                                        </div>
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
                                                   @foreach ($data->getImage as $item)
                                                       <li>
                                                            <input id="image_{{$item->id}}" type='hidden' name='product_images[]' value={{$item->file_url}}>   
                                                            
                                                            <span class="trash-ico">
                                                           <i class="fa fa-times" aria-hidden="true">  </i>
                                                            </span>
                                                            <a href="{{$item->file_url}}" data-lightbox="example-set">
                                                            <img id="image_{{$item->id}}" src="{{$item->file_url}}">
                                                            </a>
                                                        </li>
                                                   @endforeach
                                                </ul>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{Session::get('errors')->first('qty')}}</span>
                                                 @endif

                                                 <input type="hidden" name="imgUploadCheck" id="imgUploadCheck" value="1">
                                            </div>


                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <div class="form-group">
                                    <div class="btn-holder clearfix">
                                    <a href="{{route('admin.product.listing')}}"><button type="button" class="green-fill-btn mr10  green-border-btn">Cancel</button></a>

                                        <button type="submit" class="green-fill-btn">Update</button>
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

   
    {{-- <div class="copy hide">
        <div class="form-group">
            <div class="control-group input-group" style="margin-top:10px">
                <select name="qty[unit][]">
                    <option value="grams">Grams</option>
                    <option value="milligrams">MilliGrams</option>
                </select>
                <input type="text" name="qty[quant_units][]" class="form-control" placeholder="Size" onkeypress="return isNumber(event)" required>
                <div class="input-group-btn"> 
                    <button class="btn btn-danger remove" type="button">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

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
    <script src="{{asset('asset-admin/js/delete-size.js')}}"></script>
 @endsection

