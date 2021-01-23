@extends("Store::layouts.master")
@section('content')
<!-- Header End -->
<!-- Internal Container -->
<div class="custom_container">
   @include('Store::layouts.pending-alert')
   <div class="flex-row mob-row-reverse">
      <div class="product_slider_col">
         <figure class="event-image">
            @if($product->product->getImage)
            @foreach($product->product->getImage as $value)
            <img src="{{$value->file_url}}" alt="product">
            @endforeach
            @endif
         </figure>
      </div>
      <div class="product_detail_col">
         <div class="inner_wrapper">
            <h1 class="product_name">{{ $product->product->product_name }}</h1>
            <span class="category_name">{{$product->product->getCategory->category_name}}</span>
            <span class="store_name">THC: {{ $product->product->thc_per }}% CBD: {{ $product->product->cbd_per }}%</span>
            <hr class="pro-ruler">
            <div class="flex-row">
               <div class="flex-col-sm-6">
                  <div class="price">
                     <span class="discount_price">{{$product->price_range}}</span>
                     <span class="store_name">Price Range</span>
                  </div>
               </div>
               <div class="flex-col-sm-6">
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="custom_container">
   <div class="flex-row align-items-center">
      <div class="flex-col-sm-6 flex-col-xs-6">
         <h2 class="title-heading">Quantity & Price</h2>
      </div>
      <div class="flex-col-sm-6 flex-col-xs-6 text-right">
      </div>
   </div>
   <div class="flex-row">
      <div class="flex-col-sm-12">
         <div class="flex-col-sm-12 m-t-b-30">
            <form id="final_product_submision">
               <div class="row">
                  <div class="col-md-8 col-sm-8 col-xs-12">
                     <div class="quantitypricepanel">
                        @if($product->currentstock)
                        <?php $productArr = json_decode($product->product->quantity_json); ?>
                        <input type="hidden" name="quant_json_arr" id="json_arr_data"
                           value="{{$product->product->quantity_json}}">
                        @foreach($product->currentstock as $key => $val)
                        <div id="copy_div">
                           <div class="form-group">
                              <input type="number" maxlength="10" name="price[price][]"
                                 data-validate="required" onkeypress="validate(event)" value="{{$val->price}}"
                                 class=" pl-210 searchproduct1"
                                 placeholder="Enter actual price (in $)">
                              <input type="number" maxlength="5" name="price[offered][]"
                                 onkeypress="validate(event)" value="{{$val->offered_price}}"
                                 class=" quantity hidden" placeholder="Enter offered price">
                              <input type="number" maxlength="5" name="price[packet][]"
                                 onkeypress="validate(event)" value="{{$val->total_stock}}"
                                 class=" quantity" placeholder="Enter quantity">
                              @if($key)
                              <img src="{{asset('asset-store/images/delete.svg')}}"
                                 alt="delete" class="prdctdelete" title="Delete">
                              @endif
                              <input type="hidden" id="hidden_unit_{{$val->id}}"
                                 name="price[unit][]" value="{{$val->unit}}">
                              <input type="hidden" id="hidden_unit_quant_{{$val->id}}"
                                 name="price[quant_unit][]" value="{{$val->quant_unit}}">
                              <div class="selectpanel">
                                 <select id="quantity_data" name="price[choice][]"
                                    class="selectedIndex sel-quant select_drop">
                                 @foreach($productArr as $v)
                                 <option
                                 @if($val->quant_unit == $v->quant_units)
                                 selected="selected"
                                 @endif
                                 data-hidden-quant="hidden_unit_quant_{{$val->id}}"
                                 data-hidden-unit="hidden_unit_{{$val->id}}"
                                 value="{{$v->unit}}" data-unit="{{$v->unit}}"
                                 data-quant_unit="{{$v->quant_units}}"
                                 class="selectedIndex">{{$v->quant_units.' '.$v->unit}}
                                 </option>
                                 @endforeach
                                 </select>
                                <label for="quantity_data"> <img src="{{asset('asset-store/images/droparrow1.svg')}}"
                                    class="dropmenu" alt="drop down menu"> 
                                 </label>
                              </div>
                           </div>
                        </div>
                        @endforeach
                        @endif
                        <div id="add_more_div">
                        </div>
                        <p class="add_more" id="add_more_button">Add More</p>
                     </div>
                  </div>
               </div>
               <input type="hidden" name="product_id" value="{{$product->product_id}}" id="search_product_id">
               <input type="hidden" name="id" value="{{$product->id}}" id="searchproduct_id">
               <input type="hidden" name="store_id" value="{{ Auth::guard('store')->user()->id }}">
         </div>
      </div>
   </div>
</div>
<div class="custom_container">
   <hr class="pro-ruler">
      <div class="flex-row align-items-center">
         <div class="flex-col-sm-6 flex-col-xs-6">
            <h2 class="title-heading">Additional Information</h2>
         </div>
         <div class="flex-col-sm-6 flex-col-xs-6 text-right">
         </div>
         <div>
         </div>
      </div>
      <div class="flex-row align-items-center">
         <div class="flex-col-sm-12 m-t-b-30 ">
            <textarea cols="30" name="pro_desc" rows="5"
            class="add_description"
               placeholder="Write here..." maxlength="500">{{$product->pro_desc}}</textarea>
         </div>
      </div>
   </form>
   <!-- 
      <div class="flex-row align-items-center">
         <div class="flex-col-sm-12 m-t-b-30">
      
         </div>
      </div>
      -->
      <div class="flex-row">
         <div class="flex-col-sm-12">
            <div class="button_wrapper text-right preview">
               <ul>
                  <li><a class=" green-fill outline-btn" href={{route('store.product.dashboard')}}>Cancel</a> </li>
                  <li><button class="primary_btn green-fill btn-effect" id="final_submit_data">Save</button> </li>
               </ul>
            </div>
         </div>
      </div>
</div>
<!-- <div class="internal-container product">
   <div class="cb-tabsBody">
       <div class="tab-content">
           <div id="products" class="container-fluid tab-pane active">
               <div class="editproductdetailwrapper">
                   <div class="form-container">
                       <div class="editProductWrapper">
                           <div class="product-header">
                               <h2>Edit Product</h2>
   
                           <div class="editPrdctForm">
                               <div class="productPreview">
                                   <div class="row">
                                       <div class="col-md-8 col-sm-8 col-xs-12">
                                           <div class="prdctHeader">
                                               <h3></h3>
                                               <h6></h6>
                                               <p></p>
                                           </div>
                                           <div class="prdctDescp">
                                               <div class="prdctLeftName">
                                                   <h4></h4>
                                                   <p>Price Range</p>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-4 col-sm-4 col-xs-12">
                                           <figure class="producttView">
   
                                           </figure>
                                       </div>
                                   </div>
   
   
   
   
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   </div>
   </div>
   </div>
   
   
   
   -->
@endsection
@push('script')
<script src="{{asset('asset-store/js/edit-product.js')}}"></script>
@endpush