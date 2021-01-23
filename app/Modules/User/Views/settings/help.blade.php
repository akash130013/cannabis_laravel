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
                     <h2 class="sub-title">Get Help</h2>
                     <p class="help_para">
                        Experiencing a problem? Have a question? We're here to help!
                     </p>
                     <p class="help_para">
                        Our customer support representatives are standing by from <b>7am - 10pm PST, 7 days a week,</b> to get you the answers you
                        need. Your happiness is our top priority!   
                     </p>
                     <div class="flex-row">
                        <div class="flex-col-sm-4">
                           <div class="help_card">
                              <img src="{{asset('asset-user-web/images/message-3-line.svg')}}">
                              <p class="title">Chat</p>
                              <p class="para">
                                 Talk to us now. Est.response
                                 time: 5min
                              </p>
                           </div>
                        </div>
                        <div class="flex-col-sm-4">
                           <div class="help_card">
                              <img src="{{asset('asset-user-web/images/mail-line.svg')}}">
                              <p class="title">Email</p>
                              <p class="para">
                                 Talk to us now. Est.response
                                 time: 5min
                              </p>
                           </div>
                        </div>
                        <div class="flex-col-sm-4">
                           <div class="help_card">
                              <img src="{{asset('asset-user-web/images/phone-line.svg')}}">
                              <p class="title">Call</p>
                              <p class="para">
                                 Talk to us now. Est.response
                                 time: 5min
                              </p>
                           </div>
                        </div>
                     </div>
                  </div>
                   <!--Setting Detail Col Close-->
               </div>
            </div>
         </section>
         <input type="hidden" name="search_type" value="1">
@endsection