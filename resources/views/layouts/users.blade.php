<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kingdom</title>
    <!-- Favicon -->
    <!-- <link rel="icon" type="image/png" href="{{asset('asset-user/images/fab.png')}}" /> -->
    <!-- Favicon End -->
    <link href="{{asset('asset-user/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('asset-user/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('asset-user/css/header.css')}}" rel="stylesheet">
    <link href="{{asset('asset-user/css/footer.css')}}" rel="stylesheet">
    <link href="{{asset('asset-user/css/onboarding.css')}}" rel="stylesheet">
    <link href="{{asset('asset-user/css/media.css')}}" rel="stylesheet">
    
   
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <!-- Branding -->
            <a href="#" class="branding"><img src="{{asset('asset-user/images/logo.svg')}}" alt=""></a>
            <!-- Branding End -->
            <!-- Right Container -->
            <div class="header-right-container">
                <a href="{{route('users.login')}}" class="log-sign-btn fill">Login</a>
                <a href="{{route('user.register')}}" class="log-sign-btn line">Sign Up</a>
            </div>
            <!-- Right Container End -->
        </div>
    </header>
    <!-- Header End -->
    <!-- Internal Container -->
      @yield('content')
        <!-- Form Container End -->
    </div>
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
    <script src="{{asset('js/disable.autocomplete.js')}}"></script>
    <script src="{{asset('js/custom.autocompletedisable.js')}}"></script>
   
    @yield('pagescript')


    
    <!-- JS End -->
</body>

</html>