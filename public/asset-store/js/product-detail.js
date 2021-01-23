
$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


var HANDLE_PRODUCT_ADD = {


    errors : {

        "product_required" : "Please enter product",
    },


    __remove_product_information: function (id) {


        $.ajax({

            type: 'GET',

            url: $("#product_delete_url").val(),

            data: { productID : id },

            dataType : "json",

            beforeSend : function() {
                    $("#delete_product").html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            },  

            success: function (response) {
                    // window.location = $("#product_list_url").val();
                    if(response.code==200){
                        window.location.href=$("#product_list_url").val();
                    }else{
                       swal("Something went wrong please try again");
                     }
            },
            complete : function() {
                    $("#delete_product").html('Delete');
            }

        });
    }

}


function validate(evt) {
    var theEvent = evt || window.event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}



$('body').on('click','#delete_product',function(){
   
    $('#deleteModal').modal('show');

});


$('body').on('click','.deleteBtn',function(){
    var productID =$("#stockId").val();
   
    if(productID) {

        HANDLE_PRODUCT_ADD.__remove_product_information(productID);
    }else{
        alert("Somethig went wrong.. Please try agin");
    }

});


(function($) {
    $(document).ready(function() {

       var sync1 = $("#sync1");
       var sync2 = $("#sync2");
       var slidesPerPage = 4; //globaly define number of elements per page
       var syncedSecondary = true;

       sync1.owlCarousel({
          items: 1,
          slideSpeed: 1000,
          nav: false,
          autoplay: false,
          dots: false,
          responsiveRefreshRate: 200
          // navText: ["<i class='fa fa-angle-left' class='sas'></i>", "<i class='fa fa-angle-right'></i>"],
       }).on('changed.owl.carousel', syncPosition);

       sync2
          .on('initialized.owl.carousel', function() {
             sync2.find(".owl-item").eq(0).addClass("current");
          })
          .owlCarousel({
             items: slidesPerPage,
             dots: false,
             nav: false,
             // center:true,
             smartSpeed: 100,
             slideSpeed: 400,
             autoplay: false,

             responsive: {
                0: {
                   items: 1
                },
                690: {
                   items: 3
                },
                768: {
                   items: 4
                },
                1100: {
                   items: 4
                },
                1200: {
                   items: 4
                }
             },

             URLhashListener: true,
             startPosition: 'URLHash',
             slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
             responsiveRefreshRate: 100
          }).on('changed.owl.carousel', syncPosition2);

       function syncPosition(el) {
          //if you set loop to false, you have to restore this next line
          var current = el.item.index;



          sync2
             .find(".owl-item")
             .removeClass("current")
             .eq(current)
             .addClass("current");
          var onscreen = sync2.find('.owl-item.active').length - 1;
          var start = sync2.find('.owl-item.active').first().index();
          var end = sync2.find('.owl-item.active').last().index();

          if (current > end) {
             sync2.data('owl.carousel').to(current, 100, true);
          }
          if (current < start) {
             sync2.data('owl.carousel').to(current - onscreen, 100, true);
          }
       }

       function syncPosition2(el) {
          if (syncedSecondary) {
             var number = el.item.index;
             sync1.data('owl.carousel').to(number, 100, true);
          }
       }

       sync2.on("click", ".owl-item", function(e) {
          e.preventDefault();
          var number = $(this).index();
          sync1.data('owl.carousel').to(number, 300, true);
       });
    });


 })(jQuery);





