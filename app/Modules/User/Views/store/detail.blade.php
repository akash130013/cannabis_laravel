@extends('User::includes.innerlayout')
@include('User::includes.navbar')


<!--header close-->
@section('content')

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
                           <li><a href="javascript:void(0)" class="active">Detail</a></li>
                        <li><a href="{{route('users.store.product',['id'=>encrypt($storeDetail['store_id'])])}}">Products</a></li>
                           <li><a href="{{route('users.store.review',['id'=>encrypt($storeDetail['store_id'])])}}">Reviews</a></li>
                        </ul>
                     </div>
            </section>

           <!--Detail Navigation Close--> 

         <section class="inner_centerpanel m-t-30">
           
          
            <div class="custom_container">
               <div class="flex-row">
                  <div class="flex-col-sm-6">

                  <h2 class="title-heading">Store Images</h2>
                 
                  <div class="store-images-box">
                     <section class="store-banner">
                     @include('User::store.store-slider') 
                     </section>
                  </div>

                        <h2 class="title-heading">About Store</h2>
                        <p class="commn_para m-t-b-30">
                             {{$storeDetail['about_store'] ?? ''}}
                        </p>
          
                        <hr class="close-ruler">

                        <div class="open_close_time">
                           
                           @if($storeDetail['is_open'])
                            <span class="opennow">Open Now</span>
                            @else
                            <span class="closeheading"> Closed Now</span>
                           @endif
 
                           <ul>
                              @if (!empty($storeDetail['time_table']))
                                 
                              @foreach ($storeDetail['time_table'] as $item)
                                  @if($item['working_status'] !='closed')
                                   <li><span class="day">{{$item['day']}}</span> <span class="time">{{$item['start_time']}} - {{$item['end_time']}}</span> </li>
                                 @else
                                 <li><span class="day">{{$item['day']}}</span> <span class="time">Closed</span> </li>
                                 @endif
                              @endforeach
                              @endif
                           </ul>
                        </div>

                  </div>

                  <div class="flex-col-sm-6">


                     <div class="store_contact_block">
                          
                           <div id="googleMap" class="map_wrapper">

                           </div>

                           <div class="str-details">
                              <ul>
                                    <li class="map-location">{{$storeDetail['address'] ?? ''}}</li>

                                    <li class="distance">{{$storeDetail['distance'] ?? ''}}</li>
                                 
                                    <li class="call">{{$storeDetail['contact_number'] ?? 'N/A'}}</li>

                              <li class="mail"><a href="mailto:{{$storeDetail['email']}}?subject={{$storeDetail['store_name']}}"> {{$storeDetail['email'] ?? ''}}</a></li>
                                      
  
                               </ul>
                          </div>
                     </div>

                  </div>
                  

               </div>
            </div>
         </section>
        
         <input type="hidden" name="search_type" value="2">

        <input type="hidden" id="location_json" value="{{json_encode($storeDetail)}}">
 @endsection
 @section('pagescript')
   <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
 <script>
     
   
function initialize(locations){
    locations =  $.parseJSON(locations);
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
          icon:'/asset-user-web/images/Store-Pin-Location.png',
         title:locations.store_name,
     });
} 


$( window ).on("load", function() {
    var locations = $("#location_json").val();
   
    
// Handler for .load() called.'
initialize(locations);

});   

</script>
 @endsection