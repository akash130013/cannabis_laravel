@extends('User::includes.innerlayout')
@include('User::includes.navbar')
    
         <!--header close-->
      @section('content')
      <form action="{{route('users.product.near.store',['product_id'=>encrypt($product_id)])}}" method="get" id="filterFormId">
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
                    
                   @if(isset($query) && !empty($query))<a href="{{route('users.product.near.store',['product_id'=>encrypt($product_id)])}}"><span class="clear_filter">Clear All</span></a>@endif
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
                        <!-- Product Category-->
                        <h3 class="filter-title">
                           Product Category
                           <div class="search srch-filter">
                              <div class="input_filter_search">
                                 <input type="text" placeholder="Search" class="fltr-srch-input product-search" data-id="list_navigation">
                                 <button type="button" class="search-btn"><img class="togglesrch" src="{{asset('asset-user-web/images/search-filter.svg')}}"></button>
                              </div>
                           </div>
                        </h3>
                        <!--Filter options main wrapper-->   
                        {{-- <div class="filter_option_wrapper">
                           <!--filter show options-->
                           <ul id="list_navigation" class="list">
                                 @if(!empty($categories['data']))
                                    @foreach ($categories['data'] as $item)
                                    <li>
                                       <div class="input-holder acknowledge mt-23 clearfix">
                                          <input type="checkbox" name="category[]" class="all_filter" id="category_{{$item['id']}}" value="{{$item['id']}}" @if(isset($query['category']) && in_array($item['id'],$query['category'])) {{'checked'}} @endif>
                                          <label for="category_{{$item['id']}}" class="checkbox_label">{{$item['category_name']}}</label>
                                       </div>
                                    </li>
                                 @endforeach
                              @endif
                              
                           </ul>
                           <!--filter show options-->
                     
                           <!--Full Filter view close-->
                        </div> --}}

                        <div class="filter_option_wrapper">
                           <!--filter show options-->
                           <ul class="list" id="list_navigation">


                           <!-- seleted list  -->


                           @if(!empty($categories['data']) && !empty($query['category_id']))
                                   @foreach ($categories['data'] as $key => $item)

                                       @if(in_array($item['id'],$query['category_id']))
                                    
                                          <li>
                                             <div class="input-holder acknowledge mt-23 clearfix">
                                             <input type="checkbox"  name="category_id[]"  class="all_filter category_id_{{$item['id']}}" id="category_{{$item['id']}}" value="{{$item['id']}}" @if(isset($query['category_id']) && in_array($item['id'],$query['category_id'])) data-cid="{{$item['id']}}" checked @endif>
                                                <label for="category_{{$item['id']}}" class="checkbox_label">{{$item['category_name'] ?? ''}}</label>
                                             </div>
                                          </li>

                                       @endif
                                 
                                    @endforeach
                              @endif



                          

                              @if(!empty($categories['data']))
                                 <?php $i = 1; $categoryCount = empty($query['category_id']) ? 0 : count(array_unique($query['category_id'])); ?>
                                   @foreach ($categories['data'] as $key => $item)

                                     @if($i <= (5 - $categoryCount))

                                          @if(empty($query['category_id']))
                                          <?php ++$i;?>
                                       
                                             <li>
                                                <div class="input-holder acknowledge mt-23 clearfix">
                                                <input type="checkbox"  name="category_id[]"  class="all_filter category_id_{{$item['id']}}" id="category_{{$item['id']}}" value="{{$item['id']}}" @if(isset($query['category_id']) && in_array($item['id'],$query['category_id'])) data-cid="{{$item['id']}}" checked @endif>
                                                   <label for="category_{{$item['id']}}" class="checkbox_label">{{$item['category_name'] ?? ''}}</label>
                                                </div>
                                             </li>

                                          @else
                                           @if(!in_array($item['id'],$query['category_id']))
                                             <?php ++$i;?>

                                             <li>
                                                <div class="input-holder acknowledge mt-23 clearfix">
                                                <input type="checkbox"  name="category_id[]"  class="all_filter category_id_{{$item['id']}}" id="category_{{$item['id']}}" value="{{$item['id']}}" @if(isset($query['category_id']) && in_array($item['id'],$query['category_id'])) data-cid="{{$item['id']}}" checked @endif>
                                                   <label for="category_{{$item['id']}}" class="checkbox_label">{{$item['category_name'] ?? ''}}</label>
                                                </div>
                                             </li>

                                             @endif

                                          @endif

                                       @endif
                                 
                                    @endforeach
                              @endif
                           </ul>
                           
                           @if(isset($i) && !empty(count($categories['data'])-$i-$categoryCount+1))
                           <a href="javascript:void(0)" class="show-more-filter">+{{count($categories['data'])-$i-$categoryCount+1}} More</a>
                           @endif
                           <!--filter show options-->
                         
                           <!--Full Filter-->
                           <div class="full_filter">
                              <div class="full-filter-header">
                                 <div class="flex-row align-items-center">
                                    <div class="flex-col-sm-6">
                                       <div class="text-field-wrapper pro-srchbox">    
                                          <input type="text" id="full_filter_search" data-id="list_navigation_full_filter" placeholder="Search">
                                          <span class="detect-icon"><img src="{{asset('asset-user-web/images/search-line.svg')}}" alt="detect"></span>   
                                       </div>
                                    </div>
                                    <div class="flex-col-sm-6 text-right">
                                       <span class="close-full-filter">Close</span>
                                    </div>
                                 </div>
                              </div>
                             
                              <div class="grid">
                                 <ul id="list_navigation_full_filter">
                                    <!-- <span class="alpha-title">A</span> -->
                                @if(!empty($categories['data']))
                                @foreach ($categories['data'] as $key => $item)
                                   
                                       <li class="@if(isset($query['category_id']) && in_array($item['id'],$query['category_id'])) {{'special'}} @endif">
                                             <div class="input-holder acknowledge mt-23 clearfix">
                                                      <input type="checkbox"  name="category_id[]" class="all_filter category_id_{{$item['id']}}" id="category_id_{{$item['id']}}" value="{{$item['id']}}" @if(isset($query['category_id']) && in_array($item['id'],$query['category_id'])) data-cid="{{$item['id']}}" checked @endif>
                                                      <label for="category_id_{{$item['id']}}" class="checkbox_label">{{$item['category_name'] ?? ''}}</label>
                                             </div>
                                       </li>
                                 

                                 @endforeach
                              @endif
                                   
                                 </ul>
                              </div>
                           </div>
                           <!--Full Filter view close-->
                        </div>
                        <!--Filter options main wrapper--> 

                       
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
                                    <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}">
                                       <figure class="store">
                                            <img src="{{$item['store_images'][0] ?? ''}}" onerror="imgStoreError(this);">
                                       </figure>
                                    </a>
                                       <div class="details">
                                          <div class="details-in">
                                             <span class="mark_fav_store @if($item['is_bookmarked']){{'active'}}@endif" data-id="{{$item['store_id']}}"></span>
                                             <span class="store-name">
                                             <a href="{{route('users.store.detail',['id'=>encrypt($item['store_id'])])}}">{{$item['store_name'] ?? ''}}</a>
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
                                          <img src="{{asset('asset-user-web/images/noproduct.png')}}">
                                       </figure>
                        
                                    </div>
                                  @endif 
                        </div>
                     </div>
                  <!--pagination -->
                  <div class="pagination">
                      <a href="@if($userNearStore['nextPage']) {{route('users.product.near.store',['product_id'=>encrypt($product_id)]).'?page='.$userNearStore['nextPage']}} @else javascript:void(0) @endif" class="next">Next</a>
                  </div>

                  <div class="scroller-status">
                  <div class="infinite-scroll-request loader-ellips">
                   
                  </div>
                  <p class="infinite-scroll-last"></p>
                  <p class="infinite-scroll-error"></p>
                  </div>
  
            </div>
        

               </div>
            </div>
         </section>
      </form>
         <input type="hidden" name="bearerToken" id="bearerToken" value="{{$token}}">
         <input type="hidden" name="baseUrl" id="baseUrl" value="{{url('/')}}">
         <input type="hidden" name="addBookMark" id="addBookMark" value="{{$addBookMark}}">
         <input type="hidden" name="removeBookMark" id="removeBookMark" value="{{$removeBookMark}}">
         <input type="hidden" name="search_type" value="1">

         <!--section list filter close-->

@endsection
@section('pagescript')

<script src="{{asset('asset-user/js/list.nav.js')}}"></script>         
<script src="{{asset('asset-user/js/easynavigate.js')}}"></script>
<script src="{{asset('asset-user/js/paginating.js')}}"></script>
<script src="{{asset('asset-user/js/pagination.custom.js')}}"></script>
<script src="{{asset('asset-user/js/load.infinite.scroll.js')}}"></script>
<script>
  
  $("body").on('click','.mark_fav',function(){

            var baseUrl=$("#baseUrl").val();
            var token=$("#bearerToken").val();
            var id=$(this).data('id');
            var pageUrl=baseUrl+$("#addBookMark").val()+"/"+id;
            var $this = $(this);
            if($(this).hasClass("active")==true){
                pageUrl=baseUrl+$("#removeBookMark").val()+"/"+id;
            }
           
            
                $.ajax({
                url: pageUrl,
                type: 'get',
                // Fetch the stored token from localStorage and set in the header
                headers: {"Authorization": token},
                success : function (params) {     
                   
                 $this.toggleClass('active');

                }
               });
         });



         $(document).ready(function(){
    
      
   //  $("#list_navigation").easyPaginate({
   //      paginateElement: 'li',
   //      elementsPerPage: 5,
   //      effect: 'climb',
   //      lastButton : false,
   //      firstButton :false,
   //      prevButton: false,
   //      nextButton : false
   //  });
   //  $("#list_navigation").listnav({
   //      includeNums: false,
   //  });


   //  $("#list-navigation-store").easyPaginate({
   //      paginateElement: 'li',
   //      elementsPerPage: 5,
   //      effect: 'climb',
   //      lastButton : false,
   //      firstButton :false,
   //      prevButton: false,
   //      nextButton : false
   //  });
   //  $("#list-navigation-store").listnav({
   //      includeNums: false,
   //  });
  

});

$('body').on('keyup','.product-search',function(){
var searchString = $(this).val();
var eleID = $(this).attr('data-id');

$("#"+ eleID + " li").each(function(index, value) {
    currentName = $(value).text()
    if( currentName.toUpperCase().indexOf(searchString.toUpperCase()) > -1) {
       $(value).show();
    } else {
        $(value).hide();
    }
    
});
});


</script>
@endsection

   
  
