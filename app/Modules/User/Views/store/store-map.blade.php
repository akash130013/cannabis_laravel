@extends('User::includes.innerlayout')
@include('User::includes.navbar')
     @section('css')
        
     @endsection
         <!--header close-->
      @section('content')
      <form action="{{route('users.store.map')}}" method="get" id="filterFormId">
      @yield('nav-bar')  
<!--section list filter-->
         <section class="inner_centerpanel">
             <span class="filter_icon list_icon">
                        <img src="/asset-user-web/images/list-check.svg">
                     </span>
               <div class="store_map_container">
                     <div class="store_list_col">

                     <span class="close_filter close_list"><img src="/asset-user-web/images/close-card.svg"></span>

                    

                        <!--Filter UI-->
                        <div class="flex-row align-items-center m-t-30 map-Fliter">
                           <div class="flex-col-sm-3">
                              <h3 class="title-heading"> 
                                    Filters
                              </h3>
                           </div>
                           
                           <div class="flex-col-sm-3">
                                 <div class="selectpciker select-picker-wrap store-filter-select">
                                       <select class="selectpicker" name="is_open" onchange="javascript:this.form.submit()">
                                          <option value="" selected>All</option>
                                          <option value="1" @if(isset($query['is_open']) && $query['is_open']==1) {{'selected'}} @endif>Open</option>
                                          <option value="2" @if(isset($query['is_open']) && $query['is_open']==2) {{'selected'}} @endif>Closed</option>
                                       </select>
                                    </div>
                           </div>
                           <div class="flex-col-sm-3">
                                 <div class="selectpciker select-picker-wrap store-filter-select">
                                       <select class="selectpicker" name="rating" onchange="javascript:this.form.submit()">
                                          <option value="" selected>All Rating</option>
                                          <option value="1" @if(isset($query['rating']) && $query['rating']==1) {{'selected'}} @endif>1 *& above</option>
                                          <option value="2" @if(isset($query['rating']) && $query['rating']==2) {{'selected'}} @endif>2 *& above</option>
                                          <option value="3" @if(isset($query['rating']) && $query['rating']==3) {{'selected'}} @endif>3 *& above</option>
                                          <option value="4" @if(isset($query['rating']) && $query['rating']==4) {{'selected'}} @endif>4 *& above</option>
                                       </select>
                                    </div>
                           </div>   

                           <div class="flex-col-sm-3">
                                 <div class="selectpciker select-picker-wrap store-filter-select">
                                       <select class="selectpicker" name="category" onchange="javascript:this.form.submit()">
                                          <option value="" selected>All Category</option>
                                          @if(!empty($categories['data']))
                                          @foreach ($categories['data'] as $item)
                                             <option value="{{$item['id']}}" @if(isset($query['category']) && $query['category']==$item['id']) {{'selected'}} @endif>{{$item['category_name']}}</option>
                                          @endforeach
                                          @endif
                                       </select>
                                    </div>
                           </div> 

                        </div>
                      
                        @if (!empty($userNearStore['data']))
                        <!--Filter UI Close-->
                        <div class="store_card_col_inwrap" id="top_scroll">
                                <div id="scroller">
                                <!--repeat store card -->
                                            @foreach ($userNearStore['data'] as $item)
                                                <div class="store-card-wrapper item" id="div_{{$item['store_id']}}">
                                                    <div class="inner-wrapper card-effect">
                                                        <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}" target="_blank">
                                                        <figure class="store">
                                                            <img src="{{$item['store_images'][0] ?? ''}}" onerror="imgStoreError(this);">
                                                        </figure>
                                                        </a>
                                                        <div class="details">
                                                         <span class="mark_fav_store @if($item['is_bookmarked']){{'active'}}@endif" data-id="{{$item['store_id']}}"></span>
                     
                                                            <div class="details-in">
                                                               <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}" target="_blank">
                                                                  <span class="store-name">
                                                                  {{$item['store_name'] ?? ''}}
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
                                <!--repeat store card Close -->
                                            @endforeach
                                       
                                </div>
                        <div class="scroller-status">
                                <div class="infinite-scroll-request loader-ellips">
                         </div>
                        <p class="infinite-scroll-last"></p>
                        <p class="infinite-scroll-error"></p>
                        </div>

                        </div>
                        @else
                        <figure class="not_found"><img src="{{asset('asset-user-web/images/no-store-img.png')}}"></figure>
                     @endif

 <!--pagination -->
                <div class="pagination">
                       @if($userNearStore['nextPage'])
                          <a href="{{route('users.store.map').'?page='.$userNearStore['nextPage']}}" class="next">Next</a>
                       @endif
                    </div>

                               
                     </div>

                    
                     <div class="map_col" id="googleMap">
                     
                     </div>

               </div>
         </section>
         <!--section list filter close-->
        
      </form>
      <input type="hidden" class="json_data_store" value="{{json_encode($userNearStore['data'])}}">
      <input type="hidden" name="bearerToken" id="bearerToken" value="{{$token}}">
      <input type="hidden" name="baseUrl" id="baseUrl" value="{{url('/')}}">
      <input type="hidden" name="addBookMark" id="addBookMark" value="{{$addBookMark}}">
      <input type="hidden" name="removeBookMark" id="removeBookMark" value="{{$removeBookMark}}">
      <input type="hidden" name="userLat" value="{{$userDetail->lat}}">
      <input type="hidden" name="userLng" value="{{$userDetail->lng}}">

      <input type="hidden" name="search_type" value="2">
     
@endsection

@section('pagescript')
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="{{asset('asset-user/js/store-map.js')}}"></script>
@endsection