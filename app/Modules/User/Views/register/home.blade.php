@extends('User::register.layout')
@section('header')


<header>
   <div class="header_inner">
      <!-- Branding -->
      <a href="#" class="branding"><img src="{{asset('asset-user-web/images/logo.svg')}}" alt="Kingdom"></a>
      <!-- Branding End -->
      <!-- Right Container -->
      <div class="header-right-container">
         <a href="{{route('users.login')}}" class="log-sign-btn line">Login</a>
         <a href="{{route('user.register')}}" class="log-sign-btn fill">Sign Up</a>
      </div>
      <!-- Right Container End -->
   </div>
</header>
@endsection
@section('content')
    
       <!--Home Banner-->
       <section class="banner_block">
         <div id="banner-owl" class="owl-carousel">
            <!--repeat item-->
            <div class="item">
               <figure class="banner_img">
                  <img src="{{asset('asset-user-web/images/banner.jpg')}}" alt="Kingdom">
                  <div class="banner_container">
                     <div class="order-txt">
                        <h1 class="banner-text">Order Online</h1>
                        <p>from the best shops in your area</p>

                        <ul class="d-flex list-styled order-list">
                           <li>Search Product</li>
                           <li>Order</li>
                           <li>Smile</li>
                        </ul>
                     <a href="{{route('users.login')}}">
                        <button class="custom-btn green-fill getstarted order-btn btn-effect">Order Online Now</button>
                     </a>
                     
                  </div>
                  </div>
               </figure>
            </div>
            <!--repeat item close-->
            <!--repeat item-->
            <div class="item">
               <figure class="banner_img">
                  <img src="{{asset('asset-user-web/images/banner.jpg')}}" alt="Kingdom">
                  <div class="banner_container">
                     <div class="order-txt">
                        <h1>Order Online</h1>
                        <p>from the best shops in your area</p>
                        <ul class="d-flex list-styled order-list">
                           <li>Search Product</li>
                           <li>Order</li>
                           <li>Smile</li>
                        </ul>
                        <a href="{{route('users.login')}}">
                        <button type="button" class="custom-btn green-fill getstarted order-btn">Order Online Now</button>
                        </a>
                     </div>
                  </div>
               </figure>
            </div>
            <!--repeat item close-->
            <!--repeat item-->
            <div class="item">
               <figure class="banner_img">
                  <img src="{{asset('asset-user-web/images/banner.jpg')}}" alt="Kingdom">
                  <div class="banner_container">
                     <div class="order-txt">
                        <h1>Order Online</h1>
                        <p>from the best shops in your area</p>
                        <ul class="d-flex list-styled order-list">
                           <li>Search Product</li>
                           <li>Order</li>
                           <li>Smile</li>
                        </ul>
                        <a href="{{route('users.login')}}">
                        <button type="button" class="custom-btn green-fill getstarted order-btn">Order Online Now</button>
                        </a>
                     </div>
                  </div>
               </figure>
            </div>
            <!--repeat item close-->
         </div>
      </section>
      <!--Home Banner close-->
      <!--Add banner-->
      <section class="add_banner tagline-bg">
         <div class="custom_container">
            <div class="tagline-content img-wrapper d-flex align-items-center">
               <figure class="cannabis-bottle"><img src="{{asset('asset-user-web/images/cannabis-bottle.png')}}" alt="cannabis bottle"></figure>
               <div class="right-txt">
                  <p class="lh2">You already buy everything you want and need online.</p>
                  <h6 class="pb15">With “420 Kingdom STOREs”</h6>
                  <p class="tagline-subtext">Why should buying weed online be any different? It isn’t, and it may
                     be even easier and more convenient.
                  </p>
               </div>
            </div>
         </div>
      </section>
      <!--Add banner close-->
      <!--How does it work-->
      <section class="hdw-section">
         <div class="custom_container">
            <h1 class="text-center section_title">How Does It <span class="fw8">Works</span></h1>
            <div class="flex-row align-items-center">
               <div class="col-left">
                  <div class="maxw400">
                     <h2 class="fwsb">Find what you love. We have
                        products specially curated for your needs
                     </h2>
                     <p class="sub-txt fwm">Lorem ipsum dolor sit amet consectetur adipisicing
                        labore dolore magna aliqua. Lorem ipsum dolor sit
                        amet consectetur adipisicing.
                     </p>
                  </div>
               </div>
               <div class="col-right">
                  <figure class="mob-screen">
                     <img src="{{asset('asset-user-web/images/cannabis-app.png')}}">
                  </figure>
               </div>
            </div>
         </div>
      </section>
      <!--How does it work close-->
      <!--Learn more-->
      <section class="learnmore learnMore-section">
         <div class="custom_container">
            <div class="learnMore-container align-items-center">
               <div class="addstore-txt">
                  <p class="fw5">Add your store to <span class="fw6">“420 Kingdom”</span></p>
                  <span class="addstore-subtxt fwm">Begin selling today with the best, and most compliant, online ordering and
                  delivery solution for stores.</span>
                  {{-- <button class="btn custom-btn learn-btn fwsb">Learn More</button> --}}
               </div>
               <div class="mw200">
                  <img src="{{asset('asset-user-web/images/Promotional_Store_Graphic.svg')}}">
               </div>
            </div>
         </div>
      </section>
    
          
   <!-- Points Information Start -->

   {{-- <div class="order-detail-sidebar points_info_sidebar">
         <div class="inner_wrap">
            <div class="detail-sidebar">
               <div class="sidebar-header">
                  <div class="wrapper">
                     <span>
                        <img src="{{asset('asset-user-web/images/close-line.svg')}}" alt="close" />
                     </span>
                     <label>Order Online</label>
                  </div>
               </div>
               <div class="title_wrapper info_title">
                  <p class="txt_title">We will deliver right to your door</p>
                 
               </div>
            </div>
            <hr>
   
            <div class="detail-sidebar">
                  <div class="head-search">
                        <div class="text-field-wrapper">    
                           <input type="text" name="formatted_address" placeholder="Auto Detect  or Type Location" id="global_location" value="" required autocomplete="off">
                           <span class="detect-icon"><img src="{{asset('asset-user-web/images/detect-icon.png')}}" id="global_autolocation"></span>
                        </div>
                     </div>
            </div>
   
            <!-- order-detail sidebar -->
         </div>
      </div> --}}
      

      <input type="hidden" id="location_submit_url" value="{{route('user.guest')}}">
      <form action="{{route('user.guest')}}" id="update_curren_user_location">
         <input type="hidden" name="lat" id="global_lat" value="">
         <input type="hidden" name="lng" id="global_lng" value="">
         <input type="hidden" name="locality" id="global_locality" value="">
         <input type="hidden" name="administrative_area_level_1" id="global_administrative_area_level_1">
         <input type="hidden" name="country" id="global_country" >
         <input type="hidden" name="postal_code" id="global_postal_code" value="">
         <input type="hidden" name="street_number" id="global_street_number">
         <input type="hidden" name="formatted_address" value="" id="global_formatted_address">
         <input type="hidden" name="ip" id="global_ip">
         <input type="hidden" name="route" id="global_route">
      </form>

    @endsection
      <!--App Wrapper close-->

      @section('pagescript')
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjN4ZWartGxRef-S_LYQWqhfCsWWvZBbI&libraries=places"></script>
      {{-- <script src="{{asset('asset-user/js/show.location.pop.js')}}"></script> --}}
      <script src="{{ asset('asset-user/js/location/jquery.geocomplete.js')}}"></script>
      <script src="{{ asset('asset-user/js/global.location.autofill.js')}}"></script>

      
      <script>
       $(document).ready(function () {
         $("#order_online_now").click(function (e) {
            e.preventDefault();
            return false;
            e.stopPropagation();
            $(".order-detail-sidebar").addClass("active");
            $("body").css({ overflow: "hidden" });
         });
         
         $(".wrapper img").click(function () {
            $(".order-detail-sidebar").removeClass("active");
            $("body").css({ overflow: "auto" });
         });

        
   $("body").click(function (event) {
   
      if (!$(event.target).is(".order-detail-sidebar , .order-detail-sidebar *")) { 

         $(".order-detail-sidebar").removeClass("active");
         $("body").css({ overflow: "auto" });} 
   });


      });

   
      </script>
      
      @endsection
      



         
      
     