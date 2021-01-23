<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Kingdom</title>
      <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
      <link rel="stylesheet" href="assets/css/bootstrap.css">
      <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
      <link rel="stylesheet" type="text/css" media="screen" href="assets/css/routine.css" />
      <link rel="stylesheet" type="text/css" media="screen" href="assets/css/inner-style.css" />
      <link rel="stylesheet" type="text/css" media="screen" href="assets/css/inner-media.css" />
      <link rel="stylesheet" type="text/css" media="screen" href="assets/css/owl.carousel.min.css">
      <link rel="stylesheet" type="text/css" media="screen" href="assets/css/aos.css" rel="stylesheet">
   </head>
   <body>
      <!--App Wrapper-->
      <div class="app_in_wrapper">
         <div class="full-loader">
            <figure class="loader">
               <img src="assets/images/cannabis-loader.gif">
            </figure>
         </div>
         <!--header-->
         <header>
            <div class="header_inner">
               <!-- Branding -->
               <div class="nav-brand">
                  <a href="#" class="branding"><img src="assets/images/logo.svg" alt="Kingdom"></a>
               </div>
               <!-- Branding End -->   
               <div class="head-search">
                  <div class="text-field-wrapper">    
                     <input type="text" placeholder="Location">
                     <span class="detect-icon"><img src="assets/images/detect-icon.png" alt="detect"></span>   
                  </div>
               </div>
               <!--nav wrapper-->
               <nav>
                  <ul>
                     <li>
                        <a href="javascript:void(0)">
                           <figure class="h-icon">  <img src="assets/images/wishlist-icon.svg" alt="wishlist"> </figure>
                           <span>Wishlist</span>
                        </a>
                     </li>
                     <li>
                        <a href="javascript:void(0)">
                           <figure class="h-icon"> <span class="digit">02</span><img src="assets/images/cart.svg"> </figure>
                           <span>Cart</span>   
                        </a>
                     </li>
                     <li class="header_dropdown">
                        <a href="javascript:void(0)">
                           <figure class="user-img-sm"> MJ </figure>
                        </a>
                        <div class="fisrtlevl_list">
                           <ul>
                              <li> <a href="#">My Profile</a> </li>
                              <li>  <a href="#">My Orders</a>  </li>
                              <li>  <a href="#">Logout</a>  </li>
                           </ul>
                        </div>
                     </li>
                  </ul>
               </nav>
               <!--nav wrapper close-->
            </div>
            <hr class="header-ruler">
            <div class="header_inner in-head-pad">
               <!--header menu-->
               <div class="head-nav tab_wrapper">
                  <ul>
                     <li><a href="javascript:void(0)" class="active">Home</a></li>
                     <li><a href="javascript:void(0)">Products</a></li>
                     <li><a href="javascript:void(0)">Stores</a></li>
                     <li><a href="javascript:void(0)">Deals</a></li>
                  </ul>
               </div>
               <!--header menu close-->
               <!--search-->
               <div class="product-srch-col-header">
                  <div class="text-field-wrapper pro-srchbox">    
                     <input type="text" placeholder="Search Products & Stores">
                     <span class="detect-icon"><img src="{{asset('asset-user-web/images/search-line.svg')}}" alt="detect"></span>   
                  </div>
               </div>
               <!--search close-->    
            </div>
         </header>
         <!--header close-->
         <!--section list filter-->
         <section class="inner_centerpanel">
            <div class="custom_container">
               <figure class="nopro_found text-center">
                  <img src="{{asset('asset-user-web/images/noproduct.png')}}">
               </figure>
            </div>
         </section>
         <!--section list filter close-->
         <!--footer-->
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
         <!--footer close-->   
      </div>
      <!--App Wrapper Close-->
      <script src="assets/js/jquery.js"></script>
      <script src="assets/js/owl.carousel.min.js"></script>
      <script src="assets/js/app.js"></script>
      <script src="assets/js/custom.js"></script>
   </body>
</html>