

var componentForm = {
    city: 'short_name',
    state: 'long_name',
    country: 'long_name',
    zipcode: 'short_name',
    administrative_area_level_1: 'short_name'
  };
  
  
  var geocoder;
  var ALLOW_PROFILE_LOCATION = {
  
    __handle_user_permission: function () {
      geocoder = new google.maps.Geocoder(); //for the location when user click on the autolocation
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
          ALLOW_PROFILE_LOCATION.__report_user_permisison_issues(result.state);
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
                  console.log(location);
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
            ALLOW_PROFILE_LOCATION.__report_user_permisison_issues(result.state);
            // geoBtn.style.display = 'inline';
          }
  
        }
      });
  
    },
    __report_user_permisison_issues: function (state) {
      console.log('Permission ' + state);
      alert("You need to enable location permission for accessing our resources");
    },
  
  }
  
  $("body").on('click', '#autolocation', function () {
    ALLOW_PROFILE_LOCATION.__handle_user_permission();
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
  
  
  
  
  
  