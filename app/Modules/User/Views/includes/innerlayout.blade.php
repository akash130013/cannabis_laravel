<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">      
      <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta property="og:type" content="420 Kingdom" >
      <meta property="og:title" content="Hi, This is my cannabis referal code" >
      {{-- 
      <meta property="og:description" content="Prove your Star Trek geekhood! Are you wise like Yoda or Jar Jar Binks?" >
      --}}
      <title>Kingdom</title>
      <!-- Favicon -->
      <!-- <link rel="icon" type="image/png" href="{{asset('asset-user/images/fab.png')}}" /> -->
      <!-- Favicon End -->
      <link href="{{asset('asset-user/css/onboarding.css')}}" rel="stylesheet">
      <link href="{{asset('asset-user/css/media.css')}}" rel="stylesheet">
      <link href="{{asset('asset-admin/css/cropper.min.css')}}" rel="stylesheet" />
      <link href="{{asset('asset-admin/js/circle-loader/css/jCirclize.min.css')}}" rel="stylesheet">
      <link href="{{asset('asset-store/css/profile.css')}}" rel="stylesheet">
      <link href="{{asset('asset-user/js/smoke/css/graphics-icon.css')}}" rel="stylesheet">
      <link href="{{asset('asset-user/js/smoke/css/smoke.min.css')}}" rel="stylesheet">
      <link href="https://www.cssscript.com/demo/message-toaster/toast.css" rel="stylesheet">
      <link href="https://www.cssscript.com/demo/message-toaster/toast.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="{{asset('css/offline.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/offlinelang.css')}}">
      <script src="{{asset('asset-user-web/js/jquery.js')}}"></script>
      <!--salil css -->
      <link rel="shortcut icon" href="{{asset('asset-user-web/images/favicon.ico')}}" type="image/x-icon">
      <link rel="stylesheet" href="{{asset('asset-user-web/css/bootstrap.css')}}">
      <link rel="stylesheet" href="{{asset('asset-user-web/css/bootstrap-select.min.css')}}">
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/routine.css')}}" />
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/owl.carousel.min.css')}}">
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/inner-style.css')}}"/>
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/inner-media.css')}}"/>
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/media.css')}}"/>
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/aos.css')}}">
      <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/cannabis.css')}}">
      <!--end salil-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.2.17/jquery.timepicker.min.css"/>
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjN4ZWartGxRef-S_LYQWqhfCsWWvZBbI&libraries=places"></script>
      <script src="{{asset('asset-user/js/infinit.scroll.min.js')}}"></script>
      <link rel="stylesheet" href="{{asset('asset-user/css/list-nav.css')}}" type="text/css">
      <!--page css -->
      @yield('css')
   </head>
   <body>
      <div class="app_in_wrapper">
         <div class="full-loader" style="display:flex">
            <figure class="loader">
               <img src="{{asset('asset-user-web/images/cannabis-loader.gif')}}">
            </figure>
         </div>
         <!--header-->
         <!-- Header -->
         <!-- Header End -->
         <!-- Internal Container -->
         @yield('content')
         <!-- Form Container End -->
         <!-- Internal Container End -->
         <!-- Footer Starts -->
         <footer>
            <div class="foot-menu">
               <div class="custom_container">
                  <div class="foot-nav justify-content-center">
                     <ul>
                        <li> <a href="{{route('user.show.help.page')}}" class="line_effect" target="_blank">Help</a></li>
                        <li> <a href="{{route('user.show.about-us.page')}}" class="line_effect" target="_blank">About Us</a></li>
                        <li> <a href="{{route('user.show.contact-us.page')}}" class="line_effect" target="_blank">Contact Us</a></li>
                        <li> <a href="{{route('user.show.privacy-policy.page')}}" class="line_effect" target="_blank">Privacy Policy</a></li>
                        <li> <a href="{{route('user.show.terms-condition.page')}}" class="line_effect" target="_blank">Term &amp; Conditions</a></li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="foot_note">
               <p>&copy; <?php echo date("Y"); ?> 420 Kingdom. Trademarks and brands are the property of their respective
                  owners.
               </p>
            </div>
         </footer>
         <!-- Footer Ends -->
      </div>
      <input type="hidden" id="location_submit_url" value="{{route('user.update.current.location')}}">
      <form action="{{route('user.update.current.location')}}" id="update_curren_user_location">
         <input type="hidden" name="lat" id="global_lat" value="{{Auth::guard('users')->user()->lat ?? ''}}">
         <input type="hidden" name="lng" id="global_lng" value="{{Auth::guard('users')->user()->lng ?? ''}}">
         <input type="hidden" name="locality" id="global_locality" value="{{$data->city ?? ''}}">
         <input type="hidden" name="administrative_area_level_1" id="global_administrative_area_level_1">
         <input type="hidden" name="country" id="global_country" >
         <input type="hidden" name="postal_code" id="global_postal_code" value="{{$data->zipcode ?? ''}}">
         <input type="hidden" name="street_number" id="global_street_number">
         <input type="hidden" name="formatted_address" value="" id="global_formatted_address">
         <input type="hidden" name="ip" id="global_ip">
         <input type="hidden" name="route" id="global_route">
      </form>
      <input type="hidden" name="global_search" id="global_search" value="{{route('user.global-search')}}">
      <input type="hidden" name="global_search_lat" id="global_search_lat" value="{{session()->get('userdetail')->lat}}">
      <input type="hidden" name="global_search_lng" id="global_search_lng" value="{{session()->get('userdetail')->lng}}">
      <input type="hidden" id="product_error_url" value="{{asset('asset-user-web/images/product-error.jpg')}}">
      <input type="hidden" id="store_error_url" value="{{asset('asset-user-web/images/store-error.png')}}">
      <div id="snackbar"></div>
      @include('User::includes.global-search')
      <!--logout  Modal-->
      <div class="modal fade logout" id="logout" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close modal-close" data-dismiss="modal">
                  <img src="{{asset('asset-store/images/close-card.svg')}}"></button>
                  <h4 class="modal-title">Logout</h4>
               </div>
               <div class="modal-body">
                  <div class="modal-padding">
                     <p class="commn_para"> Are you sure you want to logout?</p>
                     <div class="flex-row m-t-b-30">
                        <div class="flex-col-sm-12 mt-50 mobile-space">
                           <a href="{{route('users.logout')}}">
                           <button class="custom-btn green-fill getstarted btn-effect">Logout</button>
                           </a>
                           <a class="ch-shd back line_effect" href="javascript:void(0)"  data-dismiss="modal">No, Cancel</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--logout Modal Close-->
      <!--product wish list -->
      <div class="push-notification-wrap" style="display:none">
         <span class="cross-icon"><img src="{{asset('asset-user-web/images/cancel.svg')}}"></span>            
         <div class="picture-wrap">
            <figure><img src="{{asset('asset-user-web/images/no-category.png')}}"></figure>
         </div>
         <div class="content-wrap">
            <h2 class="title" id="noti_head"></h2>
            <p class="notification-para" id="noti_text"></p>
         </div>
      </div>
      <!--end -->
      <!-- JS -->
      <script src="{{asset('asset-admin/js/lang/en/language.js')}}"></script>
      <script src="{{asset('asset-user-web/js/owl.carousel.min.js')}}"></script>
      <script src="{{asset('js/offline.js')}}"></script>
      <script src="{{asset('asset-user-web/js/bootstrap-select.js')}}"></script>
      <script src="{{asset('asset-user-web/js/app.js')}}"></script>
      <script src="{{asset('asset-user-web/js/bootstrap.min.js')}}"></script>
      <script src="{{asset('asset-user/js/common.js')}}"></script>
      <script src="{{asset('asset-user/js/show.location.pop.js')}}"></script>
      <script src="{{asset('asset-user-web/js/custom.js')}}"></script>
      <script src="{{asset('asset-store/js/toster.js')}}"></script>  
      <script src="{{ asset('asset-user/js/location/jquery.geocomplete.js')}}"></script>
      <script src="{{ asset('asset-user/js/global.location.autofill.js')}}"></script>
      <script src="{{asset('asset-user/js/global-search.js')}}"></script>
      <script src="{{asset('js/disable.autocomplete.js')}}"></script>
      <script src="{{asset('js/custom.autocompletedisable.js')}}"></script>
      <script src="{{asset('asset-user/js/sweet-alert.js')}}"></script>
      <script>   
         $(document).ready(function () {
            $(".search-input").click(function () {
               $(".head-nav").removeClass("active");
               $("#global_search_input").val('');
               $("input[name=search_type]").val("1");
               global_search('',1,0);
               $(".main_wrapper").addClass("search-open");
               $("#global_search_input").focus();
               $("body").css('overflow','hidden');
            });
            $(".close-icon").click(function () {
               $(".main_wrapper").removeClass("search-open");
               $("body").css('overflow','auto');
            });
         });
         
         
         
         
         
           //message-toaster
           var myToast = new Toast({
               title: '', 
               content: "@if(Session::has('success')) {{Session::get('success')['message'] }} @endif",
               append: false, // selector
               timeout: 10000,
               showProgress: true ,
               easing: 'quart-in-out',
               // warning, info, success, caution
               type: 'success'
         
           })
           @if(Session::has('success'))
             myToast.show();
           @endif
          
             Offline.options = {
               // to check the connection status immediatly on page load.
               checkOnLoad: false,
         
               // to monitor AJAX requests to check connection.
               interceptRequests: true,
         
               // to automatically retest periodically when the connection is down (set to false to disable).
               reconnect: {
                 // delay time in seconds to wait before rechecking.
                 initialDelay: 3,
         
                 // wait time in seconds between retries.
                 delay: 10
               },
         
               // to store and attempt to remake requests which failed while the connection was down.
               requests: true
             };
          
         $( window ).on("load", function() {
         // Handler for .load() called.'
              $(".full-loader").css("display","none");
         
         });
         
         
         
      </script>
      @yield('pagescript')
      <!-- JS End -->
   </body>
</html>