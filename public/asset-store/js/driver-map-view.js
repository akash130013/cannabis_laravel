
var markers = [];
function initMap(locations) {
    
    var storelat=Number($("#store_lat").val());
    var storelng=Number($("#store_lng").val());
    
    var map = new google.maps.Map( document.getElementById( 'googleMap' ), {
        zoom: 4,
        center: { lat: storelat, lng: storelng },
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
   
    //  return false;
    //////////////////////////////////////////////////////////
    
    var infowindow = new google.maps.InfoWindow();
   
        $.each( locations, function( index, value ){
        
        var name = value.distributor.name, address = value.distributor.address, 
        lat = value.distributor.latitude, lng = value.distributor.longitude, current_status=value.distributor.current_status
        var imageIcon;
        if(current_status=='offline'){
           imageIcon='/asset-store/images/LocationRed.svg';
        }
        if(current_status=='online'){
            imageIcon='/asset-store/images/LocationGreen.svg';

        }
        if(current_status=='busy'){
            imageIcon='/asset-store/images/LocationYellow.svg';

        }

        latlngset = new google.maps.LatLng(lat, lng);
        
        var marker = new google.maps.Marker({
            map: map,
            title: name,
            position: latlngset,
            icon:imageIcon,
        });

        markers.push(marker);
        // google.maps.event.addListener(marker, 'click', (function(marker, content) {
               
        //     return function() {
        //         // console.log(value.store_id);
                
        //         // infowindow.setContent(content);
              
        //         infowindow.open(map, marker);
                
        //     }
        // })(marker));
   
});



    // // Add a marker clusterer to manage the markers.
    var markerCluster = new MarkerClusterer( map, markers,
            { 
                imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m' 
            } );
}



$( window ).on("load", function() {
    var locations = $("#json_data_store").val();
   initMap(locations);
});


