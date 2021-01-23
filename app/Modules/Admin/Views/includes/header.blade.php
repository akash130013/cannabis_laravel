<header>
      <div class="brand">
          <div class="header-left-menu">
              <figure class="header-logo"><img src="{{asset('asset-admin/images/menu-line.svg')}}" class="menu-line"></figure>
          <figure class="logo"><a href="{{route('admin.dashboard')}}"> <img src="{{asset('asset-admin/images/logo.svg')}}"></a></figure>
          </div>
          <div class="header-right-menu">
              <nav>
                  <ul>
                      <li>
                          <a href="{{route('admin.profile')}}" title="My Profie" class="admin-profile">
                              <span class="header-admin-icon"></span>
                              @if(Auth::guard('admin')->user())
                            <p> {{ Auth::guard('admin')->user()->name }}</p>
                            @endif
                          </a>
                      </li>
                      <li>
                          <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal-logout"  title="Logout">
                              <span class="header-logout-icon"></span>
                          </a>
                      </li>
                  </ul>
              </nav>
          </div>
      </div>
  </header>
  {{-- <header class="clearfix">
      <!-- Navigation toggle start here -->
      <div class="toggle-btn-wrap">
         <div class="line-wrap">
            <span class="line-bar"></span>
            <span class="line-bar shot-line-br"></span>
            <span class="line-bar"></span>
         </div>
      </div>
      <!-- Navigation toggle end here -->
      <div class="brand">
         <a href="javascript:void(0)" class="logo">
         <img src="{{ asset('asset-admin/images/logo.svg')}}" alt="Player Tracker">
         </a>
      </div>
      <!-- Flash msgs end -->
      <div class="user-setting-wrap">
         <div class="user-pic-wrap">
            <ul>
               <li>
                 
                  <ul class="account-dropdown">
                     <li>
                        <a href="{{route('admin.profile')}}">
                        <i class="fa fa-user"></i> My Profile</a>
                     </li>
                     <li>
                        <a href="javascript:void(0);">
                        <i class="fa fa-lock"></i> Change Password</a>
                     </li>
                  </ul>
               </li>
               
               <li>
                  <a href="{{route('admin.profile')}}" title="My Profie">
                  <img src="{{ asset('asset-admin/images/settings.svg')}}" alt="LogOut">
                  </a>
               </li>
               <li>
                  <a href="javascript:void(0);" data-toggle="modal" data-target="#logout" title="Logout from admin panel">
                  <img src="{{ asset('asset-admin/images/logout.svg')}}" alt="LogOut">
                  </a>
               </li>
            </ul>
         </div>
      </div>
      <!-- User setting section start end -->
   </header> --}}
  <!-- The Modal -->
<!-- Modal Logout -->
<div id="myModal-logout" class="modal" role="dialog">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Logout</h4>
              </div>
              <div class="modal-body">
                  <div class="formfilled-wrapper m0">
                      <div class="textfilled-wrapper">
                          <p class="modal_para">Are you sure want to Logout?</p>
                      </div>
                  </div>

                  <div class="modal-footer">
                      <div class=" text-center">
                          <button class="mr10 green-fill-btn green-border-btn" data-dismiss="modal">No</button>
                          <a href="{{route('admin.logout')}}"> <button class="green-fill-btn">Yes</button></a>
                      </div>
                  </div>
              </div>

          </div>
      </div>
  </div>
  <!-- Modal Logout -->