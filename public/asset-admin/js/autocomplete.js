// This sample uses the Autocomplete widget to help the user select a
// place, then it retrieves the address components associated with that
// place, and then it populates the form fields with those details.
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;

var componentForm = {
  street_number: 'short_name',
  locality: 'long_name',
  country: 'long_name',
  postal_code: 'short_name'
};

var GET_NOTIFY_DATA = {


  __fetch_typed_data: function(searchTerm, dataType, response,dataId) {
    $.ajax({

        type: 'GET',

        url: '/admin/ajax-request/notify-data',

        data: { term: searchTerm, data_id: dataId, data_type : dataType },

        beforeSend: function () {
            $("#search_loader").html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        },

        success: function (data) {

            response(data);

        },
        complete: function () {
            $("#search_loader").html('');
        }

    });
}
 }

function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('address'), {types: ['geocode']});

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
  autocomplete.setFields(['address_component']);

  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();

 

  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details,
  // and then fill-in the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      document.getElementById('lat').value = geolocation.lat;
      document.getElementById('lng').value = geolocation.lng;

    
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
  
 
$("#searchNotifyType").autocomplete({
  source: function (request, response) {

      $('#error_product_search').html('');
      var catId = $("#notify_type_id :selected").val();
      var dataType = $('#notifyType').val();
      
      GET_NOTIFY_DATA.__fetch_typed_data(request.term, dataType, response,catId)
  },
  select: function (event, ui) {
    
    
      if (ui.item.id) {
          $('#searchNotifyType').val(ui.item.name); // display the selected text
          $('#notification_type_id').val(ui.item.id); // save selected id to hidden input
      } 

      return false;
  },
  change: function (event, ui) {
      $("#notification_type_id").val(ui.item ? ui.item.id : 0);
  },
  minLength: 2,
  create: function () {
      $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
          return (item.id) ? $('<li>')
              .append("<a>" + item.name + "</a>")
              .appendTo(ul) : ((typeof item.name != 'undefined') ? $('<li>').append("<a>" + item.name + "</a>").appendTo(ul) : $('<li>'));



      };
  }
});



// driver function for all //
// $("body").on('change', '#notify_type_id', function () {
//   $("#searchNotifyType").val('');
//   $("#searchproduct_id").val(0);
// });   
