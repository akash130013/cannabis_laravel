var componentForm = {
  street_number: 'short_name',
  locality: 'long_name',
  country: 'long_name',
  postal_code: 'short_name',
  administrative_area_level_1: 'short_name'
};

var geocoder;

function initialize() {


  // show map related to the current view port //

  var latitute = ($("#lat").val() != "") ? parseFloat($("#lat").val()) : 	36.778259;
  var lngitude = ($("#lng").val() != "") ? parseFloat($("#lng").val()) : -119.417931;

  // var latitute = $("#lat").val();
  // var lngitude = $("#lng").val();

  var latlng = new google.maps.LatLng(latitute, lngitude);
  geocoder = new google.maps.Geocoder();

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 8 ,
    center: latlng,
    panControl: true,
    zoomControl: true,
    scaleControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  });


/*************************************remove google chrome autofill******************* */
var autocompleteInput = document.getElementById("address");
var observerHack = new MutationObserver(function() {
  observerHack.disconnect();
  $("#address").attr("autocomplete", "off");
});

observerHack.observe(autocompleteInput, {
  attributes: true,
  attributeFilter: ['autocomplete']
});

/***************end of google chrome autofill ***************************************** */

  addMarker(latlng, map);

  var markers = [];
  var input = document.getElementById('address');
  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.setComponentRestrictions(
    { 'country': ['us'] });
  google.maps.event.addListener(autocomplete, 'place_changed', function () {
    
    var place = autocomplete.getPlace();

    var lat = place.geometry.location.lat();
    var lng = place.geometry.location.lng();


    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;

    for (var component in componentForm) {
      document.getElementById(component).value = '';
      document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    var address = $("#address").val();
    $("#hiddenaddress").val(address);
    for (var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];
      if (componentForm[addressType]) {
        var val = place.address_components[i][componentForm[addressType]];
        document.getElementById(addressType).value = val;
      }
    }

    // Clear out the old markers.
    markers.forEach(function (marker) {
      marker.setMap(null);
    });
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    // For each place, get the icon, name and location.
    if (!place.geometry) {
     
      return;
    }
    var icon = {
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(25, 25)
    };

    // Create a marker for each place.
    markers.push(new google.maps.Marker({
      map: map,
      icon: icon,
      title: place.name,
      draggable: true, // enables drag & drop
      animation: google.maps.Animation.DROP,
      position: place.geometry.location
    }));

    markers.forEach(function (marker) {
      google.maps.event.addListener(marker, 'dragend', function () {
         
        geocodePosition(marker.getPosition());
      });

    });

    if (place.geometry.viewport) {
      // Only geocodes have viewport.
      bounds.union(place.geometry.viewport);
    } else {
      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);


/**time zone API to get time zone */
  
  $.ajax({
    url:`https://maps.googleapis.com/maps/api/timezone/json?location=`+lat+`,`+lng+`&timestamp=`+(Math.round((new Date().getTime())/1000)).toString()+`&key=`+localMsg.TIME_ZONE_API_KEY,
 })
 .done(function(response){
    $("#time_zone").val(response.timeZoneId);
 });
 //done time zone

  });

}

function geocodePosition(pos) {
 
  geocoder.geocode({
    latLng: pos
  }, function (responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses,pos);

       /**time zone API to get time zone */
      $.ajax({
          url:`https://maps.googleapis.com/maps/api/timezone/json?location=`+pos.lat()+`,`+pos.lng()+`&timestamp=`+(Math.round((new Date().getTime())/1000)).toString()+`&key=AIzaSyDfjk9aaoLcnO30fhjsL5MQ8Bdp1CxRxes`,
       })
       .done(function(response){
          $("#time_zone").val(response.timeZoneId);
       });
       //done time zone
          }
  });
}

function updateMarkerAddress(responses,pos) {

  console.log(responses[0]);

  var address = responses[0].formatted_address;
  $("#hiddenaddress").val(address);
  $("#address").val(address);
    
  document.getElementById('lat').value = pos.lat();
  document.getElementById('lng').value = pos.lng();

  // https://maps.googleapis.com/maps/api/timezone/json?location=38.908133,-77.047119&timestamp=1458000000&key=YOUR_API_KEY


  for (var i = 0; i < responses[0].address_components.length; i++) {
    var addressType = responses[0].address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = responses[0].address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;

    }
  }

 

}

function addMarker(latLng, map) {
  var marker = new google.maps.Marker({
    position: latLng,
    map: map,
    draggable: true, // enables drag & drop
    animation: google.maps.Animation.DROP
  });

  return marker;
}

