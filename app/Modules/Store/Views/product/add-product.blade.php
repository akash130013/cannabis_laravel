@extends("Store::layouts.master")
@push('css')
<link href="{{asset('asset-store/css/product.css')}}" ref="stylesheet">
@endpush
@section('content')
<!-- Header End -->
<!-- Internal Container -->
<div class="internal-container product">
   <div class="cb-tabsBody">
      <div class="tab-content">
         @include('Store::layouts.pending-alert')
         <div id="products" class="container-fluid tab-pane active">
            <div class="addnewproduct-screen prdctHeight">
               <div class="form-container">
                  <div class="product-header">
                     <h2>Add New Product</h2>
                     <div class="counter"><span>1</span>/3</div>
                     <div class="progressBorder"></div>
                     <div class="step step1"></div>
                  </div>
                  <div class="addPrdctForm">
                     <figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
                     <div class="frm-sec-ins">
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="form-group">
                                 <input type="text" id="searchproduct" class=" pl-210 searchproduct" placeholder="Search the product you wish to add">
                                 <div class="cross" id="search_loader"></div>
                                 <div class="selectpanel">
                                    <select id="selected_cat_id" class="selectedIndex select_drop">
                                       <option value=""  class="selectedIndex">All Categories</option>
                                       @if($category)
                                       @foreach($category as $val)
                                       <option value="{{$val->id}}"  class="selectedIndex">{{$val->category_name}}</option>
                                       @endforeach
                                       @endif
                                    </select>
                                    <img src="{{asset('asset-store/images/droparrow1.svg')}}" class="dropmenu" alt="drop down menu">
                                 </div>
                              </div>
                              <span class="error" id="error_product_search"></span>
                              <div class="btn-group">
                                 <button class="custom-btn green-fill btn-effect" id="nex_button_select_qty" data-datac="1">Next</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="addnewproduct-screen-second prdctHeight">
               <div class="form-container">
                  <div class="product-header">
                     <h2>Add Product Info</h2>
                     <div class="counter"><span>2</span>/3</div>
                     <div class="progressBorder"></div>
                     <div class="step step2"></div>
                  </div>
                  <div class="addPrdctForm">
                     <figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
                     <div class="frm-sec-ins">
                        <div class="row">
                           <div class="col-sm-12">
                              <div id="copy_div">
                                 <div class="form-group">
                                    <input type="number" maxlength="10" name="price[quant_price]" onkeypress="validate(event)" class="pl-210 searchproduct1 add-product" placeholder="Enter actual price (in $)" required>
                                    <input type="number" maxlength="5" name="price[offered]"  onkeypress="validate(event)" class="quantity hidden" placeholder="Enter offered price" required>
                                    <input type="number" maxlength="5" name="price[pack]"  onkeypress="validate(event)" class="quantity" placeholder="Enter quantity"  required>
                                    <div class="selectpanel" id="option_selected_">
                                       <select id="quantity_data" name="price[choice]" class="selectedIndex sel-quant select_drop">
                                       </select>
                                       <img src="{{asset('asset-store/images/droparrow1.svg')}}" class="dropmenu" alt="drop down menu">
                                    </div>
                                 </div>
                              </div>
                              <div id="add_more_div">
                              </div>
                              <span class="error" id="error_submit_qty"></span>
                              <span>
                                 <p class="add_more" id="add_more_button">Add More</p>
                              </span>
                              <div class="btn-wrapper text-center">
                                 <ul>
                                    <li>
                                       <button class="green-fill outline-btn custom-btn backstep2">Back</button>
                                    </li>
                                    <li>
                                       <button class="custom-btn green-fill btn-effect" id="show_preview_data">Next</button>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="addnewproduct-screen-third prdctHeight">
               <div class="form-container">
                  <div class="product-header">
                     <h2>Product Preview</h2>
                     <div class="counter"><span>3</span>/3</div>
                     <div class="progressBorder"></div>
                     <div class="step step3"></div>
                  </div>
                  <div class="addPrdctForm">
                     <div class="productPreview">
                        <div class="row mob-row-reverse" id="show_preview_items">
                           <div class="col-md-8 col-sm-8 col-xs-12">
                              <div class="prdctHeader">
                                 <h3>Afghani Hawaiian Strain</h3>
                                 <h6>Hybrid</h6>
                                 <p>THC: 21% CBD: 6%</p>
                              </div>
                              <div class="prdctDesp">
                                 <h5>Quantity & Price</h5>
                                 <div class="prdctQuantity">
                                    <div class="product">
                                       <div class="pd-brdr">
                                          <span>2g</span>
                                       </div>
                                       <p>$100.20 (50 pac.)</p>
                                    </div>
                                    <div class="product">
                                       <div class="pd-brdr">
                                          <span>10g</span>
                                       </div>
                                       <p>$100.20 (50 pac.)</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="additionInfo">
                                 <h5>Additional Description</h5>
                                 <div class="form-group">
                                    <textarea cols="30" class="add_description" required rows="5" name="pro_desc" placeholder="Write here..."></textarea>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 col-sm-4 col-xs-12">
                              <figure class="producttView">
                                 <img src="{{asset('asset-store/images/product.jpg')}}" alt="product">
                              </figure>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="btn-wrapper text-center preview">
                                 <ul>
                                    <li>
                                       <button class="green-fill outline-btn custom-btn backpreviewbtn">Back</button>
                                    </li>
                                    <li>
                                       <button class="custom-btn green-fill btn-effect" id="final_submit_data">Finish</button>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <form id="final_product_submision">
               <input type="hidden" name="product_id" id="searchproduct_id">
               <input type="hidden" name="store_id" value="{{ Auth::guard('store')->user()->id }}">
               <div id="price_section_html">
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addProductModal" role="dialog">
   <div class="modal-dialog statusDialogue addProductDialogWrap">
      <!-- Modal content-->
      <form action="{{route('store.request.product')}}" id="requestedFormId" method="GET">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close modal-close" onclick="location.reload()">
               <img src="/asset-store/images/close-card.svg">
               </button>
               <h4 class="modal-title">Add New Product</h4>
            </div>
            <div class="modal-body">
               <div class="modal-padding">
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="text" name="product_name" id="pro_name" placeholder="Product Name" value="{{old('product_name')}}">
                     </div>
                     @if(Session::has('errors'))
                     <span class="error">{{ Session::get('errors')->first('product_name') }}</span>
                     @endif
                     <input type="hidden" name="category_id" id="category_id">
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="number" name="thc"  placeholder="THC %" onkeypress="return isFloatNumber(this,event)" maxlength="5" value="{{old('thc')}}">
                     </div>
                     @if(Session::has('errors'))
                     <span class="error">{{ Session::get('errors')->first('thc') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <input type="number" name="cbd"  placeholder="CBD %" onkeypress="return isFloatNumber(this,event)" maxlength="5" value="{{old('cbd')}}">
                     </div>
                     @if(Session::has('errors'))
                     <span class="error">{{ Session::get('errors')->first('cbd') }}</span>
                     @endif
                  </div>
                  <div class="form_field_wrapper">
                     <div class="text_field_wrap">
                        <textarea name="product_desc" maxlength="500" cols="30" rows="10" placeholder="Description">{{old('product_desc')}}</textarea>
                     </div>
                     @if(Session::has('errors'))
                     <span class="error">{{ Session::get('errors')->first('product_desc') }}</span>
                     @endif
                  </div>
                  <div class="btn-group">
                     <button type="submit" class="custom-btn green-fill btn-effect">Submit</button>
                     <a class="ch-shd back line_effect" href="javascript:void(0)" onclick="location.reload()">No,Cancel</a>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<!-- Modal Ends -->
@endsection
@push('script')
<script src="{{asset('asset-admin/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('asset-admin/js/validation.js')}}"></script>
<script src="{{asset('asset-store/js/commonFunction-store.js')}}"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="{{asset('asset-store/css/jquery.ui.css')}}">
<script src="{{asset('asset-store/js/add-product.js')}}"></script>
<script>
   @if(Session::has('errors'))
           $('#addProductModal').modal('show');
   @endif
   
   
   $('.backstep2').on('click', function(){
       $('.addnewproduct-screen').css('display','block');
       $('.addnewproduct-screen-second').css('display','none');
   })
   
   $('.backpreviewbtn').on('click', function(){
       $('.addnewproduct-screen-third').css('display','none');
       $('.addnewproduct-screen-second').css('display','block');
   })
   $('.backproductbtn').on('click', function(){
       $('.addnewproduct-screen-second').css('display','none');
       $('.addnewproduct-screen').css('display','block');
   });
</script>

@endpush