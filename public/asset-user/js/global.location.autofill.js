/**
 * javascript code for global lat lng update
 * 
 */
var componentForm = {
  city: 'short_name',
  state: 'long_name',
  country: 'long_name',
  zipcode: 'short_name',
  administrative_area_level_1: 'short_name'
};

var geocoder;

var GLOBAL_ALLOW_PROFILE_LOCATION = {

  __handle_user_permission: function () {
    geocoder = new google.maps.Geocoder(); //for the location when user click on the button
    navigator.permissions.query({
      name: 'geolocation'
    }).then(function (result) {
      if (result.state == 'granted') {

        navigator.geolocation.getCurrentPosition(function (position) {
          $("#global_lat").val(position.coords.latitude);
          $("#global_lng").val(position.coords.longitude);
          codeLatLng(position.coords.latitude, position.coords.longitude)
          $.ajax({
            url: "https://geoip-db.com/jsonp",
            jsonpCallback: "callback",
            dataType: "jsonp",
            success: function (location) {
              $('#global_country').val(location.country_name);
              $('#global_administrative_area_level_1').val(location.state);
              $('#global_locality').val(location.city);
              $("#global_postal_code").val(location.postal);
              $('#global_ip').val(location.IPv4);
              GLOBAL_ALLOW_PROFILE_LOCATION.__update_user_current_location();
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
        ALLOW_PROFILE_LOCATION.__report_user_permisison_issues(result.state);
        // geoBtn.style.display = 'inline';
      }


      result.onchange = function () {


        if (result.state == 'granted') {

          navigator.geolocation.getCurrentPosition(function (position) {
            $("#global_lat").val(position.coords.latitude);
            $("#global_lng").val(position.coords.longitude);
            codeLatLng(position.coords.latitude, position.coords.longitude)
            $.ajax({
              url: "https://geoip-db.com/jsonp",
              jsonpCallback: "callback",
              dataType: "jsonp",
              success: function (location) {
                console.log(location);
                $('#global_country').val(location.country_name);
                $('#global_administrative_area_level_1').val(location.state);
                $('#global_locality').val(location.city);
                $("#global_postal_code").val(location.postal);
                $('#global_ip').val(location.IPv4);
                GLOBAL_ALLOW_PROFILE_LOCATION.__update_user_current_location();
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
          GLOBAL_ALLOW_PROFILE_LOCATION.__report_user_permisison_issues(result.state);
          // geoBtn.style.display = 'inline';
        }

      }
    });

  },
  __report_user_permisison_issues: function (state) {
    console.log('Permission ' + state);
    alert("You need to enable location permission for accessing our resources");
  },

  __update_user_current_location: function () {
      
    $.ajax({
      url: $("#location_submit_url").val(),
      type: 'GET',
      data: $("#update_curren_user_location").serialize(),
      success: function (response) {
        location.reload();
      }
    });

  }

}

$("body").on('click', '#global_autolocation', function () {
  GLOBAL_ALLOW_PROFILE_LOCATION.__handle_user_permission();
});

  
var autocompleteInput = document.getElementById("global_location");
var observerHack = new MutationObserver(function () {
  observerHack.disconnect();
  $("#global_location").attr("autocomplete", "new-password");
});

observerHack.observe(autocompleteInput, {
  attributes: true,
  attributeFilter: ['autocomplete']
});


function codeLatLng(lat, lng) {
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({ 'latLng': latlng }, function (results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      $("#global_location").val(results[0].formatted_address);
      $("#global_formatted_address").val(results[0].formatted_address);
    } else {
      alert("Geocoder failed due to: " + status);
    }
  });
}



$("#global_location").geocomplete({
  details: "#update_curren_user_location",
  componentRestrictions: {
    country: "us"
  }
}).bind("geocode:result", function (event, result) {
  GLOBAL_ALLOW_PROFILE_LOCATION.__update_user_current_location();
});;




