var EDIT_PROFILE = {


    sha256has: function a(b) {
        function c(a, b) {
            return a >>> b | a << 32 - b
        }
        for (var d, e, f = Math.pow, g = f(2, 32), h = "length", i = "", j = [], k = 8 * b[h], l = a.h = a.h || [], m = a.k = a.k || [], n = m[h], o = {}, p = 2; 64 > n; p++)
            if (!o[p]) {
                for (d = 0; 313 > d; d += p) o[d] = p;
                l[n] = f(p, .5) * g | 0, m[n++] = f(p, 1 / 3) * g | 0
            } for (b += "\x80"; b[h] % 64 - 56;) b += "\x00";
        for (d = 0; d < b[h]; d++) {
            if (e = b.charCodeAt(d), e >> 8) return;
            j[d >> 2] |= e << (3 - d) % 4 * 8
        }
        for (j[j[h]] = k / g | 0, j[j[h]] = k, e = 0; e < j[h];) {
            var q = j.slice(e, e += 16),
                r = l;
            for (l = l.slice(0, 8), d = 0; 64 > d; d++) {
                var s = q[d - 15],
                    t = q[d - 2],
                    u = l[0],
                    v = l[4],
                    w = l[7] + (c(v, 6) ^ c(v, 11) ^ c(v, 25)) + (v & l[5] ^ ~v & l[6]) + m[d] + (q[d] = 16 > d ? q[d] : q[d - 16] + (c(s, 7) ^ c(s, 18) ^ s >>> 3) + q[d - 7] + (c(t, 17) ^ c(t, 19) ^ t >>> 10) | 0),
                    x = (c(u, 2) ^ c(u, 13) ^ c(u, 22)) + (u & l[1] ^ u & l[2] ^ l[1] & l[2]);
                l = [w + x | 0].concat(l), l[4] = l[4] + w | 0
            }
            for (d = 0; 8 > d; d++) l[d] = l[d] + r[d] | 0
        }
        for (d = 0; 8 > d; d++)
            for (e = 3; e + 1; e--) {
                var y = l[d] >> 8 * e & 255;
                i += (16 > y ? 0 : "") + y.toString(16)
            }
        return i
    },



    __HANDLE_EDIT_PROFILE_ADDRESS: function (requesturl, $this) {

        $.ajax({

            type: "get",

            url: requesturl,

            beforeSend: function () {

                $this.html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');

            },

            success: function (response) {
                $("#location-modal").html(response);
                $('#location-modal').modal('show');
            },
            error: function () {

                alert("Something went wrong. Please try again");
            },
            complete: function () {

                $this.html('');
            }

        });

    },
    __edit_email_address: function (form, $this) {

        $.ajax({
            type: "get",

            url: form.attr('action'),

            beforeSend: function () {

                $this.html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');

            },

            data: form.serialize(),

            dataType: "json",

            success: function (response) {

                if (parseInt(response.code) == 200) {
                    $("#error_message_email_success").html(response.message + ' ' + response.data.email);
                    $("#otp_hidden_hash").val(response.data.otp);
                    $("#otp_hidden_email").val(response.data.email);
                    $("#error_message_email_success").css('color', 'green');
                    $("#otp-modal").modal('show');
                    $("#email-modal").modal('hide');
                }

                if (parseInt(response.code) == 422) {
                    $("#error_message_email").html(response.message);
                    $("#error_message_email").css('color', 'red');
                }

            },
            error: function () {
                alert("Something went wrong. Please try again");
            },

            complete: function () {
                $this.html('Update');
            }

        });

    },


    __submit_otp_for_email_update: function () {

        var otp = $("#otp_input_").val();
        $("#opt_validation_error").html("");
        if (otp.length == 0) {
            $("#opt_validation_error").html("Please enter OTP received.");
            return false;
        }


        if (EDIT_PROFILE.sha256has(otp.toString()) != $("#otp_hidden_hash").val()) {
            $("#opt_validation_error").html("Your have entered invalid OTP.");
            return false;
        }

        $("#otp_submission_fomr").submit();

    },

    _get_delivery_address_pop_up_html: function (requesturl, $this) {


        $.ajax({

            type: "get",

            url: requesturl,

            beforeSend: function () {

                $this.html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');

            },

            dataType  :"html",

            success: function (response) {
                $("#edit_append_operating_hours_store").html(response);
                $('#modal_box_edit_delivery_address').modal('show');
            },
            error: function () {

                alert("Something went wrong. Please try again");
            },
            complete: function () {

                $this.html('');
            }

        });

    },

    __submit_edit_operating_hours: function () {

        var hours = businessHours.serialize();
        var is_atleast_one_working_hours_selected = false;
        $.each(hours, function (index, val) {
            if (val.isActive) {
                is_atleast_one_working_hours_selected = true;
            }
        });

        if (!is_atleast_one_working_hours_selected) {
            alert("You must select atleast one working hours");
            return false;
        }

        $("#workinghours_store").val(JSON.stringify(hours));
        $("#submit_working_hours").submit();

    },

    __initialise_map: function (lat, lng) {

        var myLatLng = { lat: lat, lng: lng };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
        });
    }
}




$("#update_store_address").validate(
    {
        errorClass: 'error',
        errorElement: 'span',
        ignore: [],
        rules: {

            formatted_address: {
                required: true,
            }

        },
        errorPlacement: function (error, element) {
            $(element).parent('div').parent("div").addClass('error-message');
            error.insertAfter(element);
        },
        success: function (label, element) {
            label.parent().parent().removeClass('error-message');
            label.remove();
        }
    });


    /**
     * @desc edit map functionality
     */

$('body').on('click', '#edit_address_store_update', function () {
    var $this = $(this);
    $('#location_modal_store').modal({backdrop: 'static', keyboard: false});

     
    var requesturl = $(this).attr('data-url-edit');
              
    var address = $('#store-address').val();
    EDIT_PROFILE.__HANDLE_EDIT_PROFILE_ADDRESS(requesturl,$this);
    $('#address').val(address);
    $('#location_modal_store').on('show.bs.modal', function () {
        $("#address").geocomplete({
            details: "#update_store_address",
            map: "#map_element",
            location: [
                $("#lat").val(),
                $("#lng").val(),

            ],
            componentRestrictions: { country: "us" }
        }).bind("geocode:result", function (event, result) {
            
            var lat=$("#lat").val();
            var lng=$("#lng").val();
       
           /**time zone API to get time zone */
        
            delete $.ajaxSettings.headers["X-CSRF-TOKEN"];
        
            $.ajax({
           
              url:`https://maps.googleapis.com/maps/api/timezone/json?location=`+lat+`,`+lng+`&timestamp=`+(Math.round((new Date().getTime())/1000)).toString()+`&key=`+localMsg.TIME_ZONE_API_KEY,
             })
           .done(function(response){
             
              $("#time_zone").val(response.timeZoneId);
       
           });
           /**end time zone */


            var map = $("#address").geocomplete('map');
            google.maps.event.trigger(map, "resize");
            map.setCenter(result.geometry.location);

 // console.log($("#lat").val(),$("#lng").val());


        });

    }).modal('show');
});



$('body').on('click', '#submit_otp', function () {
    EDIT_PROFILE.__submit_otp_for_email_update();
});

$('body').on('click', '#store_send_email', function () {
    var form = $("#edit_emai_address");
    EDIT_PROFILE.__edit_email_address(form, $(this));
});

$('body').on('click', '#submit_button', function () {
    EDIT_PROFILE.__submit_edit_operating_hours();
});

$(document).ready(function () {
    var lat = parseFloat($("#default_lat").val());
    var lng = parseFloat($("#default_lng").val());
    EDIT_PROFILE.__initialise_map(lat, lng);

});

// $("#store_desc_id").jQTArea({
//     setLimit: 140
//  });


//  $("#store_desc_id").characterCounter({


//     // shows total characters
//     renderTotal: false,
  
//     // increase counting
//     increaseCounting: false,
  
//     // characters limit
//     limit: 50, 
  
//     // allow one or more counters to be specified by a jQuery selector
//     counterSelector: false, 
  
//     // the element you wish to wrap your counter in.
//     counterWrapper: 'span', 
  
//     // // the CSS class to apply to your counter.
//     counterCssClass: 'help-block', 
  
//     // the format of your counter text where '%1' will be replaced with the remaining character count.
//     counterFormat: 'Characters Remaining: %1', 
  
//     // the CSS class to apply when your limit has been exceeded.
//     counterExceededCssClass: 'exceeded', 
  
//     // key value pairs of custom options to be added to the counter such as class, data attributes etc.
//     customFields: {}
  
//   }); 







  
 $('body').on('click', '#edit_address_store', function() {
      var $this = $(this);
      var requesturl = $(this).attr('data-url-edit');
      EDIT_PROFILE.__HANDLE_EDIT_PROFILE_ADDRESS(requesturl,$this);

   });


   $('body').on('click','#edit_operating_hours',function(){
      var request_url = $(this).attr('data-url-delivery-address');
      EDIT_PROFILE._get_delivery_address_pop_up_html(request_url,$(this));
   })

// driver function //







