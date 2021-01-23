<!DOCTYPE html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">      
   <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
   <title>Kingdom</title>
   <link rel="shortcut icon" href="{{asset('asset-store/profile/images/favicon.ico')}}" type="image/x-icon">
   <link href="{{asset('asset-store/profile/css/bootstrap.min.css')}}" rel="stylesheet">
   <link href="{{asset('asset-store/profile/css/bootstrap-select.min.css')}}">
   <link href="{{asset('asset-store/profile/css/style.css')}}" rel="stylesheet">
   <link href="{{asset('asset-store/profile/css/header.css')}}" rel="stylesheet">
   <link href="{{asset('asset-store/profile/css/footer.css')}}" rel="stylesheet">
   <link href="{{asset('asset-store/profile/css/onboarding.css')}}" rel="stylesheet">
   <link href="{{asset('asset-store/profile/css/product.css')}}" rel="stylesheet">
</head>
<body>
   <div class="app_wrapper">
      <!-- Header -->
      <header>
         <div class="container">
            <!-- Branding -->
            <a href="#" class="branding"><img src="{{asset('asset-store/profile/images/logo.svg')}}" alt=""></a>
            <!-- Branding End -->
            <!-- Right Container -->
            <div class="header-right-container">
               <ul>
                  <li>
                     <img src="{{asset('asset-store/profile/images/notification.svg')}}" alt="notifiation"> Notification
                     <div class="notifiyDot"></div>
                  </li>
                  <li>
                     <img src="{{asset('asset-store/profile/images/user.png')}}" class="user-icon" alt="User">
                     <img src="{{asset('asset-store/profile/images/droparrow.svg')}}" alt="User">
                     <ul class="user_menu">
                        <li>My Profile</li>
                        <li>Settings</li>
                        <li>Sign-out</li>
                     </ul>
                  </li>
               </ul>
            </div>
            <!-- Right Container End -->
         </div>
      </header>
      <!-- Header End -->
      <!-- Internal Container -->
      <div class="internal-container product">
         <div class="cb-tabsHdr">
            <!-- Form Container -->
            <div class="form-container">
               <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#locations">Locations</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#drivers">Drivers</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link active" data-toggle="tab" href="#products">Products</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#orders">Orders</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#earnings">Earnings</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" data-toggle="tab" href="#offers">Offers</a>
                  </li>
               </ul>
            </div>
            <!-- Form Container End -->
         </div>
      </div>
      @yield('content')
      {{-- 
      <footer>
         <p>@copy; 2019 420 Kingdom. Trademarks and brands are the property of their respective owners.</p>
      </footer>
      --}}
      <!-- Footer End -->
   </div>
   <!-- JS -->
   <script src="{{asset('asset-store/profile/js/jquery.min.js')}}"></script>
   <script src="{{asset('asset-store/profile/js/bootstrap.min.js')}}"></script>
   <script src="{{asset('asset-store/profile/js/bootstrap-select.js')}}"></script>
   <script src="{{asset('asset-store/profile/js/common.js')}}"></script>
   <script src="{{asset('js/disable.autocomplete.js')}}"></script>
   <script src="{{asset('js/custom.autocompletedisable.js')}}"></script>
   @yield('pagescript')
   <!-- JS End -->
</body>
</html>