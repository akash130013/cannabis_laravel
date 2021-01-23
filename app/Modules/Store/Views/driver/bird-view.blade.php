@extends("Store::layouts.master")
@section('content')
<div class="custom_container">
   @include('Store::layouts.pending-alert')
   <div class="tab_wrapper_seprate">
      <!-- menu-->
      <div class="head-nav tab_wrapper">
         <ul>
            <li><a href="{{route('store.driver.list',['status'=>'all'])}}">Listing</a></li>
            <li><a href="javascript:void(0)" class="active">Bird’s Eye View</a></li>
         </ul>
      </div>
      <!-- menu close-->
   </div>
   <div class="map_col" id="googleMap" style="height:535px">
   </div>
</div>
<input type="hidden" id="store_lat" value="{{$store->lat}}">
<input type="hidden" id="store_lng" value="{{$store->lng}}">
<input type="hidden" name="json_data_store" id="json_data_store" value="{{json_encode($list)}}">
@endsection
@push('script')
<script src="{{asset('asset-store/js/bootstrap-select.js')}}"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="{{asset('asset-store/js/driver-map-view.js')}}"></script>
@endpush