

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

                       
            },
            complete: function () {
                $("#search_loader").html('');
            }

        });


    }

}


$( "#address" ).autocomplete({
    source: function( request, response ) {
      $.ajax({
        url: $("#url_search_zip_code").val(),
        dataType: "json",
        data: {
          q: request.term
        },
        beforeSend: function () {
            $("#search_loader_icon").html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
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
            }
            else{
            response( data );
            }
        },
        complete : function() {

            $("#search_loader_icon").html('<i class="fa fa-search" aria-hidden="true"></i>');
        }
      });
    },
    minLength: 1,
    select: function( event, ui ) {

      
        if (ui.item.value === "No matches found") {
            $(this).val('');
            $('#address').val('');
            return false;
        }
       
        $("#address").val(ui.item.zipcode);
        // console.log(ui.item.zipcode,'kkkk');
        localStorage.setItem("zipcode", ui.item.zipcode);
        codeAddress();
    },
    create: function () {
        $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
           
            return (item.id) ?  $('<li>')
                .append( "<a>" + item.value +"</a>" )
                .appendTo(ul) : ((typeof item.value!= 'undefined') ? $('<li>').append("<a>" + item.value +"</a>").appendTo(ul) : $('<li>'));     
          
         };
       }
  });


