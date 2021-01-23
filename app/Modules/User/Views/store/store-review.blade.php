@extends('User::includes.innerlayout')
@include('User::includes.navbar')


<!--header close-->
@section('content')


<form action="{{route('users.store.review',['id'=>encrypt($storeDetail['store_id'])])}}" method="get" id="filterFormId">
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
                  
             </section>

            <!--banner close-->

            <!--Detail Navigation-->

            <section class="store-navigation text-center">
                  <div class="head-nav tab_wrapper text-center ">
                        <ul class="align-center">
                                <li><a href="{{route('users.store.detail',['id'=>encrypt($storeDetail['store_id'])])}}">Detail</a></li>
                                <li><a href="{{route('users.store.product',['id'=>encrypt($storeDetail['store_id'])])}}" >Products</a></li>
                                <li><a href="javascript:void(0)" class="active">Reviews</a></li>
                        </ul>
                     </div>
            </section>

           <!--Detail Navigation Close--> 
        

           <div class="custom_container">

            <!--Review Progress-->
             <div class="flex-row align-items-center m-t-30">
               <div class="flex-col-sm-3">
                  <div class="review-progress">
                     <ul>

                     @foreach ($storeDetail['statisticsData'] as $key => $val)
                           <li>
                           <span class="rate-digit">{{$key}}</span>
                              <span class="progress_bar">
                                  <span class="pro-ruller" style="width:{{\App\Helpers\CommonHelper::getPercentageReview($val, $storeDetail['ratingCount'])}}%;"></span>
                                  {{-- <span class="pro-ruller" style="width:{{\App\Helpers\CommonHelper::getPercentageReview($val, $storeDetail['ratingCount'])}}%;"></span> --}}

                                 </span>
                           </li> 
                     @endforeach
                       
                     </ul>
                  </div>
               </div>
         
               <div class="flex-cols-sm-3">
                  <div class="total_review">
                     <div class="flex-row align-items-center">
                     <span class="digit">{{$storeDetail['rating'] ?? '0'}}</span>
                        <span class="rate">
                           <ul>
                              <li></li>
                              <li></li>
                              <li></li>
                              <li></li>
                              <li></li>
                              <ul class="active" style="width:{{\App\Helpers\CommonHelper::getPercentageReview($storeDetail['rating'], 5)}}%;">
                                 

                                 <li></li>
                              <li></li>
                              <li></li>
                              <li></li>
                              <li></li>
                              </ul>
                           </ul>
                        </span>
                     </div>
                     <a href="javascript:void(0)" style="cursor: default" class="count">{{$storeDetail['ratingCount'] ?? 'N/A'}} Ratings and {{$storeDetail['review_count'] ?? 'N/A'}} Reviews</a>
                  </div>
               </div>

               {{-- <div class="flex-col-sm-6 text-right">
                     <div class="select">
                           Sort By: <span> Price High  to Low</span>
                              <span class="sort-downArrow"></span>
                           <ul>
                              <li><label class="dropdown" for="new">What's New</label> <input type="radio" name="sortby" id="new" value="new"></li>

                              <li><label class="dropdown" for="lowtohigh">Price: Low To High</label> <input type="radio" name="sortby" id="lowtohigh" value="new"></li>
                           </ul>
                           
                        </div>
               </div> --}}

            </div>

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
                                 <span class="rating"><img src="{{asset('asset-user-web/images/xsm-leaf.png')}}"> {{$item['rating'] ?? 'N/A'}} </span>
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
            <a href="@if($productReview['nextPage']){{route('users.store.review',['id'=>encrypt($storeDetail['store_id'])]).'?page='.$productReview['nextPage']}}@else javascript:void(0) @endif" class="next"></a>
         </div>
               
           </div> 
</form>
<input type="hidden" name="search_type" value="2">
@endsection
@section('pagescript')
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
</script>
@endsection
        