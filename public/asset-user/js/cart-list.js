var APPLY_PROMO_CODE = {

    __handle_promo_code : function(code, url,orderId,$this) {

       $.ajax({
          type: "GET",
          url: url,
          data: {
             promo_code: code,
             id:orderId
          },
          dataType:'json',

          beforeSend : function()
          {
                $this.html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
          },
          success: function(data) {

                if(parseInt(data.code) == 200) {

                         $("#myModal-coupon-code").modal('hide');
                         location.reload();
                } else {
                   // alert(data.message);
                   $("#coupon_error").text(data.message).css('display','block');
                        setTimeout(() => {
                            $("#coupon_error").fadeOut();
                      }, 3000);
                }

          },
          complete : function() {

             $this.html('Apply');

          },
          error : function()
          {
                alert("Something went wrong. Please try again");
          }
       });

    }
 }

 $('body').on('click','.apply_button_promo_code',function(){

       var code = $(this).attr('data-promocode');
       var orderId = $("#order_id_cart").val();
       var url = $("#promo_code_submit_url").val();
       APPLY_PROMO_CODE.__handle_promo_code(code,url,orderId,$(this));

 });


$('body').on('click','#apply_button',function(){
   setTimeout(() => {
      $("#coupon_error").fadeOut();
  }, 3000);

    $("#coupon_error").text('');
    var code = $('#coupon_input').val();
    if(code=='' || code==null){
       $("#coupon_error").text('This field is required').css('display','block');
       return false;
    }
    var orderId = $("#order_id_cart").val();
    var url = $("#promo_code_submit_url").val();
    APPLY_PROMO_CODE.__handle_promo_code(code,url,orderId,$(this));
});



 $("body").on('click', '.show_move_to_wish_list_id', function() {

    var product_id = $(this).attr('data-product-id');
    var is_wish_list = $(this).attr('data-is_wish_list');
    var cartUid = $(this).attr('data-cartUid');
    $("#is_wishlisted_id").val(is_wish_list);
    $("#move_to_wish_list_id").val(product_id);
    $("#cart_uid").val(cartUid);
    $("#myModal-delete-address").modal('show');

 });

 $('body').on('click', '.remove_from_cart', function() {
    var cartUid = $(this).attr('data-cartUid');
    $("#cart_uid_remove").val(cartUid);
    $("#myModal-delete-cart-list").modal('show');
 });

 $('body').on('change','.quantity-update',function(){
     $this=$(this);
    var cartUid = $('option:selected', this).attr('data-cartuid');
    var qty = parseInt($(this).val());
    // $("#cart_uid_cart_update").val(cartUid);
    // $("#quantity_update_cart").val(qty);
    // $("#myModal-cart-update-quantity").modal('show');
    var size       = $(this).closest('.flex-row').find('.unit-update').val();
    var size_unit  = $(this).closest('.flex-row').find('option:selected').attr('data-unit');
    updateQuantity(cartUid,qty,$this,size,size_unit);

 });

 $('body').on('change','.unit-update',function(){
   var qty        = parseInt($('.quantity-update').val());
   var size       = parseInt($(this).val());
   var size_unit  = $('option:selected', this).attr('data-unit');
   var cartUid    = $('option:selected', this).attr('data-cartuid');

   $this=$(this);
   updateQuantity(cartUid,qty,$this,size,size_unit);

});

 $('body').on('change','#loyalty_point',function(){

    var orderId=$("#order_id_cart").val();
    $this=$(this);
    var is_redeam=2 //not redeam
    if($(this).prop('checked') == true){
       is_redeam=1;
     }

     loyaltyPoint(orderId,is_redeam);
 })


 function loyaltyPoint(orderId,is_redeam,$this) {
    $.ajax({
          type: "GET",
          url: $("#loyalty_point_redumption_url").val(),
          data: {
             orderId:orderId,
             is_redeam:is_redeam,
          },
          dataType:'json',

          beforeSend : function()
          {
            $("#spinner").html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:24px"></i>');
          },
          success: function(data) {
                if(parseInt(data.code) == 200) {
                     //   swal(data.message);

                       window.location.reload();

                } else {
                   // alert(data.message);
                   swal(data.message);
                }
          },
          complete : function() {

            $("#spinner").html('');

          },
          error : function()
          {
            swal("Something went wrong.Please try again");
          }
       });
 }



 function updateQuantity(orderId,qty,$this,size,size_unit) {
    $.ajax({
          type: "GET",
          url: $("#update_qty_url").val(),
          data: {
             cart_uid: orderId,
             quantity:qty,
             size:size,
             size_unit:size_unit
          },
          dataType:'json',
          beforeSend : function()
          {
            //  $(".full-loader").css("display","flex");
            $('#checkout').addClass('disabledbutton');
             $this.next('span').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:24px"></i>');
            //  $this.next().find('span').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:24px"></i>');
          },
          success: function(data) {
                if(parseInt(data.code) == 200) {
                        // swal({
                        //     text: "Quantity Updated",
                        //     type: "success",
                        //     icon: "success",
                        //     closeOnClickOutside: false,
                        // }).then((isConfirm) => {
                        //        if (isConfirm) {
                        //         location.reload();
                        //        }
                        //  })
                  $('#checkout').removeClass('disabledbutton');
                  location.reload();

                } else {
                  swal({
                     text: data.message,
                     type: "warning",
                     icon: "error",
                     closeOnClickOutside: false,
                 }).then((isConfirm) => {
                        if (isConfirm) {
                         location.reload();
                        }
                  })

                }
          },
          complete : function() {
            $this.next('span').html('');
            // $this.('select[name^="salesrep"] option[value="Bruce Jones"]').attr("selected","selected");

          },
          error : function()
          {
                swal("Something went wrong. Please try again");
          }
       });
 }

/**
 * @desc show warning messgae
 */

 function checkOrderAvailability(){
    swal({
       title:"Opps !!",
       text:"This order may contain some unavailable product please check",
       icon:"warning",
    })
 }


 function checkPlaceOrderAvailability(){
   swal({
      title:"Opps !!",
      text:"This order may contain some unavailable product",
      icon:"warning",
      closeOnClickOutside: false,
   }).then((isConfirm)=>{
       if(isConfirm){
          window.location.href=$("#cart-list-url").val();
       }
   })
}



/**
 * @desc open model of apply copoun
 */

 $(document).on('click','#open-promo-model',function(){

    $("#coupon_input").val('');
    $('#myModal-coupon-code').modal('show');

 })

