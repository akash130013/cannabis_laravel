

var componentForm = {
  city: 'short_name',
  state: 'long_name',
  country: 'long_name',
  zipcode: 'short_name',
  administrative_area_level_1: 'short_name'
};


var geocoder;
var ALLOW_LOCATION = {

  __handle_permission: function () {
    geocoder = new google.maps.Geocoder(); //for the location when user click on the button
    navigator.permissions.query({
      name: 'geolocation'
    }).then(function (result) {
      if (result.state == 'granted') {
     
        navigator.geolocation.getCurrentPosition(function (position) {
          $("#lat").val(position.coords.latitude);
          $("#lng").val(position.coords.longitude);
          codeLatLng(position.coords.latitude, position.coords.longitude)
          $.ajax({
            url: "https://geoip-db.com/jsonp",
            jsonpCallback: "callback",
            dataType: "jsonp",
            success: function (location) {
              $('#country').val(location.country_name);
              $('#administrative_area_level_1').val(location.state);
              $('#locality').val(location.city);
              $("#postal_code").val(location.postal);
              $('#ip').val(location.IPv4);
            }
          });
          //end code

        });
        //geoBtn.style.display = 'none';
      }

      else if (result.state == 'prompt') {

        // geoBtn.style.display = 'none';
        navigator.geolocation.getCurrentPosition(function (position) {

          console.log("Found your location \nLat : " + position.coords.latitude + " \nLang :" + position.coords.longitude);

        });
      }

      else if (result.state == 'denied') {
        ALLOW_LOCATION.__report_permisison_issues(result.state);
        // geoBtn.style.display = 'inline';
      }


      result.onchange = function () {


        if (result.state == 'granted') {

          navigator.geolocation.getCurrentPosition(function (position) {
            $("#lat").val(position.coords.latitude);
            $("#lng").val(position.coords.longitude);
            codeLatLng(position.coords.latitude, position.coords.longitude)
            $.ajax({
              url: "https://geoip-db.com/jsonp",
              jsonpCallback: "callback",
              dataType: "jsonp",
              success: function (location) {
                $('#country').val(location.country_name);
                $('#administrative_area_level_1').val(location.state);
                $('#locality').val(location.city);
                $("#postal_code").val(location.postal);
                $('#ip').val(location.IPv4);
              }
            });
            //end code

          });
          //geoBtn.style.display = 'none';
        }

        else if (result.state == 'prompt') {

          // geoBtn.style.display = 'none';
          navigator.geolocation.getCurrentPosition(function (position) {

          });
        }

        else if (result.state == 'denied') {
          ALLOW_LOCATION.__report_permisison_issues(result.state);
          // geoBtn.style.display = 'inline';
        }

      }
    });

  },
  __report_permisison_issues: function (state) {
    // console.log('Permission ' + state);
    alert("Location access is Blocked. Change your location settings in browser or select location manually");
  },

  __update_user_current_location: function (position) {

    $.ajax({
      url: $("#location_submit_url").val(),
      type: 'GET',
      data: { lat: position.coords.latitude, lng: position.coords.longitude }
    });

  }


}

$("body").on('click', '#autolocation', function () {
  ALLOW_LOCATION.__handle_permission();
});


function codeLatLng(lat, lng) {
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({ 'latLng': latlng }, function (results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      $("#location").val(results[0].formatted_address);
    } else {
      alert("Geocoder failed due to: " + status);
    }
  });
}

// $('#autolocation').on('click', function(){
//   getLocation();
// });

// var x = document.getElementById("demo");

// function getLocation() {
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(showPosition);
//   } else { 
//     x.innerHTML = "Geolocation is not supported by this browser.";
//   }
// }

// function showPosition(position) {
// alert(position);
//   // x.innerHTML = "Latitude: " + position.coords.latitude + 
//   // "<br>Longitude: " + position.coords.longitude;
// }



$( window ).on("load", function() {
   if (navigator.geolocation) {
    // navigator.geolocation.getCurrentPosition();
    navigator.geolocation.getCurrentPosition(ALLOW_LOCATION.__handle_permission());
   
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
});