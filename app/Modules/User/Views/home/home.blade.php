@extends('User::includes.innerlayout')
@include('User::includes.navbar')
<!--header close-->
@section('content')
@yield('nav-bar')
<!--Explore Section-->
<section class="explore_section">
   <div class="custom_container">
      <div class="flex-row">
         <div class="flex-col-sm-6 flex-col-xs-6">
            <h2 class="title-heading m-t-b-30">Explore 420 Kingdom</h2>
         </div>
         <div class="flex-col-sm-6 flex-col-xs-6">
         </div>
      </div>
   </div>
   <div class="custom_container">
      <div class="product_category_slider">
         @if(!empty($categories['data']))
         <div id="product-category-owl" class="owl-carousel">
            <!--repeat item-->
            @foreach ($categories['data'] as $item)
            <div class="item">
               <a href="{{route('users.category.product',['id'=>encrypt($item['id'])])}}">
                  <div class="pro_category_card_sm">
                     <figure class="pro_category_img">
                        <img src="{{$item['thumb_url'] ?? $item['image_url']}}" onerror="imgProductError(this);">
                     </figure>
                     <span class="name">{{$item['category_name'] ?? ''}}</span>
                  </div>
               </a>
            </div>
            @endforeach
            <!--repeat item close-->
         </div>
         @else
         <figure class="not_found"><img src="{{asset('asset-user-web/images/no-category.png')}}"></figure>
         @endif
      </div>
   </div>
</section>
<!--Explore Section close-->
<!--Trending section-->
<section class="section-pad">
   <div class="custom_container">
      <div class="flex-row align-items-center">
         <div class="flex-col-sm-6 flex-col-xs-6">
            <h2 class="title-heading m-t-b-30">Trending Products</h2>
         </div>
         @if(!empty($trendingProduct['data']))
         <div class="flex-col-sm-6 flex-col-xs-6 text-right">
            <a href="{{route('users.product.trending')}}"><span class="view_more">View More</span></a>
         </div>
         @endif
      </div>
      <div class="flex-row">
         <div class="flex-col-sm-12">
            <div class="trending_slider">
               @if(!empty($trendingProduct['data']))     
               <div id="trending-slider-owl" class="owl-carousel">
                  <!--Repeat Card-->
                  @foreach ($trendingProduct['data'] as $item)
                  <div class="item">
                     <div class="product_card">
                        <div class="product_card_inner_wrap card card">
                           <figure class="product_img">
                              @if(!empty($item['max_discount_percentage']) && isset($item['max_discount_percentage']))
                              <span class="offer_tab">{{$item['max_discount_percentage'] ?? 0}}% Off</span>
                              @endif
                              <span class="mark_fav @if($item['is_wishlisted']){{'active'}}@endif" data-id="{{$item['id']}}"></span>
                              <a href="{{route('users.product.detail',['id' =>encrypt($item['id']),'store_id' => encrypt($item['store_id'])])}}" target="_blank">
                              <img src="{{$item['product_images'][0]['file_url'] ?? ''}}" onerror="imgProductError(this);">
                              </a>
                           </figure>
                           <div class="product_srt_detail">
                              <div class="review_count">
                                 <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$item['rating'] ? number_format($item['rating'],1) :'0'}} </span>
                                 <span class="total">{{$item['review_count'] ?? ''}} Reviews</span>
                              </div>
                              <a href="{{route('users.product.detail',['id' =>encrypt($item['id']),'store_id' => encrypt($item['store_id'])])}}" target="_blank">
                              <span class="pro_name">{{$item['product_name'] ?? ''}}</span>
                              </a>
                              <span class="pro_cateogry_name">{{$item['category_name'] ?? ''}}</span>
                              <span class="price">{{$item['price_range'] ?? ''}}</span>
                           </div>
                           <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}" target="_blank">
                              <div class="product_by">
                                 <figure class="pro_logo"><img src="{{$item['store_image']}}" onerror="imgStoreError(this);"></figure>
                                 <span class="pro_cmpny_name">{{$item['store_name'] ?? ''}}</span>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  <!--Repeat Card Close-->
               </div>
               @else
               <figure class="not_found"><img src="{{asset('asset-user-web/images/noproduct-sm.png')}}"></figure>
               @endif
            </div>
         </div>
      </div>
   </div>
</section>
<!--Trending section close-->
<!--Nearby Store-->
<section class="nearby_store">
   <div class="custom_container">
      <div class="flex-row align-items-center">
         <div class="flex-col-sm-6 flex-col-xs-6">
            <h2 class="title-heading m-t-b-30">Nearby Storefronts</h2>
         </div>
         @if (!empty($userNearStore['data']))
         <div class="flex-col-sm-6 flex-col-xs-6 text-right">
            <a href="{{route('users.product.store')}}"><span class="view_more">View More</span></a>
         </div>
         @endif
      </div>
      <div class="flex-row">
         <div class="flex-col-sm-12">
            <div class="nearby_slider">
               @if (!empty($userNearStore['data']))
               <div id="nearby-slider-owl" class="owl-carousel">
                  <!--Repeat Store Card--> 
                  @foreach ($userNearStore['data'] as $item)
                  <div class="item">
                     <div class="store-card-wrapper">
                        <div class="inner-wrapper card-effect">
                           <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}" target="_blank">
                              <figure class="store">
                                 <img src="{{$item['store_images'][0] ?? ''}}" onerror="imgStoreError(this);">
                              </figure>
                           </a>
                           <div class="details">
                              <div class="details-in">
                                 <span class="mark_fav_store @if($item['is_bookmarked']){{'active'}}@endif" data-id="{{$item['store_id']}}"></span>
                                 <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}" target="_blank"> <span class="store-name">{{$item['store_name'] ?? ''}}
                                 </span>
                                 </a>
                                 <span class="review">
                                    <div class="review_count">
                                       <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$item['rating'] ? number_format($item['rating'],1) :'0'}}</span>
                                       <span class="total">{{$item['review_count'] ?? ''}} Reviews</span>
                                    </div>
                                 </span>
                                 <span class="location-address">
                                 {{$item['address'] ?? ''}}
                                 </span>
                                 <span class="location-address">{{$item['contact_number'] ?? ''}}</span>
                                 <div class="text-right">
                                    <span class="distance">{{$item['distance'] ?? ''}}</span>
                                 </div>
                              </div>
                              <div class="time_status">
                                 <div class="time"> 
                                    Open @if (!empty($item['opening_timing']))
                                    {{date("g:i a", strtotime($item['opening_timing']))}}
                                    @endif
                                    •
                                    Closes @if (!empty($item['closing_timing']))
                                    {{date("g:i a", strtotime($item['closing_timing']))}}
                                    @endif
                                 </div>
                                 <div class="status @if($item['is_open'])opennow @else closenow @endif">
                                    @if($item['is_open'])
                                    Open Now
                                    @else
                                    Closed Now
                                    @endif
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  <!--Repeat Store Card Close-->
               </div>
               @else
               <figure class="not_found"><img src="{{asset('asset-user-web/images/no-store-img.png')}}"></figure>
               @endif
            </div>
         </div>
      </div>
   </div>
</section>
<!--Nearby Store Close-->
<!--Trending by Category section-->
<section class="section-pad">
   <div class="custom_container">
      <div class="flex-row align-items-center">
         <div class="flex-col-sm-6 flex-col-xs-12">
            <h2 class="title-heading m-t-b-30">Trending By Category</h2>
         </div>
      </div>
      @php
      $i=1;
      @endphp
      @if(!empty($categoryProduct))
      @foreach ($categoryProduct as $key => $value)
      <div class="flex-row align-items-center">
         <div class="flex-col-sm-6 flex-col-xs-6">
            <h2 class="sub-title-heading m-t-b-30">{{$key}}</h2>
            <hr class="sub-heading-hr">
         </div>
         <div class="flex-col-sm-6 flex-col-xs-6 text-right">
            <a href="{{route('users.category.product',['id'=>encrypt($value[0]['category_id'])])}}"><span class="view_more">View More</span></a>
         </div>
         <div class="flex-col-sm-12">
            <div class="trending_slider">
               <div id="trending_{{$i}}" class="owl-carousel">
                  <!--Repeat Card-->
                  @if(!empty($value))
                  @foreach ($value as $item)
                  <div class="item">
                     <div class="product_card">
                        <div class="product_card_inner_wrap card">
                           <figure class="product_img">
                              @if(!empty($item['max_discount_percentage']) && isset($item['max_discount_percentage']))
                              <span class="offer_tab">{{$item['max_discount_percentage'] ?? 0}}% Off</span>
                              @endif
                              <span class="mark_fav @if($item['is_wishlisted']){{'active'}}@endif" data-id="{{$item['id']}}"></span>
                              <a href="{{route('users.product.detail',['id' =>encrypt($item['id']),'store_id' => encrypt($item['store_id'])])}}" target="_blank">
                              <img src="{{$item['product_images'][0]['file_url'] ?? ''}}" onerror="imgProductError(this);">
                              </a>
                           </figure>
                           <div class="product_srt_detail">
                              <div class="review_count">
                                 <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$item['rating'] ? number_format($item['rating'],1) :'0'}}</span>
                                 <span class="total">{{$item['review_count'] ?? ''}} Reviews</span>
                              </div>
                              <a href="{{route('users.product.detail',['id' =>encrypt($item['id']),'store_id' => encrypt($item['store_id'])])}}" target="_blank"><span class="pro_name">{{$item['product_name'] ?? ''}}</span></a>
                              <span class="pro_cateogry_name">{{$item['category_name'] ?? ''}}</span>
                              <span class="price">{{$item['price_range'] ?? ''}}</span>
                           </div>
                           <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}" target="_blank">
                              <div class="product_by">
                                 <figure class="pro_logo"><img src="{{$item['store_image']}}" onerror="imgStoreError(this);"></figure>
                                 <span class="pro_cmpny_name">{{$item['store_name'] ?? ''}}</span>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  @endif
                  <!--Repeat Card Close-->
               </div>
            </div>
         </div>
      </div>
      @php
      $i++;
      @endphp
      @endforeach 
      @else
      <figure class="not_found"><img src="{{asset('asset-user-web/images/no-category.png')}}"></figure>
      @endif
   </div>
   <input type="hidden" name="totalCat" id="totalCat" value="{{$i}}">
   <input type="hidden" name="search_type" value="1">
   <input type="hidden" name="bearerToken" id="bearerToken" value="{{$token}}">
   <input type="hidden" name="baseUrl" id="baseUrl" value="{{url('/')}}">
   <input type="hidden" name="addBookMark" id="addBookMark" value="{{$addBookMark}}">
   <input type="hidden" name="removeBookMark" id="removeBookMark" value="{{$removeBookMark}}">
   <input type="hidden" name="addwishlist" id="addwishlist" value="{{$addWishList}}">
   <input type="hidden" name="removewishlist" id="removewishlist" value="{{$removewishlist}}">
</section>
<!--Trending by Category Close section-->
<!--footer-->
@endsection
@section('pagescript')
<script src="{{asset('asset-store/js/add-store-location.js')}}"></script>
<script>
   var total=$("input[name=totalCat]").val();
   
   var showNav = $('#product-category-owl').find('.item').length > 3 ? true : false;
   
   for (let index = 1; index <total ; index++) {
     $('#trending_'+index).owlCarousel({
         items: 3,
         loop: false,
         autoplay: false,
         dots:true,
         nav: showNav,
         navText: ["<img src='../images/testi-left-arrow.png'", "<img src='../images/testi-right-arrow.png'"],
         responsive: {        
              0: {            
                    items: 1,       
              }, 
              375: {
                    items: 1, 
              },         
              600: {            
                    items: 2,        
              },        
              1000: {
              items: 3,        
              }
           }
   });
      
   }
   
   
   
   
   
   
      
</script>
@endsection