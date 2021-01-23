   
   
      /**
      * Pagination and show detail
      */

        $(document).ready(function () {

            $('#scroller').infiniteScroll({
               // options
               path: '.next',
               append: '.item',
               history: false,
               status: '.scroller-status',
               checkLastPage: true,
               hideNav: '.pagination'
            });
      
      
             $("#track-order").click(function () {
               
                
                $(".order-detail-sidebar").addClass("active");
             });
             $(".wrapper img").click(function () {
                $(".order-detail-sidebar").removeClass("active");
             });
          });
      
      
          /**
           * 
           * @param {*} id
           * @desc show detail 
           */
          function showDetail(id) {
            $("#track_"+id).addClass('active');
          }
      
      
          //*form filter data
      $("body").on("click",'.all_filter',function(){
         var num=$(this).data('num');
         $('.check_'+num).prop('checked',true);    
          $("#filterFormId").submit(); 
      
      });


//////////////////////////////////////////////////////////////////rating and review/////
$("body").on('click','.rateUsClass',function(){

     var data=$(this).data('item');
      $("#product_display").html('');

   //   data.cartSummary.forEach(element => {
      data.cartSummary.forEach(function (element, i) {
         console.log(i);
         
        $("#product_display").append(`
      <div class="product_append" id="div_`+i+`" data-product-id="`+element.product_id+`">
        <h3 class="txt_title m-t-b-30">How was the Product `+element.product_name+`(`+element.size+`) ?</h3>
                 <input type="hidden"  id="rate_`+element.product_id+`_`+element.size+`" class="product_rating">
                 <input type="hidden"   class="product_id" value="`+element.product_id+`">

                 <div class="reviw_leaf">
                <ul id="ul_`+i+`" data-product-id="`+element.product_id+`" data-size="`+element.size+`">
                  <li>
                     <a href="javascript:void(0)" class="txt_review" data-product-rating=1>
                        <figure></figure> Horrible
                     </a>
                  </li>

                  <li>
                     <a href="javascript:void(0)" class="txt_review" data-product-rating=2>
                        <figure></figure> Bad
                     </a>
                  </li>

                  <li>
                     <a href="javascript:void(0)" class="txt_review" data-product-rating=3>
                        <figure></figure> Average
                     </a>
                  </li>

                  <li>
                     <a href="javascript:void(0)" class="txt_review" data-product-rating=4>
                        <figure></figure> Good
                     </a>
                  </li>

                  <li>
                     <a href="javascript:void(0)" class="txt_review" data-product-rating=5>
                        <figure></figure> Excellent
                     </a>
                  </li>

                    </ul>
                 </div>
                 <span class="error fadeout-error"></span>
                  <div class="form-field-group">
                     <div class="text-field-wrapper">
                        <textarea class="txt_about_review" maxlength="500" placeholder="More detailed reviews get more visibility..."></textarea>
                     </div>
                 </div> 
           </div>      
        `)
     });

     ///for store

      $("#store_model_div").html('');    
      $("#store_model_div").html(`
      <h3 class="txt_title m-t-b-30">Rate Your Experience with the store `+data.store_name+` ?</h3>
             <input type="hidden" id="store_id" value="`+data.store_id+`">
             <input type="hidden" id="store_rating" value="">
             <input type="hidden" id="order_uid" value="`+data.order_uid+`">

            <div class="reviw_store">
               <ul>
                  <li>
                     <a href="javascript:void(0)" class="txt_review" data-store-rating=1>
                        <figure></figure> Horrible
                     </a>
                  </li>
                  <li>
                     <a href="javascript:void(0)" class="txt_review" data-store-rating=2>
                        <figure></figure> Bad
                     </a>
                  </li>
                  <li>
                     <a href="javascript:void(0)" class="txt_review" data-store-rating=3>
                        <figure></figure> Average
                     </a>
                  </li>
                  <li>
                     <a href="javascript:void(0)" class="txt_review" data-store-rating=4>
                        <figure></figure> Good
                     </a>
                  </li>
                  <li>
                     <a href="javascript:void(0)" class="txt_review" data-store-rating=5>
                        <figure></figure> Excellent
                     </a>
                  </li>
               </ul>
            </div>
            <span class="error fadeout-error"></span>

            <div class="form-field-group">
               <div class="text-field-wrapper">
                  <textarea class="txt_about_review store_text" placeholder="More detailed reviews get more visibility..." maxlength="500"></textarea>
               </div>
            </div>

      `);
     
   /////driver model div..
      $("#driver_model_div").html('');    
      $("#driver_model_div").html(`
       <h3 class="txt_title m-t-b-30">Delivery experience by `+data.distributor_name+` ?</h3>
       <input type="hidden" id="driver_id" value="`+data.distributor_id+`">
       <input type="hidden" id="driver_rating" value="">

       <div class="reviw_star">
          <ul>
             <li>
                <a href="javascript:void(0)" class="txt_review" data-driver-rating="1">
                   <figure></figure> Horrible
                </a>
             </li>
             <li>
                <a href="javascript:void(0)" class="txt_review" data-driver-rating=2>
                   <figure></figure> Bad
                </a>
             </li>
             <li>
                <a href="javascript:void(0)" class="txt_review" data-driver-rating=3>
                   <figure></figure> Average
                </a>
             </li>
             <li>
                <a href="javascript:void(0)" class="txt_review" data-driver-rating=4>
                   <figure></figure> Good
                </a>
             </li>
             <li>
                <a href="javascript:void(0)" class="txt_review" data-driver-rating=5>
                   <figure></figure> Excellent
                </a>
             </li>
          </ul>
       </div>
       <span class="error fadeout-error"></span>

       <div class="form-field-group">
          <div class="text-field-wrapper">
             <textarea class="txt_about_review driver_text"
                placeholder="More detailed reviews get more visibility..." maxlength="500"></textarea>
          </div>
       </div>
       `);



     $('#review_modal').modal('show');

    
   })       
 
     /** Rating **/
     //for product
          function reset_leaf(div_id) {
             $(".reviw_leaf ul li a.txt_review").removeClass("active");
          }
       
             $('body').on('click','.reviw_leaf ul li a.txt_review',function(){
           
             var pro_id=$(this).parent().parent().data('product-id');
             var size=$(this).parent().parent().data('size');
            $("#rate_"+pro_id+`_`+size).val($(this).data('product-rating'));

            $(this).parent().parent().children().children().removeClass('active');
             $(this).parent().prevAll().children().addClass('active');
 
            $(this).toggleClass("active");
            
            // $(this).next('.error:first').text('');
         });

     //  for the store
         function reset_store() {
            $(".reviw_store ul li a.txt_review").removeClass("active");
         }
          $('body').on('click','.reviw_store ul li a.txt_review',function(){
               // reset_store();
               $(this).parent().parent().children().children().removeClass('active');
               $(this).parent().prevAll().children().addClass('active');

               $("#store_rating").val($(this).data('store-rating'));
               $(this).toggleClass("active");
               $("#store_model_div").find('.error').text('');
            });

         ////for driver
          function reset_star() {
             $(".reviw_star ul li a.txt_review").removeClass("active");
          }

         
            $('body').on('click','.reviw_star ul li a.txt_review',function(){
             reset_star();
             
             $(this).parent().parent().children().children().removeClass('active');
             $(this).parent().prevAll().children().addClass('active');

            $("#driver_rating").val($(this).data('driver-rating'));
            $(this).toggleClass("active");
            $("#driver_model_div").find('.error').text('');
         });
          

         
          /** Rating **/
 
          /** Steps **/
         //  var jsonArr = [];
         var jsonArr = [];

          $("#next_step2").click(function () {
            $(".error").text('');
            var flag=1;
            $(".product_append").each(function(index){
               
               var rating=$(this).find('.product_rating').val();
               
               if(rating==''){
                  $(this).find('.error').text('Rating cannot be empty');
                  flag=0;
                  return;
               }
                   jsonArr.push({
                       order_uid:$("#order_uid").val(),
                       type:'product',
                       rated_id:$(this).find('.product_id').val(),
                       rate: $(this).find('.product_rating').val(),
                       review:$(this).find('.txt_about_review').val(),
                   });
               
            })
            if(flag==0){
               return false;
            }

             $(".step1").hide();
             $(".step2").show();
            
          });

         ///for the store view
          $("#next_step3").click(function () {
            var rating=$('#store_rating').val();
            if(rating==''){
               $("#store_model_div").find('.error').text('Rating cannot be empty');
               return false;
            }
            jsonArr.push({
               order_uid:$("#order_uid").val(),
               type:'store',
               rated_id:$('#store_id').val(),
               rate: $('#store_rating').val(),
               review:$('.store_text').val(),
           });

             $(".step2").hide();
             $(".step3").show();
          });

     /**
      * @desc for the driver rating
      */
          $("#next_step4").click(function () {
            var rating=$('#driver_rating').val();
            if(rating==''){
               $("#driver_model_div").find('.error').text('Rating cannot be empty');
               return false;
            }
            jsonArr.push({
               order_uid:$("#order_uid").val(),
               type:'driver',
               rated_id:$('#driver_id').val(),
               rate: $('#driver_rating').val(),
               review:$('.driver_text').val(),
           });
        
         $.ajax({
            type: "get",
            url: $("#review_rating_url").val(),
            data: {
                "jsonArr": jsonArr,
            },
            cache: false,
            beforeSend: function () {
                $("#next_step4").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            },
            dataType: 'json',
            success: function (response) {
                if (parseInt(response.code) == 200) {
                       $("#final_rating").text(`(`+response.data+`)`);
                        $(".step3").hide();
                        $(".step4").show();
                     }else{
                     alert('Something went wrong.. Please try again');
                     window.location.reload();   
                     }
                    } ,
            error: function () {
                alert('Something went wrong.. Please try again');
                window.location.reload();  
            },
            complete: function () {
                $("#next_step4").html('');               
            }
        });


            return false;
           
          });
          /** Steps **/


          /**
           * @desc skip functionality
           */
          $("#skip_product").click(function () {
            $(".step1").hide();
             
            $(".step2").show();
         });

         $("#skip_store").click(function () {
            $(".step2").hide();
            $(".step3").show();
         });
       
        $("body").on('click','#skip_driver',function(){
           window.location.href=$("#order_url").val();
        })
     
 
       $('#review_modal').on('hidden.bs.modal',   //when user close model
           function(){     
            //   console.log("adada");
              $(".reviw_leaf ul li a.txt_review").removeClass("active");
              $(".reviw_star ul li a.txt_review").removeClass("active");
             $(".step1").show();
             $(".step2").hide();
             $(".step3").hide();
             $(".step4").hide();
          $(this).find('form')[0].reset();       
          $(this).find('form')[1].reset();  
          $(this).find('form')[2].reset(); 
          $(this).find('form')[3].reset();       

        });
 
///for selecting star and leaf
$('#leafs li').on('click', function () {
   var onStar = parseInt($(this).data('value'));
   var stars = $(this).parent().children('li.leaf');

   for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('active');
   }

   for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('active');
   }
});


$('#stars li').on('click', function () {
   var onStar = parseInt($(this).data('value'));
   var stars = $(this).parent().children('li.star');

   for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('active');
   }

   for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('active');
   }
});






      //   For cancelling user order

     
      $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });

      $("body").on('click','.cancel-order',function()
      {
         swal({
            title: localMsg.BeSure,
            text: "Do you really want to cancel your order ?",
            type: "warning",
            icon:"warning",
            buttons: ["No", "Cancel order!"],
            showCancelButton: true,
            cancelButtonClass: 'btn-danger btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            cancelButtonText: "No",
            cancel:true,
            closeOnClickOutside: true,
            closeOnEsc: true
        }).then((isConfirm) => {
               if (isConfirm) {
                  let orderUid = $(this).val();
                  cancelOrder(orderUid);
               }
         })

      })

      function cancelOrder(order_uid)
      {
         $.ajax({
            type: "post",
            url: '/user/cancel-order',
            data: {
                "order_uid": order_uid,
            },
            beforeSend: function () {
               
            },
            success: function (response) {
                if (parseInt(response.code) == 200) 
                {
                  //  return false;
                  swal(response.message).then(()=>{
                     window.location.reload();   
                  })
                  // window.location.reload();   
                }
               else
                  {
                     alert('Something went wrong.. Please try again');
                     window.location.reload();   
                  }
               },
            error: function () {
                alert('Something went wrong.. Please try again');
                window.location.reload();  
            },
        });
      }

      /**
       * Managing Re-order of users
       * 
       * 
       */
     
      $("body").on('click','.re-order',function()

      {
         swal({
            title: localMsg.BeSure,
            text: "Do you really want to re-order this product ?",
            type: "info",
            icon:"info",
            buttons: ["No", "Re-order !"],
            showCancelButton: true,
            cancelButtonClass: 'btn-danger btn-md waves-effect',
            confirmButtonClass: 'btn-info btn-md waves-effect waves-light',
            // cancelButtonText: localMsg.Cancel,
            cancel:true,
            closeOnClickOutside: true,
            closeOnEsc: true
        }).then((isConfirm) => {
               if (isConfirm) {
                  let orderUid = $(this).val();
                  reOrder(orderUid);
               }
         })

      })

      function reOrder(order_uid)
      {
         $.ajax({
            type: "post",
            url: '/user/re-order',
            data: {
                "order_uid": order_uid,
            },
            beforeSend: function () {
               
            },
            success: function (response) {
                if (parseInt(response.code) == 200) 
                {
                   swal(response.message).then(()=>{
                     window.location.href = $('#cart-listing-url').val();   
                  })
                }
               else
                  {
                     alert('Something went wrong.. Please try again');
                     // window.location.reload();   
                  }
               },
            error: function () {
                alert('Something went wrong.. Please try again');
               //  window.location.reload();  
            },
        });
      }



      /**track my order html */

      function initialize(locations){
         // locations =  $.parseJSON(locations);
          var myLatlng = new google.maps.LatLng(locations.latitude,locations.longitude);
          var myOptions = {
              zoom: 4,
              center: myLatlng,
              mapTypeId: google.maps.MapTypeId.ROADMAP
              }
           map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
           var marker = new google.maps.Marker({
               position: myLatlng, 
               map: map,
               icon:'/asset-store/images/LocationYellow.svg',
              title:locations.store_name,
          });
     } 

   //  $( window ).on("load", function() {
   //        var locations = $("#location_json").val();
   //       //  console.log(loca);
          
   //    // Handler for .load() called.'
   //    initialize(locations);
      
   //  }); 

/**
 * track my order
 */
    $(document).on('click','.track-my-order',function(){
     var $this=$(this);
     var order_uid=$(this).data('order_uid');
 
 if(order_uid!=''){
      $.ajax({
         type: "get",
         url: $("#track_order_url").val(),
         data: {
             "order_uid": order_uid,
         },
         beforeSend: function () {
            $this.html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
         },
         success: function (response) {
             if (parseInt(response.code) == 200) 
             {
               
               $('#track-order-html').modal({backdrop: 'static', keyboard: false});
               initialize(response.data);  
             }
            else
               {
                  alert('Something went wrong.. Please try again');
                     
               }
            },
         error: function () {
             alert('Something went wrong.. Please try again');
             
         },
         complete:function(){
            $this.html("Track Order");
         }
     });

   }else{
      swal("Something went wrong!! Please try again");
      
   }
    })

  
  