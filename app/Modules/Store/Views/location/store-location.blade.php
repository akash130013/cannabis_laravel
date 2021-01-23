@extends("Store::layouts.master")
@section('content')
<!-- Header End -->
<!-- Internal Container -->
<div class="custom_container">
   @include('Store::layouts.pending-alert')
   <div class="white_wrapper">
      <div class="">
          <div class="flex-col-sm-12 product-srch-col-header">
             <div class="text-field-wrapper location-srchbox">
                  <input type="text" class="locationSearch" id="address" placeholder="Search by zip code">
                  <button class="btn custom-btn green-fill getstarted" hidden id="searchMapButton">Search</button>
                  <span class="detect-icon"><i class="search icon"></i></span>
               </div>
     
          <button class="primary_btn green-fill btn_sm btn-effect" id="submit_store_location">Add Location</button>
      </div>
     
      @if(Session::has('errors'))
               <span class="error fadeout-error">Please select a valid address</span>
         @endif
</div>
   </div>
   <form action="{{route('submit.store.delivery.location.list')}}" id="submit_hidden_params" method="post">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <input type="hidden" name="street_number" value="" id="street_number">
      <input type="hidden" name="locality" value="" id="locality">
      <input type="hidden" name="postal_code" value="" id="postal_code">
      <input type="hidden" name="country" value="" id="country">
      <input type="hidden" name="state" value="" id="administrative_area_level_1">
      <input type="hidden" name="lat" value="" id="lat">
      <input type="hidden" name="lng" value="" id="lng">
      <input type="hidden" name="address" value="" id="hiddenaddress">
   </form>
</div>
<div class="custom_container">
   <div class="white_wrapper">
      <div class="flex-row align-items-center">
         <div class="flex-col-sm-6 flex-col-xs-6">
            <h2 class="title-heading">Location</h2>
         </div>
         <div class="flex-col-sm-6 flex-col-xs-6 text-right">
            <!--search-->
            <form action="{{route('store.location.list')}}" method="GET" id="formFilterId" name="filterName">
               <div class="product-srch-col-header ui search">
                  <div class="text-field-wrapper pro-srchbox ui icon input">
                     <input class="prompt" id="searchElementProduct" type="text" name="search" value="{{Request::get('search')}}" placeholder="Search by area....">
                     <i class="search icon"></i>
                     @if(Request::has('search'))
                     <a href="{{route('store.location.list')}}"><img src="{{asset('asset-store/images/cross.svg')}}" class="closeProductMenu" alt="cross"></a>
                     @endif
                  </div>
                  <div class="results"></div>
               </div>
            </form>
         </div>
         <!--search close-->
      </div>
   </div>
</div>
@if($deliveryaddress->isNotEmpty())
<div class="custom_container">
   <div class="flex-row row-wrap" id="scroller">
      @foreach($deliveryaddress as $key => $val)
      <div class="flex-col-sm-4 location-item">
         <div class="white_wrapper p-sm location-detail">
            <div class="detail-header">
               <h5>Zipcode</h5>
               <div class="store-status">
                  <button class="btn_sm status-btn {{$val->status == 'active'?'active':'inactive'}}" >
                  @if($val->status == 'active')
                  Active
                  @else
                  Inactive
                  @endif
                  </button>
                  <span class="status-icon active"> </span>
               </div>
            </div>
            <h4>{{$val->zip_code}}</h4>
            <div>
               <h5>Area</h5>
               <p>{{$val->formatted_address}}</p>
            </div>
            <div>
               <button class="active-btn click-btn status-button" data-msg="{{$val->status == 'active'?'Deactivate':'Activate'}}" data-lang="{{$val->status == 'active'?trans('Store::home.inactive_location_status_popup'):trans('Store::home.active_location_status_popup')}}" data-href="{{route('update.store.delivery.location.status',['id'=>$val->encrypt_id,'deleted'=>false])}}">
               @if($val->status == 'active')
               Deactivate
               @else
               Activate
               @endif
               </button>
               <a href="#" class="delete-button line_effect"  data-href="{{route('update.store.delivery.location.status',['id'=>$val->encrypt_id,'deleted'=>true])}}">Delete</a>
            </div>
         </div>
      </div>
      @endforeach
      @if(!empty($deliveryaddress))
      <div class="scroller-status">
         <div class="infinite-scroll-request loader-ellips">
         </div>
         <p class="infinite-scroll-last"></p>
         <p class="infinite-scroll-error"></p>
      </div>
      @endif
   </div>
   <div class="pagination text-center">
      <a href="{{$deliveryaddress->nextPageUrl()}}" class="next"></a>
   </div>
</div>
@else
<div class="custom_container">
   <p class="commn_para text-center">No Record found </p>
</div>
@endif
</form>
<input type="hidden" value="{{route('store.ajax.get.zip.code')}}" id="url_search_zip_code">
@push('script')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{asset('asset-store/js/Semantic-UI-master/dist/semantic.min.js')}}"></script>
<script src="{{asset('asset-store/js/maps.service.zipcode.js')}}"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script src="{{asset('asset-store/js/add-store-location.js')}}"></script>
<script src="{{asset('asset-store/js/Easy-jQuery-Client-side-List-Filtering-Plugin-list-search/js/list-search-min.js')}}"></script>
<script>
   $(document).ready(function(){
      
       $('#scroller').infiniteScroll({
        path: '.next',
        append: '.location-item',
        history: false,
        status: '.scroller-status',
        checkLastPage: true,
        hideNav: '.pagination'
     });
   
   
   
   $('.ui.search')
       .search({
       apiSettings: {
       url: 'location-search?q={query}',
   },
   fields: {
       results : 'items',
       title   : 'title',
   },
   onSelect: function(result, response) {
           $("#searchElementProduct").val(result.title);
           $("#formFilterId").submit();
       }
   });
   
   
   });
   
   
</script>
@endpush
@endsection