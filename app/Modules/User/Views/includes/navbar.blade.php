@section('nav-bar')
<!--header-->
<header>
   <div class="header_inner">
      <!-- Branding -->
      <div class="nav-brand">
         <a href="{{route('users.dashboard')}}" class="branding"><img src="{{asset('asset-user-web/images/logo.svg')}}" alt="Kingdom"></a>
      </div>
      <!-- Branding End -->
      <div class="head-search">
         <span class="search_mob">
         <img src="{{asset('asset-user-web/images/search-line.svg')}}">
         </span>
         <div class="text-field-wrapper mob_location_srch">
            <input type="text" name="formatted_address" readonly onfocus="this.removeAttribute('readonly');" placeholder="Auto Detect  or Type Location" id="global_location" value="{{session()->get('userdetail')->formatted_address ?? ''}}" autocomplete="off" required>
            <span class="detect-icon"><img src="{{asset('asset-user-web/images/detect-icon.png')}}" id="global_autolocation"></span>
         </div>
      </div>
      <!--nav wrapper-->
      <nav>
         <ul>
            <li class="mob_hide">
               <a href="{{route('user.show.wish.list')}}">
                  <figure class="h-icon">  <img src="{{asset('asset-user-web/images/wishlist-icon.svg')}}" alt="wishlist"> </figure>
                  <span>Wishlist</span>
               </a>
            </li>
            <li class="mob_hide">
               <a href="{{route('user.show.cart.list')}}">
                  @if(!empty(Session::get('cartdetail')['response']['data']))
                  <figure class="h-icon"> <span class="digit">{{Session::get('cartdetail')['response']['data']}}</span>
                     @endif
                     <img src="{{asset('asset-user-web/images/cart.svg')}}" class="h-icon">
                  </figure>
                  <span>Cart</span>
               </a>
            </li>
            <li class="header_dropdown">
               <a href="javascript:void(0)">
                  <figure class="user-img-sm">@if(isset(Auth::guard('users')->user()->profile_pic) && !empty(Auth::guard('users')->user()->profile_pic))<img src="{{Auth::guard('users')->user()->profile_pic}}" alt="logo">@else{{trim(\App\Helpers\CommonHelper::getfirstLastLetter())}}@endif</figure>
               </a>
               <div class="fisrtlevl_list">
                  <ul>
                     <li> <a href="{{route('user.show.setting.page')}}">My Profile</a> </li>
                     <li> <a href="{{route('user.loyality-point.listing')}}">My Loyality Point</a> </li>
                     <li> <a href="{{route('user.order.listing')}}">My Orders</a> </li>
                     <li class="desktop_hide">
                        <a href="{{route('user.show.wish.list')}}">Wishlist</a> 
                     </li>
                     </li>
                     <li class="desktop_hide">
                        <a href="{{route('user.show.cart.list')}}">Cart</a> 
                     </li>
                     </li>
                     <li>  <a href="javascript:void(0)" data-toggle="modal" data-target="#logout">Logout</a>  </li>
                  </ul>
               </div>
            </li>
         </ul>
      </nav>
      <!--nav wrapper close-->
   </div>
   <hr class="header-ruler">
   <div class="header_inner in-head-pad">
      <span class="mobile-menu">
      <img src="{{asset('asset-user-web/images/menu-line.svg')}}"  alt="mobile menu"/>
      </span>
      <!--header menu-->
      <div class="head-nav tab_wrapper">
         <ul>
            <li><a href="{{route('users.dashboard')}}" class="@if(in_array(Request::route()->getName(),['users.dashboard'])) active @endif">Home</a></li>
            <li><a href="{{route('users.product.category')}}" class="@if(in_array(Request::route()->getName(),['users.product.category','users.product.detail','users.category.product','users.product.trending'])) active @endif">Products</a></li>
            <li><a href="{{route('users.store.map')}}" class="@if(in_array(Request::route()->getName(),['users.product.store','users.store.map','users.store.detail','users.store.product','users.product.near.store','users.store.review'])) active @endif">Stores</a></li>
            <li><a href="{{route('user.product.deal.list')}}" class="@if(in_array(Request::route()->getName(),['user.product.deal.list'])) active @endif">Deals</a></li>
         </ul>
      </div>
      <!--header menu close-->
      <!--search-->
      <div class="product-srch-col-header">
         <div class="text-field-wrapper pro-srchbox">
            <input class="search-input" type="text" placeholder=" Search  Product & Stores" id="search" name="search" readonly>
            <span class="detect-icon search-input"><img src="{{asset('asset-user-web/images/search-line.svg')}}" alt="detect"></span>
         </div>
      </div>
      <!--search close-->
   </div>
</header>
@endsection