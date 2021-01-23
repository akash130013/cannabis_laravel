@extends('User::includes.innerlayout')
@include('User::includes.navbar')
     
         <!--header close-->
      @section('content')
      <form action="{{route('users.product.store')}}" method="get" id="filterFormId">
      @yield('nav-bar')           <!--section list filter-->
         <section class="inner_centerpanel">
            <div class="custom_inner_conatiner">
               <div class="flex-row">
                  <div class="flex-col-sm-3">
                     <div class="flex-row align-items-center">
                        <div class="flex-col-sm-6 flex-col-xs-6">
                           <h2 class="title-heading m-t-b-30">Filters</h2>
                        </div>
                     </div>
                    
                 
                   @if(isset($query) && !empty($query))<a href="{{route('users.product.store')}}"><span class="clear_filter">Clear All</span></a>@endif
                     <div class="filter_wrapper">
                        <!--Availability-->
                        <h3 class="filter-title">Availability</h3>
                        <div class="filter_option_wrapper">
                           <ul>
                              <li>
                                 <div class="input-holder acknowledge mt-23 clearfix">
                                    <input type="radio" name="is_open" id="opened" class="all_filter" value="1" @if(isset($query['is_open']) && $query['is_open']==1) {{'checked'}} @endif>
                                    <label for="opened" class="checkbox_label">Open</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="input-holder acknowledge mt-23 clearfix">
                                    <input type="radio" name="is_open" id="closed" value="2" class="all_filter" @if(isset($query['is_open']) && $query['is_open']==2) {{'checked'}} @endif>
                                    <label for="closed" class="checkbox_label">Closed</label>
                                 </div>
                              </li>
                           </ul>
                        </div>
                        <!--Availability Close-->
                 
                        @include('User::filter.category')
                   
                     </div>
                  </div>
                  <div class="flex-col-sm-9">
                     <div class="flex-row align-items-center">
                        <div class="flex-col-sm-6 flex-col-xs-6">
                           <h2 class="title-heading m-t-b-30">Nearby Storefronts</h2>
                        </div>
                        
                     </div>
                  
                   
                     <div class="flex-row">
                        <div class="flex-col-sm-12" id="scroller">
                                @if (!empty($userNearStore['data']))
                                @foreach ($userNearStore['data'] as $item)
                           <!--Repeat Card-->
                              <div class="store-card-wrapper lg-card item">
                                    <div class="inner-wrapper card-effect">
                                    <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}" target="_blank">
                                       <figure class="store">
                                            <img src="{{$item['store_images'][0] ?? ''}}" onerror="imgStoreError(this);">
                                       </figure>
                                    </a>
                                       <div class="details">
                                          <div class="details-in">
                                             <span class="mark_fav_store @if($item['is_bookmarked']){{'active'}}@endif" data-id="{{$item['store_id']}}"></span>
                                             <span class="store-name">
                                                 <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}" target="_blank">{{$item['store_name'] ?? ''}}</a>
                                             </span>
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
                                             <span class="distance">{{$item['distance'] ?? 'N/A'}}</span>
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
                                 <!--Repeat Card Close-->
                                 @endforeach
                                 @else
                                 <div class="custom_container">
            
                                       <figure class="nopro_found text-center">
                                          <img src="{{asset('asset-user-web/images/no-product-found.png')}}">
                                       </figure>
                        
                                    </div>
                                  @endif 
                        </div>
                     </div>
                  <!--pagination -->
                  <div class="pagination">
                      <a href="@if($userNearStore['nextPage']) {{route('users.product.store').'?page='.$userNearStore['nextPage']}} @else javascript:void(0) @endif" class="next">Next</a>
                  </div>
                  @if (!empty($userNearStore['data']))
                  <div class="scroller-status">
                  <div class="infinite-scroll-request loader-ellips">
                    
                  </div>
                  <p class="infinite-scroll-last"></p>
                  <p class="infinite-scroll-error"></p>
                  </div>
                  @endif
  
            </div>
        

               </div>
            </div>
         </section>
      </form>
    
     

      <input type="hidden" name="bearerToken" id="bearerToken" value="{{$token}}">
      <input type="hidden" name="baseUrl" id="baseUrl" value="{{url('/')}}">
      <input type="hidden" name="addBookMark" id="addBookMark" value="{{$addBookMark}}">
      <input type="hidden" name="removeBookMark" id="removeBookMark" value="{{$removeBookMark}}">
      <input type="hidden" name="search_type" value="2">

        

@endsection
@section('pagescript')

<script src="{{asset('asset-user/js/list.nav.js')}}"></script>         
<script src="{{asset('asset-user/js/easynavigate.js')}}"></script>
<script src="{{asset('asset-user/js/paginating.js')}}"></script>
<script src="{{asset('asset-user/js/pagination.custom.js')}}"></script>
<script src="{{asset('asset-user/js/load.infinite.scroll.js')}}"></script>
<script src="{{asset('asset-user/js/user-filters.js')}}"></script> 
@endsection

   
  
