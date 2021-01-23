// google.load('visualization', '1', {'packages':['corechart', 'table', 'geomap']});
var map;
var labels = [];
var layer;
var tableid =  1499916;
var markerLists = $("#hidden_marker_list").length ? JSON.parse($("#hidden_marker_list").val()) : 'undefined'; 
var bounds;


function initialize() {
    geocoder = new google.maps.Geocoder();
   
    bounds  = new google.maps.LatLngBounds();
    var latlng = (markerLists.length == 0) ? new google.maps.LatLng(37.23032838760389, -118.65234375) : new google.maps.LatLng(markerLists[0].lat, markerLists[0].lng) 
  	map = new google.maps.Map(document.getElementById('map_canvas'), {
    center: latlng,
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  
  
  showMarkerArray(markerLists);

  google.maps.event.addListener(map, "bounds_changed", function() {
    // displayZips();
  });

  map.fitBounds(bounds);       
  map.panToBounds(bounds);     

}

var componentForm = {
    street_number: 'short_name',
    locality: 'long_name',
    country: 'long_name',
    postal_code: 'short_name',
    administrative_area_level_1 : 'short_name'
  };

function codeAddress() 
{
  
    var address = document.getElementById("address").value ? document.getElementById("address").value :((markerLists.length == 0) ? "11501" : markerLists[0].zip_code.toString());
    geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
       
        var lat = results[0].geometry.location.lat();
        var lng = results[0].geometry.location.lng();
        var inputAddress = document.getElementById("address").value;
       
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
        
        for (var component in componentForm) {
           
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }
       
        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        
        var formatted_addres = results[0].formatted_address;
        $("#hiddenaddress").val(formatted_addres);
        
        var infowindow = new google.maps.InfoWindow({
            content: '<strong style="font-size: larger;">'+formatted_addres+'</strong>'
       });

        // console.log(localStorage.getItem("zipcode"));
        
        for (var i = 0; i < results[0].address_components.length; i++) {
            var addressType = results[0].address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = results[0].address_components[i][componentForm[addressType]];
                console.log(val);
               
                document.getElementById(addressType).value = val;
            }
        }
        
        $("#postal_code").val(localStorage.getItem("zipcode"));
        localStorage.removeItem("zipcode");
        // map.setCenter(results[0].geometry.location);
        
        // if((markerLists.length == 0) && ($.trim(inputAddress) != '')) {
         
        // var marker = new google.maps.Marker({
        //     map: map, 
        //     position: results[0].geometry.location
        // });

        // marker.addListener('click', function() {
        //   infowindow.open(map, marker);
        // });

        // loc = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
        // bounds.extend(loc);

        // }
      

        // const client = new carto.Client({
        //   apiKey: '3acfed578ac00548df1b6ebf7891777261b21ad8',
        //   username: 'jatinpan'
        // });


        // // add zero layer //

        // var $sql_0 = "SELECT * FROM geojson WHERE ST_DWithin(ST_Transform(CDB_LatLng('"+lat+"', '"+lng+"'), 3857),the_geom_webmercator,50 / cos('"+lat+"' * pi()/180))";
        // var $sql_1 = "SELECT * FROM geojsonmap WHERE ST_DWithin(ST_Transform(CDB_LatLng('"+lat+"', '"+lng+"'), 3857),the_geom_webmercator,50 / cos('"+lat+"' * pi()/180))";
        // var $sql_2 = "SELECT * FROM geojson3 WHERE ST_DWithin(ST_Transform(CDB_LatLng('"+lat+"', '"+lng+"'), 3857),the_geom_webmercator,50 / cos('"+lat+"' * pi()/180))";
        // var $sql_3 = "SELECT * FROM zipregions WHERE ST_DWithin(ST_Transform(CDB_LatLng('"+lat+"', '"+lng+"'), 3857),the_geom_webmercator,50 / cos('"+lat+"' * pi()/180))";

        // //var $sql = "SELECT * FROM geojson ORDER BY the_geom_webmercator <-> ST_Transform(CDB_LatLng('"+lat+"', '"+lng+"'), 3857) LIMIT 1"

        // const source_0 = new carto.source.SQL($sql_0);
        // const style_0 = new carto.style.CartoCSS(`
        //   #geojsonmap {
        //     line-color: rgba(28, 138, 28, 1);
        //     line-width: 4;
        //   }
        // `);
        // const layers_0 = new carto.layer.Layer(source_0, style_0);
        // client.addLayer(layers_0);



        // // add first layer //

        // const source = new carto.source.SQL($sql_1);
        // const style = new carto.style.CartoCSS(`
        //   #geojsonmap {
        //     line-color: rgba(28, 138, 28, 1);
        //     line-width: 4;
        //   }
        // `);
        // const layers = new carto.layer.Layer(source, style);
        // client.addLayer(layers);

        // // add second layer //
        // const source_2 = new carto.source.SQL($sql_2);
        // const style_2 = new carto.style.CartoCSS(`
        //   #geojson3 {
        //     line-color: rgba(28, 138, 28, 1);
        //     line-width: 4;
        //   }
        // `);
        // const layers_2 = new carto.layer.Layer(source_2, style_2);
        // client.addLayer(layers_2);


        //   // add third layer layer //
        //   const source_3 = new carto.source.SQL($sql_3);
        //   const style_3 = new carto.style.CartoCSS(`
        //     #geojson3 {
        //       line-color: rgba(28, 138, 28, 1);
        //       line-width: 4;
        //     }
        //   `);
        //   const layers_3 = new carto.layer.Layer(source_3, style_3);
        //   client.addLayer(layers_3);
        //map.overlayMapTypes.push(client.getGoogleMapsMapType(map));

      
        // if (results[0].geometry.viewport) 
        //   map.fitBounds(results[0].geometry.viewport);
      } else {
        alert("Google Maps failed to search for result. Please try with some other zip code");
        location.reload();
      }
    });
  }
  		
function displayZips() {
  //set the query using the current bounds
  var queryStr = "SELECT geometry, ZIP, latitude, longitude FROM "+ tableid + " WHERE ST_INTERSECTS(geometry, RECTANGLE(LATLNG"+map.getBounds().getSouthWest()+",LATLNG"+map.getBounds().getNorthEast()+"))";   
  var queryText = encodeURIComponent(queryStr);
  var query = new google.visualization.Query('http://www.google.com/fusiontables/gvizdata?tq='  + queryText);
  // alert(queryStr);

  //set the callback function
  query.send(displayZipText);

}

function showMarkerArray(locations)
{

var infowindow = new google.maps.InfoWindow;

var marker, i;

for (i = 0; i < locations.length; i++) {  
    marker = new google.maps.Marker({
         position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
         map: map
    });

    loc = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
    bounds.extend(loc);

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
         return function() {
             infowindow.setContent(locations[i].formatted_address);
             infowindow.open(map, marker);
         }
    })(marker, i));
}



}
 


		
function displayZipText(response) {
if (!response) {
  alert('no response');
  return;
}
if (response.isError()) {
  alert('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
  return;
} 
  if (map.getZoom() < 11) return;
  FTresponse = response;
  //for more information on the response object, see the documentation
  //http://code.google.com/apis/visualization/documentation/reference.html#QueryResponse
  numRows = response.getDataTable().getNumberOfRows();
  numCols = response.getDataTable().getNumberOfColumns();
/*  var queryStr = "SELECT geometry, ZIP, latitude, longitude FROM "+ tableid + " WHERE ST_INTERSECTS(geometry, RECTANGLE(LATLNG"+map.getBounds().getSouthWest()+",LATLNG"+map.getBounds().getNorthEast()+"))";   
*/
  /*
     var kml =  FTresponse.getDataTable().getValue(0,0);
     // create a geoXml3 parser for the click handlers
     var geoXml = new geoXML3.parser({
                    map: map,
		    zoom: false
                });

     geoXml.parseKmlString("<Placemark>"+kml+"</Placemark>");
     geoXml.docs[0].gpolygons[0].setMap(null);
     map.fitBounds(geoXml.docs[0].gpolygons[0].bounds);
  */
  // alert(numRows);
  // var bounds = new google.maps.LatLngBounds();
  for(i = 0; i < numRows; i++) {
      var zip = response.getDataTable().getValue(i, 1);
      var zipStr = zip.toString()
      while (zipStr.length < 5) { zipStr = '0' + zipStr; }
      var point = new google.maps.LatLng(
          parseFloat(response.getDataTable().getValue(i, 2)),
          parseFloat(response.getDataTable().getValue(i, 3)));
      // bounds.extend(point);
      labels.push(new InfoBox({
	 content: zipStr
	,boxStyle: {
	   border: "1px solid black"
	  ,textAlign: "center"
	  ,fontSize: "8pt"
	  ,width: "50px"
	 }
	,disableAutoPan: true
	,pixelOffset: new google.maps.Size(-25, 0)
	,position: point
	,closeBoxURL: ""
	,isHidden: false
	,enableEventPropagation: true
      }));
      labels[labels.length-1].open(map);
  }
  // zoom to the bounds
  // map.fitBounds(bounds);
}




