


         $(function () {
            $('.selectpicker').selectpicker({});
            });



/*******filter search ***************/

            $(".togglesrch").click(function(){
               $(this).parent().parent().parent().toggleClass("active");

                     if( $(this).parent().parent().parent().hasClass("active")){
                        $(this).attr("src","/asset-user-web/images/close-line.svg");
                     }
                     else{

                        $(this).attr("src","/asset-user-web/images/search-filter.svg");
                        $(".search input[type='text']").val('');
                        $('.list li').show();
                     }
            });

/*******filter search ***************/


/********Show more filter******/
function resetfulfilter(){
   $(".full_filter").removeClass("active");
   $(".filter_option_wrapper ").removeClass("active");
}


 $(".show-srch-filter").click(function(){
      resetfulfilter();
   $(this).parent().next().addClass("active");
 });           

 $(".show-more-filter").click(function(){
   // resetfulfilter();
    $(this).next().addClass("active");
}); 


 $(".close-full-filter").click(function(){
   $(".full_filter").removeClass("active");
   $(".filter_option_wrapper").removeClass("active");
 }); 





 /********Show more filter full js******/











   // $(window).scroll(function(){

             

            //    if (window.pageYOffset > 150) {

            //       $(".banner_block").addClass("active");
            //       } else {
            //       $(".banner_block").removeClass("active");
            //       }

            // })



            $(".filter_icon").click(function(){
               $(".mob_filter").toggleClass("active");
               $(".close_filter").removeClass("active");
            });
            
            $(".close_filter").click(function(){
               $(".mob_filter").removeClass("active");
            });
            
            
            
            
            $(".profile-mobile-menu").click(function(){
               $(".account-nav-col").toggleClass("active");
            });





            $(".list_icon").click(function(){
               $(".store_list_col").toggleClass("active");
            });
      
            $(".close_list").click(function(){
               $(".store_list_col").removeClass("active")
            });



            $(".search_mob").click(function(e){
               e.stopPropagation();
               $(".mob_location_srch").addClass("active");
            });
            
            
            
            
            $(document).on('click', 'body', function (e) {
               if (!$(e.target).is('.mob_location_srch, .mob_location_srch *')) {
                   $(".mob_location_srch").removeClass("active");
               }
            
            });
            
            
            $(".mobile-menu").click(function(){
               $(".head-nav").toggleClass("active")
            });