@section('inner-header')
<header>
   <div class="header_inner">
      <!-- Branding -->
      <div class="nav-brand">
         <a href="{{route('store.dashboard')}}" class="branding"><img src="{{asset('assets/images/logo.svg')}}" alt="Kingdom"></a>
      </div>
      <!-- Branding End -->
      <!--nav wrapper-->
      <nav>
         <ul>
            <li>
               <a href="#">
                  <figure class="h-icon"> <span class="digit">02</span><img
                     src="{{asset('asset-store/images/notification.svg')}}"> </figure>
                  Notification
               </a>
            </li>
            <li class="header_dropdown">
               <a href="javascript:void(0)">
                  <figure class="user-img-sm"> MJ </figure>
               </a>
               <div class="fisrtlevl_list">
                  <ul>
                     <li> <a href="{{route('storeprofile.index')}}">My Profile</a> </li>
                     <li> <a href="#">My Orders</a> </li>
                     <li><a data-toggle="modal" data-target="#logout" title="Logout from store panel">Sign-out</a></li>
                  </ul>
               </div>
            </li>
         </ul>
      </nav>
      <!--nav wrapper close-->
   </div>
   <hr class="header-ruler">
   <div class="header_inner in-head-pad text-center">
      <!--header menu-->
      <div class="head-nav tab_wrapper">
         <ul>
            <li>
               <a href="{{route('store.location.list')}}" class="{{ ((in_array(request()->route()->getName(),['store.location.list'])) ? 'active' : '') }}">Locations</a>
            </li>
            <li>
               <a class="{{ (request()->segment(2) == 'driver' ? 'active' : '')}}" href="{{route('store.driver.list',['status'=>'all'])}}">Drivers</a>
            </li>
            <li>
               <a class="{{ ((in_array(request()->route()->getName(),['store.product.dashboard','store.product.add-page','show.product.detail','store.edit.product'])) ? 'active' : '') }}"  href="{{route('store.product.dashboard')}}">Products</a>
            </li>
            <li>
               <a class="{{ (request()->segment(2) == 'order' ? 'active' : '')}}" href="{{route('store.order.list',['type'=>'pending'])}}">Orders</a>
            </li>
            <li>
               <a href="javascript:void(0)">Earnings</a>
            </li>
            <li>
               <a href="javascript:void(0)">Offers</a>
            </li>
         </ul>
      </div>
      <!--header menu close-->
   </div>
</header>
<!-- The Modal -->
{{-- 
<div class="modal logout" id="logout">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Logout</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <h4>
               Are you sure you want to logout?
            </h4>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <div class="btn-holder logout clearfix">
                        <button type="submit" class="btn success hvr-ripple-out" data-dismiss="modal">Cancel</button>
                        <a href="{{route('store.logout')}}">
                        <button type="button" class="btn success hvr-ripple-out">Logout</button>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
--}}
@endsection