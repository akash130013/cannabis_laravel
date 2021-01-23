<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">      
      <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>420 Kingdom</title>
      <!-- Favicon -->
      <link rel="icon" type="image/png" href="{{asset('asset-store/images/cannabis_leaf.ico')}}" />
      <!-- Favicon End -->
      <link href="{{asset('asset-store/css/bootstrap.min.css')}}" rel="stylesheet">
      <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
      <link rel="stylesheet" href="https://ericjgagnon.github.io/wickedpicker/wickedpicker/wickedpicker.min.css">
      <link href="{{asset('asset-store/css/routine.css')}}" rel="stylesheet">
      <link href="{{asset('asset-store/css/footer.css')}}" rel="stylesheet">
      <link href="{{asset('asset-store/css/style.css')}}" rel="stylesheet">
      <link href="{{asset('asset-store/css/media.css')}}" rel="stylesheet">
      <link href="{{asset('asset-store/css/header.css')}}" rel="stylesheet">
      <link href="{{asset('asset-store/css/onboarding.css')}}" rel="stylesheet">
      <link href="{{asset('asset-admin/css/cropper.min.css')}}" rel="stylesheet" />
      <link href="{{asset('asset-admin/js/circle-loader/css/jCirclize.min.css')}}" rel="stylesheet">
      <link href="{{asset('asset-store/css/profile.css')}}" rel="stylesheet">
      <link href="{{asset('asset-store/css/tooltip.css')}}" rel="stylesheet">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.2.17/jquery.timepicker.min.css"/>
      <!-- <link href="{{asset('asset-store/js/Semantic-UI-master/dist/semantic.min.css')}}" rel="stylesheet"> -->
      <link rel="stylesheet" href="https://libs.cartocdn.com/cartodb.js/v3/3.15/themes/css/cartodb.css" />
      <link rel="stylesheet" type="text/css" href="{{asset('asset-store/js/businessHours-master/jquery.businessHours.css')}}"/>
      <link rel="stylesheet" type="text/css" href="{{asset('css/offline.css')}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/offlinelang.css')}}">
   </head>
   <body>
      <div class="app_wrapper">
         @yield('content')
         <!-- Footer Starts -->
         {{-- 
         <footer>
            <p>&copy; 2019 420 Kingdom. Trademarks and brands are the property of their respective owners.</p>
         </footer>
         --}}
      </div>
      <!-- Footer Ends -->
   </body>
   <script src="{{asset('asset-store/js/jquery.min.js')}}"></script>
   <script src="{{asset('asset-store/js/bootstrap.min.js')}}"></script>
   <script src="{{asset('asset-store/js/tooltip.js')}}"></script>
   <script src="{{asset('js/offline.js')}}"></script>
   <script type="text/javascript" src='https://ericjgagnon.github.io/wickedpicker/wickedpicker/wickedpicker.min.js'></script>
   <script src="{{asset('asset-store/js/common.js')}}"></script>
   <script src="{{asset('asset-admin/js/lang/en/language.js')}}"></script>
   <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.2.17/jquery.timepicker.min.js"></script>
   <script src="{{asset('js/disable.autocomplete.js')}}"></script>
   <script src="{{asset('js/custom.autocompletedisable.js')}}"></script>
   <script>
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
         
   </script>
   @yield('pagescript')
</html>