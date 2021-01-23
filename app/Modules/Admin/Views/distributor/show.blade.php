@extends('Admin::includes.layout')
@section('content')
 <!-- Side menu start here -->
 @include('Admin::includes.sidebar')
 <!-- Side menu ends here -->
 <div class="right-panel">
         @include('Admin::includes.header')
        <!-- Header End-->
        <!-- Inner Right Panel Start -->


        <!--breadcrumb-->
        <div class="bred-crumbs">
            <ul>
                <li>
                    <a href="{{route('admin.distributor.index')}}">Drivers</a> 
                </li>

                <li>
                    <a href="#" class="active">Details</a> 
                </li> 

            </ul>
        </div>
        <!--breadcrumb Close-->

        <div class="inner-right-panel">
            <!-- Driver details start-->
            <div class="white_wrapper">

                <!--block heading -->
                <div class="blok_heading">
                    <h2>{{$data->name}}</h2>
                </div>
                {{-- {{$data->proofs-}} --}}
                <!--block heading -->

                <div class="manage-drivers">
                <!-- main row start -->
                <div class="flex-row">
                    <div class="flex-col-sm-12">
                        <figure class="store_img prof_img mt20">
                            <img src="{{$data->profile_image}}" />
                            <figcaption>Profile Image</figcaption>
                        </figure>
                        
                        
                                           
                           
                    </div>

                </div>

                <div class="flex-row flex-wrap">
                        
                                
                        @foreach ($data->proofs as $item)
                        <div class="flex-col-sm-4">
                                <figure class="store_img mt20">
                                    <img src="{{$item->file_url??config('constants.DEAFULT_IMAGE.DRIVER_PROOF_IMAGE')}}" />
                                    <figcaption>
                                            @if($item->type == 'other')
                                            Vehicle Image
                                        @else
                                        {{ucFirst(str_replace('_',' ',$item->type))}}
                                        @endif
                                    </figcaption>
                                </figure>
                                </div>
                            @endforeach
                       
                        
                </div>
                    <div class="flex-row">
                    <div class="flex-col-sm-12">
                        <!-- row start -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">User Id</label>
                                <span class="label-data">{{$data->id}}</span>
                            </div>

                            <div class="flex-col-sm-4">
                                <label class="table-label">Driver Name</label>
                                <span class="label-data td-text-wrap">{{$data->name}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Email Address</label>
                                <span class="label-data">{{$data->email??'--'}}</span>
                            </div>
                        </div>
                        <!-- row end -->

                        <!-- row start -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">Registered On</label>
                                <span class="label-data">{{\App\Helpers\CommonHelper::convertFormat($data->created_at,'M d, Y')}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Numbers of Orders Completed</label>
                                <span class="label-data">{{$data->completed_orders_count??0}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Total Orders</label>
                                <span class="label-data">{{$data->orders_count??'--'}}</span>
                            </div>
                        </div>
                        <!-- row end -->

                        <!-- row start -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">Phone Number</label>
                                <span class="label-data">{{$data->phone_number}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Vehicle Number</label>
                                <span class="label-data">{{$data->vehicle_number?$data->vehicle_number:'--'}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Status</label>
                                <span class="label-data">
                                    @if($data->status == 'active')
                                    Active
                                    @else
                                    Inactive
                                    @endif
                                </span>
                            </div>
                        </div>
                        <!-- row end -->

                        <!-- row start -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">License Number</label>
                                <span class="label-data">{{$data->dl_number?$data->dl_number:'--'}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">License Expiry</label>
                                <span class="label-data">{{\App\Helpers\CommonHelper::convertFormat($data->dl_expiraion_date)}}</span>
                            </div>
                        </div>
                        <!-- row end -->
                        <div id="googleMap" class="map_wrapper">
                    </div>
                </div>
                <!-- main row end -->
                
                
              
               
            </div>
            <div class="btn-space text-center">
                    <a title="{{$data->status == 'active'?'Blocked':'Unblock'}}" data-call="blade"  data-type="distributor"  data-id="{{$data->distributor_decrypt_id}}" data-text="{{$data->status == 'active'?trans('Admin::messages.block_distributor_popup'):trans('Admin::messages.unblock_distributor_popup')}}"  id="{{$data->status =='active'?'warning-alert':'info-alert'}}" href="javascript:void(0); ">
                        <button class="mr10 green-fill-btn green-border-btn">{{$data->status == 'active'?'Deactivate':'Activate'}}</button>
                </a>
                    {{-- <a class="primary- btn">Track Driver Location</a> --}}
                </div>
            <!-- Driver details end-->
            </div>
            </div>
            <div class="white_wrapper">
            <div class="">
            <input id="distributorId" value="{{$data->id}}" name="distributorId" hidden>
            <div class="">
                    <!--block heading -->
                    <div class="blok_heading">
                        <h2>Orders</h2>
                    </div>
                    <!--block heading -->
                
                    <!-- loaction filters -->
                  
                    <div class=" pd-20">
                        <!-- store filters -->
                        @include('Admin::includes.searchbar',['is_filterable' => true,'is_creater'=>false,'searchPlaceholder'=>trans('Admin::messages.distributor_order_placeholder'),'route_name'=>''])
                        <!-- store filters -->
                    </div>
                        @include('Admin::order.index')
                </div>
            </div>
        </div>
        <!-- Inner Right Panel End -->
    </div>
</div>
<input type="hidden" name="search_type" value="2">

<input type="hidden" id="location_json" value="{{json_encode($data)}}">
@endsection
@section('pagescript')
<script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
<script src="{{asset('asset-admin/js/dataTables/distributorOrderList.js')}}"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script>
   function initialize(locations){
    
    locations =  $.parseJSON(locations);
    console.log(locations.latitude);
    
     var myLatlng = new google.maps.LatLng(locations.latitude,locations.longitude);
     var myOptions = {
         zoom: 4,
         center: myLatlng,
         mapTypeId: google.maps.MapTypeId.ROADMAP
         }
      map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
      var marker = new google.maps.Marker({
          position: myLatlng, 
          map: map,
        //  title:locations.store_name,
     });
} 


$( window ).on("load", function() {
    var locations = $("#location_json").val();
  
    
// Handler for .load() called.'
initialize(locations);
   
});   
$('#startDate').datetimepicker({ 
    format: 'YYYY-MM-DD',
    useCurrent: true,
});

$('#endDate').datetimepicker({ 
    format: 'YYYY-MM-DD',
    useCurrent: true,
});
</script>
@endsection