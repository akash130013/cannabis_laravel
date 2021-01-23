 var ADD_CARD_AND_WISHLIST = {

      __handle_add_card: function(store_id, size, unit) {

         $("#selected_selling_store_id").val(store_id);
         $("#selected_selling_size").val(size);
         $("#selected_selling_unit_id").val(unit);
         $("#submit_product_add_card").submit();

      },
   }


function buyNowFun(params) {
   
   var is_size_selected = false;
      var size_qty;
      var unit;

      $('#select_ul_items li').each(function(index, ele) {
         if ($(ele).find('a').hasClass('active')) {
            size_qty = $(ele).find('a').attr('data-size-unit');
            unit = $(ele).find('a').attr('data-unit');
            is_size_selected = true;
         }
      });

      if (!is_size_selected) {
         alert('Please select from available units');
         return false;
      }

      $("input[name=is_buy]").val("1");
      var store_id = $("#first_store_seller_id").val();
      ADD_CARD_AND_WISHLIST.__handle_add_card(store_id, size_qty, unit);
}



   // driver function for add card //size

   $('body').on('click', '#add_cart_button', function() {

      var is_size_selected = false;
      var size_qty;
      var unit;

      $('#select_ul_items li').each(function(index, ele) {
         if ($(ele).find('a').hasClass('active')) {
            size_qty = $(ele).find('a').attr('data-size-unit');
            unit = $(ele).find('a').attr('data-unit');
            is_size_selected = true;
         }
      });

      if (!is_size_selected) {
         alert('Please select from available units');
         return false;
      }

     
      var store_id = $("#first_store_seller_id").val();
      ADD_CARD_AND_WISHLIST.__handle_add_card(store_id, size_qty, unit);
   });


   $("body").on('click', '.select_item', function() {
      $('.select_item').removeClass('active');
      var offered_price=$(this).data('offered_price');
      var actual_price=$(this).data('actual_price');
      // var available_stock=$(this).data('actual_price');
      $("#available-error").text('');
      $(this).addClass('active');
      var is_card_added=$(this).data('is_card_added');
      var go_to_cart=$("input[name=go_to_cart]").val();
      if(is_card_added==1){
         $('.cart_btn').text('Go To Cart').attr('href', go_to_cart).removeAttr('id');
      }else{
         $('.cart_btn').text('Add To Cart').attr('href', 'javascript:void(0)').attr('id','add_cart_button');
      }
      if(offered_price==0){
         $("#discount_price").text('$ '+actual_price);
         $("#actual_price").text('');
      }

      if(offered_price>0){
         $("#discount_price").text('$ '+offered_price);
         $("#actual_price").text('$ '+actual_price);
      }
      $("#card-add-div").removeClass("disabledbutton");
      // $("#discount_price").text('$ '+($(this).data('offered_price')))
   });

   $("body").on('click', '.submit_action_add_wish_list', function() {
      $(this).html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
      $("#wish_list_submit_form").submit();
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
