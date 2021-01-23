var $intabce = $('#scroller').infiniteScroll({
    // options
    path: '.next',
    append: '.item',
    history: false,
    status: '.scroller-status',
    checkLastPage: true,
    hideNav: '.pagination',
    elementScroll:".store_card_col_inwrap"
  });

  $intabce.on( 'load.infiniteScroll', function( event, response ) {
  // parse JSON
//   console.log(response);
    /*** $.parseHTML ***/
    // var json = JSON.parse($(response).find(".json_data_store").val());
    var json = $(response).find(".json_data_store").val();

    // console.log(json);
    initMap(json);   
  // do somethresponseing with JSON...
});



var markers = [];
function initMap(locations) {
    
   
   
    
    var userlat=Number($("input[name=userLat]").val());
    var userlng=Number($("input[name=userLng]").val());
    
    var map = new google.maps.Map( document.getElementById( 'googleMap' ), {
        zoom: 4,
        center: { lat: userlat, lng: userlng },
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // Create an array of alphabetical characters used to label the markers.
    var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    // Add some markers to the map.
    // Note: The code uses the JavaScript Array.prototype.map() method to
    // create an array of markers based on a given "locations" array.
    // The map() method here has nothing to do with the Google Maps API.
    //locations =  $.parseJSON(locations);
    locations = JSON.parse(locations)
   
    
    //////////////////////////////////////////////////////////
    
    var infowindow = new google.maps.InfoWindow();
   
        $.each( locations, function( index, value ){
        
        var name = value.store_name, address = value.address, 
        lat = value.latitude, lng = value.longitude,

        latlngset = new google.maps.LatLng(lat, lng);
        //  console.log(value.opening_timing);
         
        var opening_timing=tConvert(value.opening_timing.slice(0,-3));
        var closing_timing=tConvert(value.closing_timing.slice(0,-3));
        var openStatus='Closed Now';
        
        if (value.is_open==true) {
            openStatus='Open Now';
        } 
         var activeClass='';
        if(value.is_bookmarked==true){
            activeClass='active';
        }

         var content=`<div class="map-store-card">
                                       <div class="inner-wrapper card-effect">
                                          <figure class="store">
                                                <span class="mark_fav_store `+activeClass+`" data-id="`+value.store_id+`"> </span>
                                             <img src="`+value.store_images[0]+`">
                                          </figure>
                                          <div class="details">
                                             <div class="details-in">
                                             
                                              <span class="store-name">`+name+`</span>
                                               
                                             
                                                <div class="review_count">
                                                      <span class="rating"><img src="/asset-user-web/images/xsm-leaf.png">`+value.rating+`</span>
                                                      <span class="total">`+value.review_count+` Reviews </span>
                                                   </div>
                                                <span class="location-address">
                                                 `+address+`
                                                </span>
                                                <span class="location-address">`+value.contact_number+`</span>
                                                <div class="text-right">
                                                   <span class="distance">`+value.distance+`</span>
                                                </div>
                                             </div>
                                             <div class="time_status">
                                                <div class="time">
                                                   Open `+opening_timing+` • Closes `+closing_timing+`
                                                </div>
                                                <div class="status">
                                                   `+openStatus+`
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>`;
        var marker = new google.maps.Marker({
            map: map,
            title: name,
            position: latlngset,
            icon:'/asset-user-web/images/Store-Pin-Location.png',
        });
             markers.push(marker);
        google.maps.event.addListener(marker, 'click', (function(marker, content) {
               
             
            return function() {
                // console.log(value.store_id);
                
                infowindow.setContent(content);
                // $('html,body #top_scroll').animate({
                //         scrollTop: $("#div_"+value.store_id).offset().top},
                // 'slow');
                // $("#top_scroll").animate({scrollTop: $("#div_"+value.store_id).position().top},'slow');

                infowindow.open(map, marker);
                
            }
        })(marker, content));
   
});



    // // Add a marker clusterer to manage the markers.
    var markerCluster = new MarkerClusterer( map, markers,
            { 
                imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m' 
            } );
}



$( window ).on("load", function() {
    var locations = $(".json_data_store").val();
   initMap(locations);
});

function tConvert (time) {
    console.log(time);
    
  // Check correct time format and split into components
  time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

  if (time.length > 1) { // If time format correct
    time = time.slice (1);  // Remove full string match value
    time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
    time[0] = +time[0] % 12 || 12; // Adjust hours
  }
  return time.join (''); // return adjusted time or original string
}

