@extends('User::register.layout')
@section('header')
<header>
   <div class="header_inner">
      <!-- Branding -->
      <a href="#" class="branding"><img src="{{asset('asset-user-web/images/logo.svg')}}" alt="Kingdom"></a>
      <!-- Branding End -->
      <!-- Right Container -->
      <div class="header-right-container">
         <a href="{{route('users.login')}}" class="log-sign-btn fill">Login</a>
         <a href="{{route('user.register')}}" class="log-sign-btn line">Sign Up</a>
      </div>
      <!-- Right Container End -->
   </div>
</header>
@endsection
@section('content')      <!--header close-->
      <!--section list filter-->
      <section class="inner_centerpanel">

         <div class="custom_container">

            <figure class="nopro_found text-center">
               <img src="assets/images/cannabis.jpg">
            </figure>
            <span class="txt_blocked">User has been <span style="color: #ff0000;">blocked</span> by Admin</span>
         </div>

      </section>
      <!--section list filter close-->
@endsection