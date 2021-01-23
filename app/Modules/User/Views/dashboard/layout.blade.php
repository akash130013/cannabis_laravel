<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">      
      <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Kingdom</title>
      <!-- Favicon -->
      <!-- <link rel="icon" type="image/png" href="{{asset('asset-user/images/fab.png')}}" /> -->
      <!-- Favicon End -->
      <link href="{{asset('asset-admin/css/cropper.min.css')}}" rel="stylesheet" />
      <link href="{{asset('asset-admin/js/circle-loader/css/jCirclize.min.css')}}" rel="stylesheet">
      <link href="{{asset('asset-store/css/profile.css')}}" rel="stylesheet">
      <!--salil css -->
      <link rel="shortcut icon" href="{{asset('asset-user-web/images/favicon.ico')}}" type="image/x-icon">
   <link rel="stylesheet" href="{{asset('asset-user-web/css/bootstrap.css')}}">
   <link rel="stylesheet" href="{{asset('asset-user-web/css/bootstrap-select.min.css')}}">
   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/routine.css')}}" />
   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/style.css')}}" />
   {{-- <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user/css/onboarding.css')}}"/> --}}

   
   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/inner-style.css')}}"/>
   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/inner-media.css')}}"/>

   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/media.css')}}"/>
   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/owl.carousel.min.css')}}">
   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/aos.css')}}">
      <!--end salil-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.2.17/jquery.timepicker.min.css"/>
      @yield('css')
   </head>
   <body>
      <div class="app_wrapper">
            <div class="full-loader" style="display:flex">
                  <figure class="loader">
                     <img src="{{asset('asset-user-web/images/cannabis-loader.gif')}}">
                  </figure>
            </div>
         
         <!-- Header -->
         @yield('header')
         <!-- Header End -->

         <!-- Internal Container -->
         @yield('content')
         <!-- Form Container End -->
        
         <!-- Footer Starts -->
         <footer>
            <div class="foot-menu">
               <div class="custom_container">
                  <div class="foot-nav justify-content-center">
                     <ul>
                        <li> <a href="#" class="line_effect">Help</a></li>
                        <li> <a href="#" class="line_effect">About Us</a></li>
                        <li> <a href="#" class="line_effect">Contact Us</a></li>
                        <li> <a href="#" class="line_effect">Privacy Policy</a></li>
                        <li> <a href="#" class="line_effect">Term &amp; Conditions</a></li>
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

      <!-- The Modal -->
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
<!--end model-->

      </div>
      <!-- JS -->
      <script src="{{asset('asset-user-web/js/jquery.js')}}"></script>
      <script src="{{asset('asset-user-web/js/owl.carousel.min.js')}}"></script>
      <script src="{{asset('asset-user-web/js/bootstrap-select.js')}}"></script>
      <script src="{{asset('asset-user-web/js/app.js')}}"></script>
      <script src="{{asset('asset-user-web/js/bootstrap.min.js')}}"></script>
      <script src="{{asset('asset-user/js/common.js')}}"></script>
      <script src="{{asset('asset-user-web/js/custom.js')}}"></script>
      <script src="{{asset('js/disable.autocomplete.js')}}"></script>
      <script src="{{asset('js/custom.autocompletedisable.js')}}"></script>
    
      <script>
      $( window ).on("load", function() {
      // Handler for .load() called.'
         $(".full-loader").css("display","none");
      
      });
      </script>
      @yield('pagescript')
      <!-- JS End -->
   </body>
</html>