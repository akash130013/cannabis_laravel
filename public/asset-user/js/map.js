// var geocoder;
// function initialize() {
//     var input = document.getElementById('location');

//     geocoder = new google.maps.Geocoder();


//     var autocomplete = new google.maps.places.Autocomplete(input);
//     autocomplete.setComponentRestrictions(   //setting search only in US
//         {'country': ['us']});



//     // Specify only the data fields that are needed.
//     autocomplete.setFields(
//         ['address_components', 'geometry', 'icon', 'name']);

//     autocomplete.addListener('place_changed', function () {
//         var place = autocomplete.getPlace();
//         var lat = place.geometry.location.lat();
//         var lng = place.geometry.location.lng();
//         if (!place.geometry) {
//             // User entered the name of a Place that was not suggested and
//             // pressed the Enter key, or the Place Details request failed.
//             window.alert("No details available for input: '" + place.name + "'");
//             return;
//         }

//         $("#lat").val(lat);
//         $("#lng").val(lng);
//         codeLatLng(lat, lng)

//         console.log(place.address_components);
//         var address = '';
//         if (place.address_components) {
//             console.log(place);
//             address = [
//                 (place.address_components[0] && place.address_components[0].short_name || ''),
//                 (place.address_components[1] && place.address_components[1].short_name || ''),
//                 (place.address_components[2] && place.address_components[2].short_name || '')
//             ].join(' ');
//             console.log(address);
//         }
//     });

// }

// function codeLatLng(lat, lng) {

//     var latlng = new google.maps.LatLng(lat, lng);
//     geocoder.geocode({'latLng': latlng}, function(results, status) {
//       if (status == google.maps.GeocoderStatus.OK) {
//     //   console.log('hihhhh'+results[0].address_components[7].long_name); //zipcode
//     console.log(results[0].address_components);

//        $("#zipcode").val(results[0].address_components[7].long_name); //zipcode
//        $("#country").val(results[0].address_components[6].long_name);//country
//        $("#state").val(results[0].address_components[5].long_name);//state
//        $("#city").val(results[0].address_components[3].long_name);//city

//         if (results[1]) {
//          //formatted address
//         //  alert(results[0].formatted_address)
//         //find country name
//              for (var i=0; i<results[0].address_components.length; i++) {
//             for (var b=0;b<results[0].address_components[i].types.length;b++) {

//             //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
//                 if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
//                     //this is the object you are looking for
//                     city= results[0].address_components[i];
//                     break;
//                 }
//             }
//         }
//         //city data
//         // alert(city.short_name + " " + city.long_name)
//         // $("#city").val(city.long_name)

//         // $("#city").val(city.long_name);//city

//         } else {
//           alert("No results found");
//         }
//       } else {
//         alert("Geocoder failed due to: " + status);
//       }
//     });
//   }

// var placeSearch, autocomplete;

// var componentForm = {
//   street_number: 'short_name',
//   route: 'long_name',
//   locality: 'long_name',
//   administrative_area_level_1: 'short_name',
//   country: 'long_name',
//   postal_code: 'short_name'
// };

// function initialize() {
//   // Create the autocomplete object, restricting the search predictions to
//   // geographical location types.
//   autocomplete = new google.maps.places.Autocomplete(
//     document.getElementById('location'));
    

//   // Avoid paying for data that you don't need by restricting the set of
//   // place fields that are returned to just the address components.
//   // autocomplete.setFields(['address_component']);

//   // When the user selects an address from the drop-down, populate the
//   // address fields in the form.
//   autocomplete.addListener('place_changed', fillInAddress);
// }

// function fillInAddress() {
//   // Get the place details from the autocomplete object.
//   var place = autocomplete.getPlace();
//   console.log(place);
//   for (var component in componentForm) {
//     $("#" + component).val('');
//   }

//   // Get each component of the address from the place details,
//   // and then fill-in the corresponding field on the form.
//   for (var i = 0; i < place.address_components.length; i++) {
//     var addressType = place.address_components[i].types[0];
//     if (componentForm[addressType]) {
//       var val = place.address_components[i][componentForm[addressType]];
//       document.getElementById(addressType).value = val;
//     }
//   }
// }

// // Bias the autocomplete object to the user's geographical location,
// // as supplied by the browser's 'navigator.geolocation' object.
// function geolocate() {
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(function (position) {
//       var geolocation = {
//         lat: position.coords.latitude,
//         lng: position.coords.longitude
//       };

//       var lat = position.coords.latitude;
//       var lng = position.coords.longitude;
    
//       document.getElementById('lat').value = lat;
//       document.getElementById('lng').value = lng;
//       var circle = new google.maps.Circle(
//         { center: geolocation, radius: position.coords.accuracy });
//       autocomplete.setBounds(circle.getBounds());
//     });
//   }
// }


// function initialize() {
//     // var input = document.getElementById('location');

//     // geocoder = new google.maps.Geocoder();
//     var geocoder = new google.maps.Geocoder();
// // var address = "new york";
// var input = document.getElementById('location');
// geocoder.geocode( { 'address': input}, function(results, status) {

// if (status == google.maps.GeocoderStatus.OK) {
//     // var latitude = results[0].geometry.location.latitude;
//     // var longitude = results[0].geometry.location.longitude;
//     var latitude = results[0].geometry.location.lat();
//     var longitude = results[0].geometry.location.lng();
//     alert(latitude);
//     } 
// });

// }
