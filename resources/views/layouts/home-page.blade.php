<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kingdom</title>
    
    <link href="{{asset('asset-user/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('asset-user/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('asset-user/css/header.css')}}" rel="stylesheet">
    <link href="{{asset('asset-user/css/footer.css')}}" rel="stylesheet">
    <link href="{{asset('asset-user/css/onboarding.css')}}" rel="stylesheet">
    <link href="{{asset('asset-user/css/media.css')}}" rel="stylesheet">
    <style>
    .error{
        color:red;
        font-size: 12px;
        display: block;
        margin: 5px 0 0;
    }
    </style>

</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <!-- Branding -->
            <a href="#" class="branding"><img src="{{asset('asset-user/images/logo.svg')}}" alt=""></a>
            <!-- Branding End -->
            <!-- Right Container -->
         
            <!-- Right Container End -->
        </div>
    </header>
    <!-- Header End -->
    <!-- Internal Container -->
      @yield('content')
        <!-- Form Container End -->
 

        <!-- Internal Container End -->
    <!-- Footer Starts -->
    {{-- <footer>
        <p>&copy; 2019 420 Kingdom. Trademarks and brands are the property of their respective owners.</p>
    </footer> --}}
    <!-- Footer Ends -->
    <!-- JS -->
    <script src="{{asset('asset-user/js/jquery.min.js')}}"></script>
    <script src="{{asset('asset-user/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('asset-user/js/common.js')}}"></script>
    <script src="{{asset('asset-user/js/Minimalist-jQuery-Plugin-For-Birthday-Selector-DOB-Picker/dobpicker.js')}}"></script>
    <script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
    <script src="{{asset('node_modules/js-cookie/src/js.cookie.js')}}"></script>
  
    {{-- <script src="{{asset('js/disable.autocomplete.js')}}"></script>
    <script src="{{asset('js/custom.autocompletedisable.js')}}"></script> --}}
    <script src="{{asset('asset-user/js/moment.js')}}"></script>
    <script src="{{asset('asset-user/js/validate-user-eligibility.js')}}"></script>


    @yield('pagescript')
   
    
    <!-- JS End -->
</body>

 



</html>