

var ADD_DELIVERY_LOCATION = {

    __change_location_status: function (id, status) {


        $.ajax({

            type: 'GET',

            url: 'ajax-request/update-location-status',

            data: { id: id, status: status },

            beforeSend: function () {
                $("#search_loader").html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            },

            success: function (data) {

                        // console.log(data);
            },
            complete: function () {
                $("#search_loader").html('');
            }

        });


    }

}


// driver function code //

$('body').on('click', '#submit_store_location', function () {
    var address = $("#address").val();
    if(address == "") {
        swal({
            title: "Location",
            text: "Please search by zip code to proceed",
            type: "warning"
            
            });
        return false;
    }
    $("#submit_hidden_params").submit();
});

$('body').on('click','#searchMapButton',function(){
    
    codeAddress();
})

$("body").on('click', '#searchInputButton', function () {
    $("#submit_form_location").submit();
});



$("body").on('change', '#select_box_area', function () {
    $("#submit_form_location").submit();
});
$("body").on('change', '.change-status', function () {
    var $val = $(this).attr('data-val');
    var $status = $(this).is(':checked');
    ADD_DELIVERY_LOCATION.__change_location_status($val,$status);

});

$('body').on('click','.delete-button',function(){

    swal("Are you sure you want to delete ?",{
        buttons: {
            cancel: "Dismiss",
            catch: {
              text: "Yes, Delete!",
              value: "catch",
            }
          },
    }).then((value) => {
        switch (value) {

          case "catch":
            var url = $(this).attr('data-href');
            window.location = url;
            break;
        }

      });
});

$('body').on('click','.status-button',function(){

    swal({
        title:'Location Status',
        text:$(this).attr('data-lang'),
        buttons: {
            cancel: "Dismiss",
            catch: {
              text: $(this).attr('data-msg'),
              value: "catch",
            }
          },
    }).then((value) => {
        switch (value) {

          case "catch":
            var url = $(this).attr('data-href');
            window.location = url;
            break;
        }

      });
});

$( "#address" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url: $("#url_search_zip_code").val(),
        dataType: "json",
        beforeSend : function() {
            $('.detect-icon').html('<i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>')
        },
        data: {
          q: request.term
        },
        success: function( data ) {
            if(!data.length){
                var result = [
                    {
                        label: 'No matches found',
                        value: response.term
                    }
                ];
                response(result);
            } else {
                response( data );
            }

        },
        complete : function() {
            $('.detect-icon').html('<i class="search icon"></i>')
        }
      });
    },
    minLength: 3,
    select: function( event, ui ) {
        if (ui.item.value === "No matches found") {
            $(this).val('');
            $('#address').val('');
            return false;
        }
        console.log(ui.item.zipcode);
        $("#address").val(ui.item.address);
        $("#zipcode").val(ui.item.zipcode);
       
        localStorage.setItem("zipcode", ui.item.zipcode);
        $("#searchMapButton").click();
      
    },
    create: function () {
        $(this).data('ui-autocomplete')._renderItem = function (ul, item) {

            return (item.id) ?  $('<li>')
                .append( "<a>" + item.value +"</a>" )
                .appendTo(ul) : ((typeof item.value!= 'undefined') ? $('<li>').append("<a>" + item.value +"</a>").appendTo(ul) : $('<li>'));

         };
       }
  });


