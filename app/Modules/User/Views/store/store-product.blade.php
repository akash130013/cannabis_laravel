@extends('User::includes.innerlayout')
@include('User::includes.navbar')


<!--header close-->
@section('content')


<form action="{{route('users.store.product',['id'=>encrypt($store_id)])}}" method="get" id="filterFormId">
@yield('nav-bar')

             <!--banner-->

             <section class="store-banner">
               
               <figure class="banner_img">
                  <img src="{{$storeDetail['banner_image_url']}}" alt="Kingdom" onerror="imgStoreError(this);"> 
                  <div class="banner_container store-banner-content">
                  <h1 class="store-banner-name"> {{$storeDetail['store_name'] ?? 'N/A'}}</h1>
                        <span class="review">
                                  <div class="review_count">
                                  <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$storeDetail['rating'] ?? '0'}}</span>
                                      <span class="total">{{$storeDetail['review_count']}} Reviews</span>
                                  </div>
                         </span>
                      </div>
                  </figure>
                
                  <!--repeat item close-->
                  
             </section>

            <!--banner close-->

            <!--Detail Navigation-->

            <section class="store-navigation text-center">
                  <div class="head-nav tab_wrapper text-center ">
                        <ul class="align-center">
                        <li><a href="{{route('users.store.detail',['id'=>encrypt($store_id)])}}">Detail</a></li>
                           <li><a href="javascript:void(0)" class="active">Products</a></li>
                           <li><a href="{{route('users.store.review',['id'=>encrypt($store_id)])}}">Reviews</a></li>
                        </ul>
                     </div>
            </section>

           <!--Detail Navigation Close--> 
          
             <section class="inner_centerpanel">
               <div class="custom_inner_conatiner">
                  <div class="flex-row">
                     <div class="flex-col-sm-3">
                        <div class="flex-row align-items-center">
                           <div class="flex-col-sm-6 flex-col-xs-6">
                              <h2 class="title-heading m-t-b-30">Filters</h2>
                           </div>
                        </div>
               @if(isset($query) && !empty($query))<a href="{{route('users.store.product',['id'=>encrypt($store_id)])}}"><span class="clear_filter">Clear All</span></a>@endif
                        <div class="filter_wrapper">
                           <!--Availability-->
                           <h3 class="filter-title">Availability</h3>
                           <div class="filter_option_wrapper">
                              <ul>
                                    <li>
                                          <div class="input-holder acknowledge mt-23 clearfix">
                                             <input type="radio" name="stock_availability" class="all_filter" id="in_stock" value="3" @if(isset($query['stock_availability']) && $query['stock_availability']==3) checked @endif>
                                             <label for="in_stock" class="checkbox_label">Out of Stock</label>
                                          </div>
                                       </li>
         
                                       <li>
                                          <div class="input-holder acknowledge mt-23 clearfix">
                                             <input type="radio" name="stock_availability" class="all_filter" id="out_stock" value="2" @if(isset($query['stock_availability']) && $query['stock_availability']==2)) checked @endif>
                                             <label for="out_stock" class="checkbox_label">In Stock</label>
                                          </div>
                                       </li>
                              </ul>
                           </div>
                           <!--Availability Close-->
                             <!-- Product Category-->
                             @include('User::filter.category')
                           <!-- Product Category Close-->
                         
                         
                           <!-- Stores Category Close-->
                        </div>
                     </div>
                     <div class="flex-col-sm-9">
                        <div class="flex-row align-items-center">
                           <div class="flex-col-sm-6 flex-col-xs-6">
                              <h2 class="title-heading m-t-b-30">@if(isset($category_id) && !empty($category_id)){{$storeProduct['data'][0]['category_name'] ?? ''}}@endif</h2>
                           </div>
                           <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                              @include('User::filter.sort-by')
                           </div>
                        </div>
                        <div class="flex-row" id="scrollerProduct">
                              @if(!empty($storeProduct['data']))
                              @foreach ($storeProduct['data'] as $item)
                          <div class="flex-col-sm-4 item-card">
                             <div class="product_card">
                                <div class="product_card_inner_wrap card-effect">
                                <figure class="product_img"> 
                                 @if(!empty($item['max_discount_percentage']) && isset($item['max_discount_percentage']))
                                 <span class="offer_tab">{{$item['max_discount_percentage'] ?? 0}}% Off</span>
                                 @endif  
                                 <span class="mark_fav @if($item['is_wishlisted']){{'active'}}@endif" data-id="{{$item['id']}}"></span>
                                 <a href="{{route('users.product.detail',['id'=>encrypt($item['id']),'store_id' => encrypt($store_id)])}}"  target="_blank"><img src="{{$item['product_images'][0]['file_url']}}" onerror="imgProductError(this);"></a>
                                   </figure>
                                   <div class="product_srt_detail">
                                      <div class="review_count">
                                      <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$item['rating'] ? number_format($item['rating'],1) :'0'}}</span>
                                         <span class="total">{{$item['review_count'] ?? ''}} Reviews</span>
                                      </div>
                                   <a href="{{route('users.product.detail',['id'=>encrypt($item['id']),'store_id' => encrypt($store_id)])}}"  target="_blank"> <span class="pro_name">{{$item['product_name'] ?? ''}}</span></a>
                                  <span class="pro_cateogry_name">{{$item['category_name']}}</span>
                                      <span class="price">{{$item['price_range']}}</span>
                                   </div>
                                   <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}">
                                    <div class="product_by">
                                       <figure class="pro_logo"><img src="{{$item['store_image']}}" onerror="imgStoreError(this);"></figure>
                                       <span class="pro_cmpny_name">{{$item['store_name'] ?? ''}}</span>
                                    </div>
                                 </a>
                                </div>
                             </div>
                          </div>
                           @endforeach

                           @if(!empty($storeProduct['data']))
                           <div class="scroller-status">
                                <div class="infinite-scroll-request loader-ellips">
                                </div>
                                <p class="infinite-scroll-last"></p>
                                <p class="infinite-scroll-error"></p>
                          </div>
                          @endif

                           @else
                     <div class="custom_container">

                           <figure class="nopro_found text-center">
                              <img src="{{asset('asset-user-web/images/noproduct.png')}}">
                           </figure>
            
                        </div>
                      @endif 

                        </div>
                        <div class="pagination">
                              <a href="@if(!empty($storeProduct['nextPage'])){{route('users.store.product',['id'=>encrypt($store_id)]).'?page='.$storeProduct['nextPage']}}@else javascript:void(0) @endif" class="next"></a>
                         </div>

                     </div>

                    

                  </div>
               </div>
            </section>
           </form>
      
      

      <input type="hidden" name="bearerToken" id="bearerToken" value="{{$token}}">
      <input type="hidden" name="baseUrl" id="baseUrl" value="{{url('/')}}">
      <input type="hidden" name="addwishlist" id="addwishlist" value="{{$addWishList}}">
      <input type="hidden" name="removewishlist" id="removewishlist" value="{{$removewishlist}}">
      <input type="hidden" name="search_type" value="2">
     
         <!--section list filter close-->
        @endsection

@section('pagescript')

<script src="{{asset('asset-user/js/list.nav.js')}}"></script>         
<script src="{{asset('asset-user/js/easynavigate.js')}}"></script>

<script src="{{asset('asset-user/js/paginating.js')}}"></script>
<script src="{{asset('asset-user/js/pagination.custom.js')}}"></script>
<script src="{{asset('asset-user/js/user-filters.js')}}"></script>
<script>
           
      $('#scrollerProduct').infiniteScroll({
         // options
         path: '.next',
         append: '.item-card',
         history: false,
         status: '.scroller-status',
         checkLastPage: true,
         hideNav: '.pagination'
      });   
           

            </script>
        @endsection