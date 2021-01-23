<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{asset('asset-store/images/cannabis_leaf.ico')}}" />
    

    <title>{{ config('app.name', 'Cannabis') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('asset-store/css/routine.css')}}" rel="stylesheet">
    <link href="{{ asset('asset-store/css/style.css') }}" rel="stylesheet">

    <link href="{{ asset('asset-store/css/header.css') }}" rel="stylesheet">
    <link href="{{asset('asset-store/css/onboarding.css')}}" rel="stylesheet"> 
    <link href="{{asset('asset-store/css/tooltip.css')}}" rel="stylesheet">
    <link href="https://www.cssscript.com/demo/message-toaster/toast.css" rel="stylesheet">
    <link href="https://www.cssscript.com/demo/message-toaster/toast.css" rel="stylesheet">
    <link rel="stylesheet"  href="{{asset('css/offline.css')}}">
    <link rel="stylesheet"  href="{{asset('css/offlinelang.css')}}">
    <!--font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('asset-store/css/media.css') }}" rel="stylesheet">
     
</head>
<body>

<div class="app_wrapper">
       
    <header>
        <div class="header_inner">
              
            <!-- Branding -->
            <a href="{{url('/store')}}" class="branding"><img src="{{asset('asset-store/images/logo.svg')}}" alt=""></a>
            <!-- Branding End -->
            <!-- Right Container -->
            <div class="header-right-container">
                <a href="{{route('store.login')}}" class="log-sign-btn fill">Login</a>
                <a href="{{route('store.register.user')}}" class="log-sign-btn line">Sign Up</a>
            </div>
            <!-- Right Container End -->
        </div>
    </header>
    <!-- Header End -->
    <!-- Internal Container -->
    
    <figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
    <div class="internal-container">
      
        <!-- Form Container -->
        <div class="form-container">
             @yield('content')
            
        </div>
        <!-- Form Container End -->
    </div>
    
</div>

</body>
<script src="{{asset('asset-store/js/jquery.min.js')}}"></script>
<script src="{{asset('asset-store/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/offline.js')}}"></script>
<script src="{{asset('asset-store/js/tooltip.js')}}"></script>
<script src="{{asset('asset-store/js/common.js')}}"></script>
<script src="{{asset('asset-store/js/toster.js')}}"></script> 
<script src="{{asset('js/disable.autocomplete.js')}}"></script>
<script src="{{asset('js/custom.autocompletedisable.js')}}"></script> 
<script>
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





</script>
</html>
@yield('pagescript')



