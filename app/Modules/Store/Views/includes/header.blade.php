<header>
   <div class="header_inner">
      <!-- Branding -->
      <a href="" class="branding"><img src="{{asset('asset-store/images/logo.svg')}}" alt="Kingdom 420"></a>
      <!-- Branding End -->
      <!-- Right Container -->
      <div class="header-right-container">
         @if(!Auth::guard('store')->user())
         <a href="{{route('store.login')}}" class="log-sign-btn line">Login</a>
         <a href="{{route('store.register.user')}}" class="log-sign-btn fill">Sign Up</a>
         @else
         <ul class="headr_wrap">
            <li class="header_dropdown">
               <a href="javascript:void(0)">
                  <figure class="user-img-sm"> {{ucfirst(substr(Auth::guard('store')->user()->name,0,1)).ucfirst(substr(Auth::guard('store')->user()->last_name,0,1))}} </figure>
               </a>
               <!-- <img src="{{asset('asset-store/images/droparrow.svg')}}" alt="User"> -->
               <div class="fisrtlevl_list">
                  <ul>
                     <li><a  data-toggle="modal" data-target="#logout" title="Logout from store panel">Sign-out</a></li>
                  </ul>
               </div>
            </li>
         </ul>
         @endif
      </div>
      <!-- Right Container End -->
   </div>
</header>
<div class="modal logout" id="logout">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <button type="button" class="close modal-close" data-dismiss="modal">
            <img src="/asset-store/images/close-card.svg"></button>
            <h4 class="modal-title">Logout</h4>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <div class="modal-padding">
               <h4 class="commn_para">Are you sure you want to logout?</h4>
               <div class="flex-row m-t-30">
                  <div class="flex-col-sm-12">
                     <a href="{{route('store.logout')}}">
                     <button class="custom-btn green-fill getstarted btn-effect">Logout</button>
                     </a>
                     <a class="ch-shd back line_effect" href="javascript:void(0)" data-dismiss="modal">No, Cancel</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>