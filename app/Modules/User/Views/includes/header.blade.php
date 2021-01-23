@section('header')
<header>
   <div class="header_inner">
      <!-- Branding -->
      <div class="nav-brand">
         <a href="{{route('users.dashboard')}}" class="branding"><img src="{{asset('asset-user-web/images/logo.svg')}}" alt="Kingdom"></a>
      </div>
      <!-- Branding End -->   
      <!--nav wrapper-->
      <nav>
         <ul>
            <li>
            </li>
            <li class="header_dropdown">
               <a href="#">
                  <figure class="user-img-sm">{{trim(\App\Helpers\CommonHelper::getfirstLastLetter())}}</figure>
               </a>
               <div class="fisrtlevl_list">
                  <ul>
                     <li><a href="javascript:void(0)" data-toggle="modal" data-target="#logout">Logout</a></li>
                  </ul>
               </div>
            </li>
         </ul>
      </nav>
      <!--nav wrapper close-->
   </div>
   <hr class="header-ruler">
</header>
@endsection