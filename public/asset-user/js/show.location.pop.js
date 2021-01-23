/**
 * javascript code for getting current lat lng from browser.
 */


var ALLOW_LOCATION = {

    __handle_permission: function () {

        navigator.permissions.query({
            name: 'geolocation'
        }).then(function (result) {

            if (result.state == 'granted') {
               
                navigator.geolocation.getCurrentPosition(function (position) {
                  
                    ALLOW_LOCATION.__update_user_current_location(position);

                });

            } else if (result.state == 'prompt') {
                

                navigator.geolocation.getCurrentPosition(function (position) {

                    console.log("Found your location \nLat : " + position.coords.latitude + " \nLang :" + position.coords.longitude);

                    ALLOW_LOCATION.__update_user_current_location(position);

                });
            } else if (result.state == 'denied') {
                ALLOW_LOCATION.__report_permisison_issues(result.state);

            }
            result.onchange = function () {

              

                if (result.state == 'granted') {
               
                    navigator.geolocation.getCurrentPosition(function (position) {
                      
                        ALLOW_LOCATION.__update_user_current_location(position);
    
                    });
    
                } else if (result.state == 'prompt') {
                    
    
                    navigator.geolocation.getCurrentPosition(function (position) {
    
                        ALLOW_LOCATION.__update_user_current_location(position);
    
                    });
                } else if (result.state == 'denied') {

                    ALLOW_LOCATION.__report_permisison_issues(result.state);
    
                }

            }

        });

    },
    __report_permisison_issues: function (state) {

        alert("You need to enable location permission for accessing our resources");
        
    },

    __update_user_current_location: function (position) {
            
        $.ajax({
            url: $("#location_submit_url").val(),
            type: 'GET',
            data: { lat: position.coords.latitude, lng: position.coords.longitude }
        });

    }

}




