@extends("Store::layouts.master")
@section('content')
@push('css')
<link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/owl.carousel.min.css')}}">
@endpush
<!-- Header End -->
<!-- Internal Container -->
<div class="custom_container">
   @include('Store::layouts.pending-alert')
   <div class="flex-row">
      <div class="product_slider_col">
         <div class="imageslide-wrapper-col">
            <div class="banner-wrapper-top">
               <div id="sync1" class="owl-carousel owl-theme">
                  @if($product->product && $product->product->getImage)
                  @foreach ($product->product->getImage as $item)
                  <div class="item">
                     <figure class="event-image">
                        <img src="{{$item->file_url}}" onerror="imgProductError(this);">
                     </figure>
                  </div>
                  @endforeach
                  @endif
               </div>
               <div class="thumb-images-wrapper">
                  <div id="sync2" class="owl-carousel owl-theme">
                     @if($product->product && $product->product->getImage)
                     @foreach ($product->product->getImage as $item)
                     <div class="item">
                        <figure class="thumb-event-image">
                           <img src="{{$item->file_url}}" onerror="imgProductError(this);">
                        </figure>
                     </div>
                     @endforeach
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
      {{-- {{dd($product->product->getCategory->category_name)}} --}}
      <div class="product_detail_col">
         <div class="inner_wrapper">
            <h1 class="product_name">{{$product->product->product_name ?? 'N/A'}}</h1>
            <span class="category_name">{{$product->product->getCategory->category_name ?? 'N/A'}}</span>
            {{-- <span class="store_name">asfjasf</span> --}}
            <hr class="pro-ruler">
            <div class="flex-row">
               <div class="flex-col-sm-6">
                  <div class="price">
                     <span class="discount_price">{{$product->price_range}}</span>
                  </div>
                  <div class="cannabis_content">
                     <span>THC: {{$product->product->thc_per}}% CBD: {{$product->product->cbd_per}}%</span>
                  </div>
               </div>
               <div class="flex-col-sm-6"> 
                  @if(Auth::guard('store')->user()->admin_action == 'pending')
                  <button class="primary_btn green-fill outline-btn  btn_sm">Inactive</button>
                  @else
                  @if($product->status == config('constants.STATUS.ACTIVE') )
                  <button type="button" data-request="changestatus" data-toChange="blocked" data-status="{{config('constants.STATUS.BLOCKED') }}" data-message="Are you sure you want to deactivate this product. ?" data-url="{{route('store.list.status')}}" data-id="{{$product->id}}" data-type="product" class="primary_btn green-fill outline-btn  btn_sm">Deactivate</button>
                  @else
                  <button type="button" data-request="changestatus" data-toChange="active" data-status="{{config('constants.STATUS.ACTIVE') }}" data-message="Are you sure you want to activate this product ?" data-url="{{route('store.list.status')}}" data-id="{{$product->id}}" data-type="product"  class="primary_btn green-fill outline-btn  btn_sm"> Activate</button>
                  @endif  
                  @endif
               </div>
            </div>
            <div class="product_review">
               <div class="review_count">
                  <span class="rating"><img src="{{asset('asset-store/images/xsm-leaf.png')}}">{{$avgRating ?? 0}}</span>
                  <span class="total">{{$reviewCount ?? 0}} Reviews</span>
               </div>
            </div>
            <input type="hidden" id="stockId" value="{{$product->id}}">
            <input type="hidden" id="product_list_url" value="{{route('store.product.dashboard')}}">
            <input type="hidden" id="product_delete_url" value="{{route('store.product.delete')}}">
            <div class="button_wrapper">
               <a href="{{route('store.edit.product',['id' => $product->id])}}" ><button class="green-fill btn-effect btn-sm">Edit Product</button></a>
               {{-- <button class="green-fill outline-btn btn-sm m-l-20" id="delete_product">Delete Product</button>--}}
            </div>
         </div>
      </div>
   </div>
</div>
<div class="custom_container">
   <div class="flex-row align-items-center">
      <div class="flex-col-sm-6 flex-col-xs-6">
         <h2 class="title-heading m-t-b-30">Available Stock</h2>
      </div>
      <div class="flex-col-sm-6 flex-col-xs-6 text-right">
      </div>
   </div>
   <div class="flex-row align-items-center">
      <div class="flex-col-sm-12">
         <div class="select_stock">
            <ul>
               @if($product->currentstock)
               @foreach($product->currentstock as $val)
               <li>
                  <a href="javascript:void(0)">
                  {{$val->quant_unit}}{{\App\Helpers\CommonHelper::getProductUnit($val->unit)}}
                  </a>
                  <span class="price">${{number_format($val->price)}} ({{$val->total_stock}} pac.)</span>
               </li>
               @endforeach
               @endif
            </ul>
         </div>
      </div>
   </div>
   <hr class="pro-ruler">
   <div class="flex-row align-items-center">
      <div class="flex-col-sm-6 flex-col-xs-6">
         <h2 class="title-heading">Additional Information</h2>
      </div>
      <div class="flex-col-sm-6 flex-col-xs-6 text-right">
      </div>
   </div>
   <p class="commn_para m-t-b-30">
      {{$product->pro_desc}}  
   </p>
   <hr class="pro-ruler">
</div>
@if($ratingReviewCount > 0)
<div class="custom_container ">
   <div class="flex-row align-items-center">
      <div class="flex-col-sm-3">
         <div class="review-progress">
            <ul>
               @foreach ($statsticData as $key => $val)
               <li>
                  <span class="rate-digit">{{$key}}</span>
                  <span class="progress_bar">
                  <span class="pro-ruller" style="width:{{\App\Helpers\CommonHelper::getPercentageReview($val, $ratingCount)}}%;"></span>
                  </span>
               </li>
               @endforeach
            </ul>
         </div>
      </div>
      <div class="flex-cols-sm-3">
         <div class="total_review">
            <div class="flex-row align-items-center">
               <span class="digit-driver">{{$avgRating ?? 0}}</span>
               <span class="rate">
                  <ul>
                     <li></li>
                     <li></li>
                     <li></li>
                     <li></li>
                     <li></li>
                     <ul class="active" style="width:{{\App\Helpers\CommonHelper::getPercentageReview($avgRating,5)}}%;">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                     </ul>
                  </ul>
               </span>
            </div>
            <a href="javascript:void(0)" style="cursor: default" class="count">{{$ratingCount ?? 0}} @if(isset($ratingCount) && $ratingCount==1) Rating @else Ratings @endif and {{$reviewCount ?? 0}} @if(isset($reviewCount) && $reviewCount==1) Review @else Reviews @endif </a>
         </div>
      </div>
   </div>
   <!--Review Progress close-->
   <div id="scroller">
      @if(!empty($ratings))
      <!--Review Progress Close--> 
      @foreach ($ratings as $item)
      <div class="item-review">
         <!--Repeat Review User-->
         <div class="flex-row">
            <div class="flex-col-sm-12">
               <div class="reviewer-name-rate">
                  <span class="name">{{$item->user->name ?? 'N/A'}}</span>
                  <span class="reviewer-rate">
                     <div class="review_count">
                        <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}"> {{$item->rate ?? 'N/A'}} </span>
                     </div>
                  </span>
               </div>
               <span class="date">{{$item->created_at ?? 'N/A'}}</span>
               <p class="commn_para m-t-30"> 
                  {{$item->review ?? 'N/A'}}
               </p>
            </div>
         </div>
         <hr class="pro-ruler">
      </div>
      <!--Repeat Review User Close-->
      @endforeach
      @endif
      @if(!empty($ratings))
      <div class="scroller-status">
         <div class="infinite-scroll-request loader-ellips">
         </div>
         <p class="infinite-scroll-last"></p>
         <p class="infinite-scroll-error"></p>
      </div>
      @endif
   </div>
   <div class="pagination">
      <a href="{{$ratings->nextPageUrl()}}" class="next"></a>
   </div>
</div>
@endif
<!-- Modal -->
<div class="modal fade" id="deleteModal" role="dialog">
   <div class="modal-dialog statusDialogue">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close modal-close" data-dismiss="modal">
            <img src="{{asset('asset-store/images/close-card.svg')}}"></button>
            {{-- 
            <h4 class="modal-title">Delete Product</h4>
            --}}
         </div>
         <div class="modal-body">
            <div class="modal-padding">
               <p>Do you really want to delete this product ?</p>
               <input type="hidden" id="newStatus">
               <input type="hidden" id="Id">
               <input type="hidden" id="type" value="product">
               <div class="m-t-30">
                  <button type="button" class="btn custom-btn green-fill btn-effect deleteBtn">Yes, Delete</button>
                  <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal">No, Cancel</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal Ends -->
@endsection
@push('script')
<script src="{{asset('asset-store/js/product-detail.js')}}"></script>
<script src="{{asset('asset-store/js/commonFunction.js')}}"></script>
<script src="{{asset('asset-store/js/request.js')}}"></script>
<script src="{{asset('asset-user-web/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('asset-user-web/js/app.js')}}"></script>
<script>
   $('#scroller').infiniteScroll({
      // options
      path: '.next',
      append: '.item-review',
      history: false,
      status: '.scroller-status',
      checkLastPage: true,
      hideNav: '.pagination'
   });
    
          @if(Session::has('success') && Session::get('success')['message']==config('constants.SINGLE_STORE_RULE_MSG'))
    
             swal({
                   text: "{{Session::get('success')['message']}}",
                   type: "info",
                   closeOnClickOutside: false,
                   buttons:["Cancel","Clear cart and Add"]
             }).then((isConfirm) => {
                      if (isConfirm) {
                         window.location.href=$("#clear_addto_cart").val();
                      }
                })
            
           @endif
    
    
</script>
@endpush