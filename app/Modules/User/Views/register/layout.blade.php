<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">      
      <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Kingdom</title>
      
      <!-- Favicon -->
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
   

   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/inner-media.css')}}"/>
   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user/css/media.css')}}"/>
   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/owl.carousel.min.css')}}">
   <link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/aos.css')}}">
      <!--end salil-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.2.17/jquery.timepicker.min.css"/>
      <link rel="stylesheet" href="{{asset('asset-user-web/css/cannabis.css')}}">
      @yield('css')
   </head>
   <body>
        <!--App Wrapper-->
        <div class="app_wrapper" @if(\Request::route()->getName()=="user.home")style="display:block"@endif>
         
         <!-- Header -->
         @yield('header')
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

                        <li> <a href="{{route('user.help.page')}}" class="line_effect" target="_blank">Help</a></li>
                        <li> <a href="{{route('user.about.page')}}" class="line_effect" target="_blank">About Us</a></li>
                        <li> <a href="{{route('user.contact-us.page')}}" class="line_effect" target="_blank">Contact Us</a></li>
                        <li> <a href="{{route('user.privacy-policy.page')}}" class="line_effect" target="_blank">Privacy Policy</a></li>
                        <li> <a href="{{route('user.terms-condition.page')}}" class="line_effect" target="_blank">Term &amp; Conditions</a></li>

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

    
      
     
      @yield('pagescript')
      <!-- JS End -->
   </body>
</html>