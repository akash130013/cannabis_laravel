@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')

     
         <!--header close-->
      @section('content')

      @yield('nav-bar')

      <section class="inner_centerpanel">
            <div class="custom_container">
               <div class="flex-row align-items-center">
                  <div class="flex-col-sm-6 flex-col-xs-6">
                     <h2 class="title-heading m-t-b-30">Account Overview</h2>
                  </div>
                  <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                    <img src="{{asset('asset-user-web/images/menu-line.svg')}}" class="profile-mobile-menu">
                  </div>
               </div>
               <div class="flex-row account_wrapper">
                  <!--Setting Menu Col-->
                    @yield('left-panel')
                   <!--Setting Menu Col Close-->
                   <!--Setting Detail Col-->
                  <div class="account-details-col">
                  {{-- <h2 class="sub-title">{{$data->name ?? 'N/A'}}</h2> --}}
                  {!!$data->content ?? 'N/A'!!}
                  </div>
                  
                   <!--Setting Detail Col Close-->

               </div>
            </div>
         </section>

         <input type="hidden" name="search_type" value="1">
      @endsection