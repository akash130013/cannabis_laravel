@section('inner-header')
<header>
   <div class="header_inner">
      <!-- Branding -->
      <a href="{{route('store.dashboard')}}" class="branding"><img src="{{asset('asset-store/images/logo.svg')}}" alt=""></a>
      <!-- Branding End -->
      <!-- Right Container -->
      <div class="header-right-container">
         <ul>
            <li class="header_dropdown">
               <a href="javascript:void(0)">
                  <figure class="user-img-sm"> {{ucfirst(substr(Auth::guard('store')->user()->name,0,1)).ucfirst(substr(Auth::guard('store')->user()->last_name,0,1))}} </figure>
               </a>
               {{-- <img src="{{asset('asset-store/images/placeholder.svg')}}" class="user-icon" alt="User"> --}}
               <img src="{{asset('asset-store/images/droparrow.svg')}}" alt="User">
               <ul class="user_menu">
                  <li><a  data-toggle="modal" data-target="#logout" title="Logout from store panel">Sign-out</a></li>
               </ul>
            </li>
         </ul>
      </div>
      <!-- Right Container End -->
   </div>
</header>
<!-- The Modal -->
<!--logout  Modal-->
<div class="modal fade logout" id="logout" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><img src="{{asset('asset-store/images/close-card.svg')}}"></button>
            <h4 class="modal-title">Logout</h4>
         </div>
         <div class="modal-body">
            <div class="modal-padding">
               <h1 class="confirm_heading">Logout Confirmation</h1>
               <p class="commn_para"> Are you sure you want to logout?</p>
               <div class="flex-row m-t-30">
                  <div class="flex-col-sm-12 mt-50 mobile-space">
                     <a href="{{route('store.logout')}}">  <button class="custom-btn green-fill getstarted btn-effect">Logout</button>
                     </a>
                     <a class="ch-shd back line_effect" href="javascript:void(0)"  data-dismiss="modal">No, Cancel</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--logout Modal Close-->
@endsection