@extends('User::includes.innerlayout')
@include('User::includes.navbar')


<!--header close-->
@section('content')


@yield('nav-bar')
@php 

if(empty($first_product)){
   $first_product=[];
}
if(empty($first_card_data)){
   $first_card_data=[];
}

 @endphp
<!--section list filter-->
<section class="inner_centerpanel">
   <div class="custom_inner_conatiner">
      <!--breadcrumb-->
      <div class="custom_container breadcrumb_wrapper">
         <ul>
            <li><a href="{{route('users.dashboard')}}">Home</a></li>
            <li><a href="{{route('users.product.category')}}">Product</a></li>
            <li><a href="{{route('users.category.product',['id'=>encrypt($productDetail['category']['id'])])}}">{{$productDetail['category_name'] ?? ''}}</a></li>
            <li><a href="javascript:void(0)">{{$productDetail['product_name'] ?? ''}}</a></li>
         </ul>
      </div>
      <!--breadcrumb close-->
      @if(!$productDetail['is_available_current_location'] || $productDetail['status']=='blocked' || $productDetail['category']['status']=='blocked')
         <div class="alert-warning-popup">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong>OOPS!</strong> This product is not available at your location.
          </div>
       @endif
  
      <!--Product Detail and Image-->
      <section class="product-image-details-wrap">
         <div class="custom_container">
            <div class="flex-row">
               <div class="product_slider_col">
                  <div class="imageslide-wrapper-col">
                     <div class="banner-wrapper-top">
                        <div id="sync1" class="owl-carousel owl-theme">
                           @if(!empty($productDetail['product_images']))
                           @foreach ($productDetail['product_images'] as $item)
                           <div class="item">
                              <figure class="event-image">
                                 <span class="mark_fav @if($productDetail['is_wishlisted']){{'active'}}@endif" data-id="{{$productDetail['id']}}"> </span>
                                 <img src="{{$item['file_url'] ?? ''}}" onerror="imgProductError(this);">
                              </figure>
                           </div>
                           @endforeach
                           @endif

                        </div>
                        <div class="thumb-images-wrapper">
                           <div id="sync2" class="owl-carousel owl-theme">
                              @if(!empty($productDetail['product_images']))
                              @foreach ($productDetail['product_images'] as $item)
                              <div class="item">
                                 <figure class="thumb-event-image">
                                    <img src="{{$item['file_url'] ?? ''}}" onerror="imgProductError(this);">
                                 </figure>
                              </div>
                              @endforeach
                              @endif
                           </div>

                        </div>
                     </div>
                  </div>

               </div>

               <div class="product_detail_col">
                  <div class="inner_wrapper">
                     <h1 class="product_name">{{$productDetail['product_name'] ?? ''}}</h1>
                     <span class="category_name">{{$productDetail['category_name'] ?? ''}}</span>
                     <span class="store_name">{{$productDetail['store_name'] ?? ''}}</span>
                     <hr class="pro-ruler">
                     <div class="product_review">
                        <div class="review_count">
                           <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$productDetail['rating'] ?? ''}}</span>
                           <span class="total">{{$productDetail['review_count'] ?? ''}} Reviews</span>
                        </div>
                     </div>
                     <div class="price">
                        <span class="discount_price" id="discount_price">
                               @if($first_product['offered_price']==0)
                               $ {{number_format($first_product['actual_price'] ?? 0, 2)}}
                               @else
                               $ {{number_format($first_product['offered_price'] ?? 0, 2)}}
                               @endif
                              
                        </span>
                        
                        
                        
                        <strike id="actual_price">@if($first_product['offered_price']>0) $ {{number_format($first_product['actual_price'] ?? 0, 2)}} @endif</strike>
                       

                     </div>
                     <div class="cannabis_content">
                        <span>THC {{$productDetail['thc_per'] ?? '0'}}% | CBD {{$productDetail['cbd_per'] ?? '0'}}%</span>
                     </div>
                     @if($first_product['total_stock'] ==0)
                        <span class="error" id="available-error">This product is unavailable</span>
                    @endif
                     <form action="{{route('user.add.data.to.cart')}}" id="submit_product_add_card" method="post">
                        @csrf
                        <input type="hidden" name="is_buy" value="0">
                        <div class="button_wrapper @if($first_product['total_stock']==0 || !$productDetail['is_available_current_location'] || $productDetail['status']=='blocked' || $productDetail['category']['status']=='blocked' )disabledbutton @endif" id="card-add-div">
                           @if(!empty($first_product))
                          
                               @if(!$first_card_data)
                                   <a href="javascript:void(0)" class="outline-btn btn-effect cart_btn" id="add_cart_button"> Add To Cart</a>
                               @endif

                               @if($first_card_data)
                                   <a href="{{route('user.show.cart.list')}}"class="outline-btn btn-effect cart_btn"> Go To Cart</a>
                               @endif
                          
                           @endif

                           <button type="button" class="green-fill-btn btn-effect green-fill" id="buy_now_btn" onclick="buyNowFun()">Buy Now</button>

                        </div>

                        <input type="hidden" name="product_id" value="{{$productDetail['id']}}">
                        <input type="hidden" name="store_id" id="selected_selling_store_id">
                        <input type="hidden" name="size" id="selected_selling_size">
                        <input type="hidden" name="unit" id="selected_selling_unit_id">
                        <input type="hidden" name="is_whislisted" value="{{$productDetail['is_wishlisted']}}">

                     </form>
                     <div class="product_share">
                        <ul>
                           <li>Share</li>

                           <li>
                              <a href="https://www.facebook.com/sharer/sharer.php?u={{route('users.product.detail',['id'=>encrypt($productDetail['id'])])}}" target="_blank" class="underDev">
                                 <img src="{{asset('asset-user-web/images/facebook-fill.svg')}}">
                              </a>
                           </li>


                           <li>
                              <a href="https://twitter.com/intent/tweet?text={{route('users.product.detail',['id'=>encrypt($productDetail['id'])])}}" target="_blank">
                                 <img src="{{asset('asset-user-web/images/twitter-fill.svg')}}">
                              </a>
                           </li>

                        </ul>
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

            <div class="flex-row align-items-center @if(!$productDetail['is_available_current_location'] || $productDetail['status']=='blocked' || $productDetail['category']['status']=='blocked')disabledbutton @endif">
               <div class="flex-col-sm-12">
                  <div class="select_stock">
                     <ul id="select_ul_items">
                        @if(!empty($productDetail['currentstock']))
                        @foreach ($productDetail['currentstock'] as $key => $item)
                        
                        <li class="@if($item['total_stock']==0)disabledbutton @endif">
                           <a href="javascript:void(0)" class="select_item @if($first_product['id'] == $item['id']) active @endif)"
                            data-size-unit="{{$item['quant_unit']}}" data-unit="{{$item['unit']}}" 
                            data-offered_price={{number_format($item['offered_price'], 2)}} data-actual_price={{number_format($item['actual_price'], 2)}} data-is_card_added={{$productDetail['is_cartAdded_data'][$item['id']]}}>
                              {{$item['quant_unit'] ?? '0'}}{{substr($item['unit'], 0, 1) ?? '0'}}
                           </a>
                           <span class="price">$ {{number_format($item['actual_price'] ?? '0',2)}} ({{$item['total_stock'] ?? '0'}} pac.)</span>
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
                  <h2 class="title-heading">Description</h2>
               </div>
               <div class="flex-col-sm-6 flex-col-xs-6 text-right">
               </div>
            </div>
            <div class="flex-row align-items-center">
               <div class="flex-col-sm-12">
                  <p class="commn_para m-t-b-30">
                     {{$productDetail['pro_desc'] ?? 'N/A'}}
                  </p>
               </div>
            </div>

            <div class="flex-row m-t-sm-30">
               <div class="flex-col-sm-6">

                  @if(!empty($productDetail['store']))
                  <div class="flex-row align-items-center">
                     <div class="flex-col-sm-6 flex-col-xs-6">
                        <h2 class="title-heading">Nearby Store</h2>
                     </div>
                     <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                     @if($productDetail['total_selling_stores']>1)  
                      <a href="{{route('users.product.near.store',['product_id'=>encrypt($productDetail['id'])])}}"><span class="view_more">View More</span></a>
                     @endif
                  </div>

                  </div>

                  @if(!empty($productDetail['store']))
                   
                  <div class="store-card-wrapper">
                     <div class="inner-wrapper card-effect">
                        <a href="{{route('users.store.detail',['id'=>encrypt($productDetail['store']['store_id'])])}}" target="_blank">
                           <figure class="store">
                              <img src="{{$productDetail['store']['store_images'][0] ?? ''}}" onerror="imgStoreError(this);">
                           </figure>
                        </a>
                        <div class="details">
                           <div class="details-in">
                                 <span class="mark_fav_store @if($productDetail['store']['is_bookmarked']){{'active'}}@endif" data-id="{{$productDetail['store']['store_id']}}"></span>
                                 <span class="store-name">
                                 <a href="{{route('users.store.detail',['id'=>encrypt($productDetail['store']['store_id'])])}}" target="_blank">{{$productDetail['store']['store_name'] ?? ''}}</a>
                              </span>
                              <span class="review">
                                 <div class="review_count">
                                    <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$productDetail['store']['rating'] ?? ''}} </span>
                                    <span class="total">{{$productDetail['store']['review_count'] ?? 'N/A'}} Reviews</span>
                                 </div>
                              </span>
                              <span class="location-address">
                                 {{$productDetail['store']['address'] ?? 'N/A'}}
                              </span>
                              <span class="location-address">{{$productDetail['store']['store_contact'] ?? 'N/A'}}</span>
                              <div class="text-right">
                                 <span class="distance">{{$productDetail['store']['distance'] ?? 'N/A'}}</span>
                              </div>
                           </div>
                           <div class="time_status">
                              <div class="time">
                                 Open @if (!empty($productDetail['store']['opening_timing']))
                                 {{date("g:i a", strtotime($productDetail['store']['opening_timing']))}}
                                 @endif
                                 •
                                 Closes @if (!empty($productDetail['store']['closing_timing']))
                                 {{date("g:i a", strtotime($productDetail['store']['closing_timing']))}}
                                 @endif
                              </div>
                              <div class="status productDetail @if($productDetail['store']['is_open']) opennow @else closenow @endif">
                                 @if($productDetail['store']['is_open'])
                                 Open Now
                                 @else
                                 Closed Now
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  @else
                  <div class="custom_container">

                     <figure class="nopro_found text-center">
                        <img src="{{asset('asset-user-web/images/noproduct.png')}}">
                     </figure>

                  </div>
                  @endif
               </div>
            </div>
            @endif
         
            @if (!empty($similarProduct['data']))
            <hr class="pro-ruler">

            <div class="flex-row align-items-center">
               <div class="flex-col-sm-6 flex-col-xs-6">
                     <h2 class="title-heading m-t-b-30">
                        Similar Products
                     </h2>
               </div>
               @if(count($similarProduct['data'])>1)
               <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                     <a href="{{route('users.category.product',['id'=>encrypt($productDetail['category']['id'])])}}">
                        <span class="view_more">View More</span>
                     </a>
               </div>
               @endif
            </div>
           
            <!--Smilar Products-->
            <div class="trending_slider">
               <div id="trending-slider-owl" class="owl-carousel">
                  <!--Repeat Card-->


                  @foreach ($similarProduct['data'] as $item)
                  <div class="item">
                     <div class="product_card">
                        <div class="product_card_inner_wrap card card">
                           <a href="{{route('users.product.detail',['id' =>encrypt($item['id']),'store_id' => encrypt($item['store_id'])])}}" target="_blank">

                           <figure class="product_img">
                              <img src="{{$item['product_images'][0] ?? ''}}" onerror="imgProductError(this);">
                           </figure>
                        </a>
                           <div class="product_srt_detail">
                              <div class="review_count">
                                 <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$item['rating'] ? number_format($item['rating'],1) :'0'}}</span>
                                 <span class="total">{{$item['review'] ?? 'N/A'}} Reviews</span>
                              </div>
                              <span class="pro_name">{{$item['product_name'] ?? 'N/A'}}</span>

                              <span class="pro_cateogry_name">{{$item['category_name'] ?? 'N/A'}}</span>
                              <span class="price">{{$item['price_range'] ?? 'N/A'}}</span>
                           </div>

                           <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}" target="_blank">
                              <div class="product_by">
                                       <figure class="pro_logo"><img src="{{$item['store_image'] ?? ''}}" onerror="imgStoreError(this);"></figure>
                                       <span class="pro_cmpny_name">{{$item['store_name'] ?? ''}}</span>   
                              </div>
                          </a>
                        
                        </div>
                     </div>
                  </div>
                  @endforeach

                  <!--Repeat Card Close-->
               </div>
            </div>

            @endif
            

     
            <!--Smilar Products Close-->
            <hr class="pro-ruler">
            <div class="flex-row align-items-center">
               <div class="flex-col-sm-6 flex-col-xs-6">
                  <h2 class="title-heading m-t-b-30">Reviews</h2>
               </div>
               <div class="flex-col-sm-6 flex-col-xs-6 text-right">
               </div>
            </div>
            
            <!--Review Progress-->
            <div class="flex-row align-items-center">
               <div class="flex-col-sm-3">
                  <div class="review-progress">
                     <ul>
                           @foreach ($productDetail['statisticsData'] as $key => $val)
                           <li>
                           <span class="rate-digit">{{$key}}</span>
                              <span class="progress_bar">
                                  <span class="pro-ruller" style="width:{{\App\Helpers\CommonHelper::getPercentageReview($val, $productDetail['ratingCount'])}}%;"></span>
                              </span>
                           </li> 
                           @endforeach
                     </ul>
                  </div>
               </div>
               <div class="flex-cols-sm-3">
                  <div class="total_review">
                     <div class="flex-row align-items-center">
                        <span class="digit">{{$productDetail['rating'] ?? '0'}}</span>
                        <span class="rate">
                           <ul>
                              <li></li>
                              <li></li>
                              <li></li>
                              <li></li>
                              <li></li>
                           <ul class="active" style="width:{{\App\Helpers\CommonHelper::getPercentageReview($productDetail['rating'], 5)}}%">
                                 <li></li>
                                 <li></li>
                                 <li></li>
                                 <li></li>
                                 <li></li>
                              </ul>
                           </ul>
                        </span>
                     </div>
                     <a href="javascript:void(0)" style="cursor: default" class="count">{{$productDetail['ratingCount'] ?? '0'}} Ratings and {{$productDetail['review_count'] ?? '0'}} Reviews</a>
                  </div>
               </div>
            </div>
          
            <!--Review Progress close-->
            <div id="scroller">
               @if(!empty($productReview))
                  <!--Review Progress Close--> 
                  
                  @foreach ($productReview['data'] as $item)
                  <div class="item-review">
                     <!--Repeat Review User-->
                     <div class="flex-row">
                           <div class="flex-col-sm-12">
                              <div class="reviewer-name-rate">
                              <span class="name">{{$item['user']['name'] ?? 'N/A'}}</span>
                                 <span class="reviewer-rate">
                                    <div class="review_count">
                                       <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}"> {{$item['rating'] ? number_format($item['rating'],1) :'0'}} </span>
                                    </div>
                                 </span>
                              </div>
                           <span class="date">{{$item['created_date'] ?? 'N/A'}}</span>
                              <p class="commn_para m-t-30"> 
                                {{$item['review'] ?? 'N/A'}} 
                              </p>
                           </div>
                        </div>
      
                        <hr class="pro-ruler">
                  </div>
                     <!--Repeat Review User Close-->
                     @endforeach
                     
      
               @endif
               @if(!empty($productReview['data']))
               <div class="scroller-status">
                    <div class="infinite-scroll-request loader-ellips">
                    </div>
                    <p class="infinite-scroll-last"></p>
                    <p class="infinite-scroll-error"></p>
              </div>
              @endif
            </div>
            <div class="pagination">
               <a href="@if($productReview['nextPage']){{route('users.product.detail',['id'=>encrypt($productDetail['id']),'store_id'=>encrypt($productDetail['store_id'])]).'?page='.$productReview['nextPage']}}@else javascript:void(0) @endif" class="next"></a>
            </div>


         </div>

      </section>
      <!--Product Detail and Image-->
   </div>
</section>


<form action="{{route('user.wishlist.action')}}" id="wish_list_submit_form" method="post">
   @csrf
   <input type="hidden" name="is_wishlisted" value="{{$productDetail['is_wishlisted'] ?? ''}}">
   <input type="hidden" name="product_id" value="{{$productDetail['id'] ?? ''}}">
</form>

<input type="hidden" name="remove_end_point" id="remove_end_point" value="{{url('/').config('userconfig.ENDPOINTS.HOME.REMOVE_WISH_LIST')}}">
<input type="hidden" name="bearerToken" id="bearerToken" value="{{$token ?? ''}}">
<input type="hidden" id="first_store_seller_id" value="{{empty($productDetail['store_id']) ? 0 : $productDetail['store_id']}}">
<input type="hidden" name="baseUrl" id="baseUrl" value="{{url('/')}}">
<input type="hidden" name="addwishlist" id="addwishlist" value="{{$addWishList}}">
<input type="hidden" name="removewishlist" id="removewishlist" value="{{$removewishlist}}">
<input type="hidden" name="go_to_cart" value="{{route('user.show.cart.list')}}">
<input type="hidden" id="clear_addto_cart" value="{{route('user.clear.cart.add')}}">
<input type="hidden" name="search_type" value="1">
<input type="hidden" name="addBookMark" id="addBookMark" value="{{$addBookMark}}">
<input type="hidden" name="removeBookMark" id="removeBookMark" value="{{$removeBookMark}}">
@endsection
@section('pagescript')
<script src="{{asset('asset-user/js/user-product-detail.js')}}"></script>
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
@endsection