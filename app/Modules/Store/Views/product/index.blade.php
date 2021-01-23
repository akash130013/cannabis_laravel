@extends("Store::layouts.master")
@section('content')
<!-- Header End -->

<form action="{{route('store.product.dashboard')}}" method="GET" id="formFilterId" name="filterName">

<div class="custom_container">
   <div class="tab_wrapper_seprate">
         <!-- menu-->
         <div class="head-nav tab_wrapper">
            <ul>
               <li><a href="javascript:void(0)" class="active">Products</a></li>
            <li><a href="{{route('store.request.product.list')}}">Requested Products</a></li>
            <li class="filter-li">
               <span class="filter_icon">
                  <img src="{{asset('asset-user-web/images/filter-3-fill.svg')}}">
               </span>
            </li>
            </ul>
         </div>
         <!-- menu close-->


            
      </div>
</div>

   <div class="full_custom_container">
      @include('Store::layouts.pending-alert')
      <div class="wrap-row-full">
         <div class="filter-col">
            <div class="white_wrapper  p-sm">
               <div class="flex-row align-items-center">
                  <div class="flex-col-sm-6 flex-col-xs-6">
                     <h2 class="title-heading">Filters</h2>
                  </div>

                  <span class="close_img close_filter">
                        <img src="{{asset('asset-store/images/close-line.svg')}}" />
                  </span>

               </div>
               @if(!empty($query))
               <a href="{{route('store.product.dashboard')}}"><span
                  class="clear_filter">Clear All</span></a>
               @endif
               <div class="filter_wrapper">
                  <!--Availability-->
                  <h3 class="filter-title">Availability</h3>
                  <div class="filter_option_wrapper">
                     <ul>
                        <li>
                           <div class="input-holder clearfix">
                              <input type="radio" name="stock" id="inactive" class="checkFilter" value="1"
                              @if(empty($query) || isset($query['stock']) && $query['stock']==1 ))
                              checked @endif>
                              <label for="inactive">All ({{$countArr['allCount']}})</label>
                           </div>
                        </li>
                        <li>
                           <div class="input-holder clearfix">
                              <input type="radio" name="stock" id="stock" class="checkFilter" value="2"
                              @if(isset($query['stock']) && $query['stock']==2 ) checked @endif >
                              <label for="stock">In Stock ({{$countArr['instock_count']}})</label>
                           </div>
                        </li>
                        <li>
                           <div class="input-holder clearfix">
                              <input type="radio" name="stock" id="outstock" class="checkFilter" value="3"
                              @if(isset($query['stock']) && $query['stock']==3 ) checked @endif>
                              <label for="outstock">Out of Stock ({{$countArr['outstock_count']}})</label>
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
                           <input type="text" id="search-box" data-id="product_category_search"
                              placeholder="Search by Category" name="product-search"
                              class="fltr-srch-input">
                           <button type="button" class="search-btn"><img class="togglesrch"
                              data-src-old="{{asset('asset-store/images/search-filter.svg')}}"
                              data-src="{{asset('asset-store/images/close-line.svg')}}"
                              src="{{asset('asset-store/images/search-filter.svg')}}">
                           </button>
                        </div>
                     </div>
                  </h3>
                  <!--Filter options main wrapper-->
                  <div class="filter_option_wrapper">
                     <!--filter show options-->
                     <ul class="list" id="product_category_search">
                        @if(!$category->isEmpty())
                        @foreach($category as $item)
                        <li>
                           <div class="input-holder acknowledge mt-23 clearfix">
                              <input type="checkbox" name="category[]" id="category_{{$item->id}}"
                              value="{{$item->id}}" class="checkFilter"
                              @if(isset($query['category']) && in_array($item->id,$query['category'])) checked @endif>
                              <label for="category_{{$item->id}}">{{$item->category_name}}</label>
                           </div>
                        </li>
                        @endforeach
                        @else
                        <li>No Category Available.</li>
                        @endif
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="listing_col">
            <div class="white_wrapper">
               <div class="flex-row flex-flow-mob align-items-center">
                  <div class="flex-col-sm-3 flex-col-xs-6">
                     <h2 class="title-heading">Products</h2>
                  </div>
                  <div class="flex-col-sm-9 flex-col-xs-6 text-right">
                     <div class="text-field-wrapper product-srch-col-header ui category search">
                        <div class="text-field-wrapper pro-srchbox ui icon input">
                           <input type="text" class="prompt" id="searchElementProduct" name="search"
                              value="{{$query['search'] ?? ''}}" placeholder="Search for product">
                           <i class="search icon"></i>
                           @if(Request::has('search') && !empty(Request::get('search')) )
                           <a href="{{route('store.product.dashboard')}}">
                           <img height="100"src="{{asset('asset-store/images/cross.svg')}}" class="closeProductMenu" alt="cross"></a>
                           @endif
                        </div>
                        <div class="results"></div>
                        <a class="m-l-20 btn-effect green-fill btn_sm m-l-20"
                           href="{{route('store.product.add-page')}}">Add Product</a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="white_wrapper">
               <div class="table-responsive">
                  <table id="example" class="list-table table table-striped table-bordered" cellspacing="0"
                     width="100%">
                     <thead>
                        <tr>
                           <th>S.No.</th>
                           <th>Availability</th>
                           <th>Stock level</th>
                           <th>Product Name</th>
                           <th>Product Category</th>
                           <th>Rating</th>
                           <th>Price Range</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $i=$pageinate['from'];
                        $j=0;
                        @endphp
                        @forelse($data as $row)
                        <tr>
                           <td>{{$i++}}</td>
                           <td>
                              @if($row->currentstock->sum('total_stock') > 0 )
                              <span class="">In Stock</span>
                              @else
                              <span class="td-alert">Out Of Stock</span>
                              @endif
                           </td>
                           <td>
                              {{ $row->currentstock->sum('total_stock') }}
                              {{--                                        {{$row->available_stock  ?? 'N/A'}}--}}
                           </td>
                           <td><span class="td-text-wrap">{{$row->product->product_name ?? 'N/A'}}</span></td>
                           <td><span class="td-text-wrap">{{$row->product->getCategory->category_name ?? 'N/A'}}</span></td>
                           <td><span class="rating_cannabis">{{ \App\Helpers\CommonHelper::fetchAvgRating($row->product_id, trans('Cannabies.RATING_TYPE.PRODUCT'), Auth::guard('store')->user()->id) }}({{ $reviewCount = \App\Helpers\CommonHelper::ratingReviewCount($row->product_id, trans('Cannabies.RATING_TYPE.PRODUCT'), true, Auth::guard('store')->user()->id) }} {{ $reviewCount == 0 ? 'review':'reviews'  }})</span></td>
                           <td>{{$row->price_range ?? 'N/A'}} </td>
                           <td>
                              @if($row->status == config('constants.STATUS.BLOCKED') || $row->product->getCategory->status == config('constants.STATUS.BLOCKED'))
                              <span class="td-alert">Inactive</span>
                              @if($row->product->getCategory->status == config('constants.STATUS.BLOCKED'))
                              <p class="small-text">(Category Blocked)</p>
                              @endif
                              @else
                              <span class="td-success">{{ ucfirst($row->status) }}</span>
                              @endif
                           </td>
                           <td class="user_info">
                              <span class="info_icon">
                              <img src="{{asset('asset-store/images/info.svg')}}">
                              </span>
                              <div class="user_info_window">
                                 <div class="inner_wrap">
                                    <div class="flex-row m-b-20 align-items-center">
                                       <div class="flex-col-sm-6 text-left">
                                          <h2 class="title-heading">Current Stock Level</h2>
                                          <div class="flex-row m-t-b-30">
                                             @if(!empty($row->currentstock))
                                             @foreach($row->currentstock as $item)
                                             <div class="flex-col-sm-4">
                                                <div class="form_field_wrapper">
                                                   <label class="form-label">{{$item->total_stock}}</label>
                                                   <span class="show-label">{{$item->quant_unit}} {{($item->unit)}} (${{number_format($item->price, 2)}})</span>
                                                </div>
                                             </div>
                                             @endforeach
                                             @endif
                                          </div>
                                       </div>
                                       <div class="flex-col-sm-6">
                                          <div class="button_wrapper text-right">
                                             <ul>
                                                <li>
                                                   @if(Auth::guard('store')->user()->admin_action != config('constants.STATUS.PENDING'))
                                                   @if($row->status == config('constants.STATUS.ACTIVE') )
                                                   <button type="button"
                                                      data-request="changestatus"
                                                      data-toChange="blocked"
                                                      data-status="{{config('constants.STATUS.BLOCKED') }}"
                                                      data-message="Do you want to deactivate the product ?"
                                                      data-url="{{route('store.list.status')}}"
                                                      data-id="{{$row->id}}"
                                                      data-type="product"
                                                      class="primary_btn green-fill outline-btn  btn_sm">
                                                   Deactivate
                                                   </button>
                                                   @else
                                                   <button type="button"
                                                      data-request="changestatus"
                                                      data-toChange="active"
                                                      data-status="{{config('constants.STATUS.ACTIVE') }}"
                                                      data-message="Do you want to activate the product?"
                                                      data-url="{{route('store.list.status')}}"
                                                      data-id="{{$row->id}}"
                                                      data-type="product"
                                                      class="primary_btn green-fill outline-btn  btn_sm">
                                                   Activate
                                                   </button>
                                                   @endif
                                                   <!-- <button type="button" class=" green-fill btn-effect outline-btn btn_sm activeInactiveBtn" data-id="{{$row->id}}">{{ucfirst($row->status)}}</button> -->
                                                   @endif
                                                </li>
                                                <a href="{{route('show.product.detail',['id'=>$row->id])}}">
                                                   <li>
                                                      <button type="button"
                                                         class="primary_btn btn-effect green-fill btn_sm">
                                                      View
                                                      Details
                                                      </button>
                                                   </li>
                                                </a>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="add_info">
                                       <span class="title">Additional Information</span>
                                       <p>{{$row->pro_desc ?? 'N/A'}}</p>
                                    </div>
                                 </div>
                              </div>
                           </td>
                        </tr>
                        @php  $j=$j+1  @endphp
                        @empty
                        <td colspan="8">No Product Found</td>
                        @endforelse
                     </tbody>
                  </table>
               </div>
            </div>
            <!--Pagenation-->
            <div class="flex-row">
               <div class="flex-col-sm-12 text-center">
                  <div class="pagenation">
                     @if(!empty($data))
                     {{$data->links()}}
                     @endif
                  </div>
               </div>
            </div>
            <!--Pagenation Close-->
         </div>
      </div>
   </div>
   <input type="hidden" name="status" value="{{isset($query['status']) ? $query['status']:1}}" id="status">
   <input type="hidden" value="{{$category->count()}}" id="totalCat">
</form>
<input type="hidden" id="url" value="{{route('store.list.status')}}">
<input type="hidden" id="pageUrl" value="{{route('store.product.dashboard')}}">
@push('script')
<script src="{{asset('asset-store/js/commonFunction.js')}}"></script>
<script src="{{asset('asset-store/js/Easy-jQuery-Client-side-List-Filtering-Plugin-list-search/js/list-search-min.js')}}"></script>
<script src="{{asset('asset-store/js/Semantic-UI-master/dist/semantic.min.js')}}"></script>
<script src="{{asset('asset-store/js/product.js')}}"></script>
<script src="{{asset('asset-store/js/request.js')}}"></script>
<script>
   $('.ui.search')
       .search({
           type: 'category',
           apiSettings: {
               url: "{{secure_url(route('store.product.list.search'))}}"+'?q={query}',
               onResponse: function (Response) {
                   
                   var
                       response = {
                           results: {}
                       }
                   ;
                   // translate GitHub API response to work with search
   
                   $.each(Response, function (index, item) {
   
                       if (typeof item.category != "undefined") {
   
                           var
                               language = item.category || 'Unknown';
                           maxResults = 30
                           ;
                           if (index >= maxResults) {
                               return false;
                           }
                           // create new language category
                           if (response.results[language] === undefined) {
                               response.results[language] = {
                                   name: language,
                                   results: []
                               };
                           }
                           // add result to category
   
                           response.results[language].results.push({
                               title: item.title,
                           });
   
   
                       }
   
                   });
   
   
                   return response;
               }
           },
           onSelect: function (result, response) {
              
               $("#searchElementProduct").val(result.title);
               $("#formFilterId").submit();
           }
       });
   
   
   $('body').on('keyup', '#search-box', function () {
   
       var searchString = $(this).val();
       var eleID = $(this).attr('data-id');
   
       $("#" + eleID + " li").each(function (index, value) {
           currentName = $(value).text()
           if (currentName.toUpperCase().indexOf(searchString.toUpperCase()) > -1) {
               $(value).show();
           } else {
               $(value).hide();
           }
   
       });
   
   
   });
   
   
</script>
@endpush
@endsection