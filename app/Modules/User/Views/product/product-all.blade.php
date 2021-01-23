@extends('User::includes.innerlayout')
@include('User::includes.navbar')

     
         <!--header close-->
      @section('content')
   <form action="{{route('users.product.category')}}" method="get" id="filterFormId">
      @yield('nav-bar')        
       <!--section list filter-->
         <section class="inner_centerpanel">
            <div class="custom_inner_conatiner">
               <div class="flex-row">
                  <div class="flex-col-sm-3">
                  <div class="mob_filter">
                        <span class="close_filter"><img src="/asset-user-web/images/close-card.svg"></span>
                     <div class="flex-row align-items-center">
                        <div class="flex-col-sm-6 flex-col-xs-6">
                           <h2 class="title-heading m-t-b-30">Filters</h2>
                        </div>
                     </div>
                     
                    
                     @if(isset($query) && !empty($query))<a href="{{route('users.product.category')}}"><span class="clear_filter">Clear All</span></a>@endif

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
                        <!---Product category closed -->
                    
                        <!--Filter store--> 
                        @include('User::filter.store')
                        <!--Filter store--> 
                  
                     </div>

                   </div>
                  </div>
                  <div class="flex-col-sm-9  flex-col-xs-12">
                     <div class="flex-row align-items-center">
                        
                           <div class="flex-col-sm-6 flex-col-xs-6">
                                 <h2 class="title-heading m-t-b-30">Products</h2>
                           </div>

                        <div class="flex-col-sm-6 flex-col-xs-6 text-right mob_filter_select">
                        <span class="filter_icon">
                              <img src="{{asset('asset-user-web/images/filter-3-fill.svg')}}">
                           </span>
                             
                              @include('User::filter.sort-by')

                        </div>
                     </div>
                
                
                     <div class="flex-row" id="scroller">

                   @if(!empty($productCategory['data']))
                   @foreach ($productCategory['data'] as $item)
                  
                        <div class="flex-col-sm-4 item">
                           <div class="product_card">
                              <div class="product_card_inner_wrap card-effect">
                              <figure class="product_img">
                                 @if(!empty($item['max_discount_percentage']) && isset($item['max_discount_percentage']))
                                 <span class="offer_tab">{{$item['max_discount_percentage'] ?? 0}}% Off</span>
                                 @endif

                                  <span class="mark_fav @if($item['is_wishlisted']){{'active'}}@endif" data-id="{{$item['id']}}">
                                  </span>
                                
                                    <a href="{{route('users.product.detail',['id' =>encrypt($item['id']),'store_id' => encrypt($item['store_id'])])}}" target="_blank">

                                     <img src="{{$item['product_images'][0]['file_url']}}" onerror="imgProductError(this);">
                                   </a>  
                                 </figure>
                                 <div class="product_srt_detail">
                                    <div class="review_count">
                                    <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}">{{$item['rating'] ? number_format($item['rating'],1) :'0'}}</span>
                                       <span class="total">{{$item['review_count'] ?? ''}} Reviews</span>
                                    </div>
                                    <a href="{{route('users.product.detail',['id' =>encrypt($item['id']),'store_id' => encrypt($item['store_id'])])}}" target="_blank">
                                         <span class="pro_name">{{$item['product_name'] ?? ''}}</span>
                                     </a>
                                <span class="pro_cateogry_name">{{$item['category_name']}}</span>
                                    <span class="price">{{$item['price_range']}}</span>
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
                     @else
                     <div class="custom_container">

                           <figure class="nopro_found text-center">
                              <img src="{{asset('asset-user-web/images/noproduct.png')}}">
                           </figure>
            
                        </div>
                      @endif  

                      @if(!empty($productCategory['data']))
                      <div class="scroller-status">
                           <div class="infinite-scroll-request loader-ellips">
                           </div>
                           <p class="infinite-scroll-last"></p>
                           <p class="infinite-scroll-error"></p>
                     </div>
                     @endif

                     </div>
                  </div>
                      <!--pagination -->
                     <div class="pagination">
                        <a href="@if($productCategory['nextPage']){{route('users.product.category').'?page='.$productCategory['nextPage']}}@else javascript:void(0) @endif" class="next"></a>
                        {{-- <a href="{{$productCategory['next_page_url']}}" class="next">Next</a> --}}
                     
                     </div>
                            
               </div>
            </div>
         </section>
      </form>
      <input type="hidden" name="bearerToken" id="bearerToken" value="{{$token}}">
      <input type="hidden" name="baseUrl" id="baseUrl" value="{{url('/')}}">
      <input type="hidden" name="addwishlist" id="addwishlist" value="{{$addWishList}}">
      <input type="hidden" name="removewishlist" id="removewishlist" value="{{$removewishlist}}">

      <input type="hidden" name="search_type" value="1">
    


         <!--section list filter close-->
@endsection

@section('pagescript')

<script src="{{asset('asset-user/js/list.nav.js')}}"></script>         
<script src="{{asset('asset-user/js/easynavigate.js')}}"></script>
<script src="{{asset('asset-user/js/paginating.js')}}"></script>
<script src="{{asset('asset-user/js/pagination.custom.js')}}"></script>
<script src="{{asset('asset-user/js/user-filters.js')}}"></script>

<script>
     
   //   $('ul.list').find('li.special').appendTo('ul.list');

   $('#scroller').infiniteScroll({
         // options
         path: '.next',
         append: '.item',
         history: false,
         status: '.scroller-status',
         checkLastPage: true,
         hideNav: '.pagination'
      });


         </script>
             
         @endsection
         <!--footer-->
        