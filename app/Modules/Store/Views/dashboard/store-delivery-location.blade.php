@extends('Store::register.layout')
@section('content')
{{-- @include('Store::includes.header') --}}
<!-- Header End -->
<!-- Tabs menu -->
<div class="tabularProMenu">
   <div class="form-container">
      <ol>
         <li><span>Store Details</span></li>
         <li><span>Operating Hours</span></li>
         <li><span>Store Images</span></li>
         <li  class="active"><span>Store Delivery Locations</span></li>
      </ol>
   </div>
</div>
<!-- Tabs menu End -->
<!-- Internal Container -->
<div class="internal-container">
   <!-- Form Container -->
   <div class="form-container cstm-map stepForm step1 active">
      <h4>Delivery Location</h4>
      <div class="operat-hours">
         <div class="frm-lt-sd">
            <div class="ins-profilefrm-lt-sd">
               <form action="{{route('add.store.delivery.location')}}" id="store_details_submit" method="post">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="frm-sec-ins">
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <input type="text" name="address" id="address" value=""  placeholder="Enter zipcode to add your delivery address..">
                                 <div id="search_loader_icon" class="detect-icon"><i class="fa fa-search" aria-hidden="true"></i></div>
                              </div>
                              <span id="address-error"></span>
                              @if(Session::has('errors'))
                              <span class="error">{{Session::get('errors')->first('address')}}</span>
                              @endif 
                           </div>
                        </div>
                     </div>
                     <div class="flex-row">
                        <div class="flex-col-sm-12">
                           <div class="text-field-wrapper">
                              <button type="button" id="submit_add_location" class="green-fill btn-effect" >Add New Area</button>
                              <!-- <button type="submit" class="btn custom-btn green-fill getstarted" >+ Add New Area</button> -->
                              <!-- <a href="{{route('final-submit-profile')}}" class="btn custom-btn green-fill getstarted" >Complete</a> -->
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
               <form action="{{route('add.store.delivery.location')}}" id="submit_hidden_params" method="post">
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
            <div class="col-sm-12 m-t-20">
               @if($store_delivery_address)
               @foreach($store_delivery_address as $key => $val)
               <div class="address_details">
                  <div class="location">
                     <i class="fa fa-map-marker" aria-hidden="true"></i>
                     {{$val->formatted_address}}
                  </div>
                  <a href="{{route('remove.store.delivery.location')}}?params={{$val->id}}" title="Delete">
                  <img class="removeImage_{{$val->id}}" src="{{ asset('asset-store/images/delete.svg')}}" >
                  </a>
               </div>
               @endforeach
               @endif
            </div>
         </div>
         <div class="frm-rt-sd" id="map_canvas">
            <!-- <img src="{{asset('asset-store/images/map.jpg')}}" alt=""> -->
         </div>
         <div class="frm_btn">
            <div class="row">
               <div class="col-sm-12">
                  <div class="btn-wrapper text-right">
                     <ul>
                        <li>
                           <a href="{{route('show.store.images')}}" class="green-fill outline-btn store-bck-btn">Back</a>
                        </li>
                        <li>
                           <button type="button" data-href="{{route('final-submit-profile')}}" id="store_submit_button" class="green-fill btn-effect" > Submit </button>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <!-- <div class="frm_btn w-100">
            <div class="row">
                <div class="col-sm-12">
                    <div class="btn-group">
                        <a href="{{route('final-submit-profile')}}" class="btn custom-btn green-fill getstarted" >Complete</a>
                    </div>
                </div>
            </div>
            </div> -->
      </div>
   </div>
   <!-- Form Container End -->
</div>
<input type="hidden" value="{{route('store.ajax.get.zip.code')}}" id="url_search_zip_code">
<input type="hidden" value="{{json_encode($store_delivery_address)}}" id="hidden_marker_list">
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<!-- <script src="{{ asset('asset-store/js/autocomplete.js')}}"></script> -->
{{-- <script src="{{asset('asset-store/js/maps.service.zipcode.js')}}"></script> --}}
<script src="{{asset('asset-store/js/map-service-copy.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjN4ZWartGxRef-S_LYQWqhfCsWWvZBbI&libraries=places&callback=initialize" async defer></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="{{asset('asset-store/css/jquery.ui.css')}}">
<script src="{{asset('asset-store/js/default.store.location.js')}}"></script>   
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
<script>
   $("#store_details_submit").validate({
          errorClass:'error',
          errorElement:'span',
   rules: {
               address: {
                   required  :true
               }
       	
   },
   messages: {
         address: {
                   required : "Please enter zipcode"
               }
   
           },
           errorPlacement: function (error, element) {
                           error.insertAfter("#address-error");
            },
           submitHandler: function(form, event) { 
                   event.preventDefault();
           }
       });
       
   
       $('body').on('click','#submit_add_location',function(){
           var address = $("#address").val();
           if($.trim(address) == "") {
   
            $($("#address")).closest('.text-field-wrapper').after('<span class="input-error error">Please enter zipcode</span>');
               // swal("Please enter zip code");
               return false;
           }

           $("#submit_hidden_params").submit();
       });
       $('body').on('click','#store_submit_button',function(){
           var marker_list = $("#hidden_marker_list").val();
           var url = $(this).attr('data-href');
           if(marker_list.length <=0) {
   
               swal("Please add atleast one delivery location");
               return false;
           }
           // console.log(marker_list.length,marker_list);
           
           window.location.href = url;
       });
</script>
@endsection
@endsection