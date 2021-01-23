@extends('User::register.layout')

@section('content')
@include('includes.header')

            <div class="custom_container tnc-page-wrapper">
               
               <div class="flex-row account_wrapper">
                  <!--Setting Menu Col-->
                    @yield('left-panel')
                  <!--Setting Menu Col Close-->
                  <!--Setting Detail Col-->
                  <div class="account-details-col">
                     <h2 class="title-headinge">Get Help</h2>
                     <p class="help_para">
                        Experiencing a problem? Have a question? We're here to help!
                     </p>
                     <p class="help_para">
                        Our customer support representatives are standing by from <b>7am - 10pm PST, 7 days a week,</b> to get you the answers you
                        need. Your happiness is our top priority!   
                     </p>
                     <div class="flex-row">
                        {{-- <div class="flex-col-sm-4">
                           <div class="help_card">
                              <img src="{{asset('asset-user-web/images/message-3-line.svg')}}">
                              <p class="title">Chat</p>
                              <p class="para">
                                 Talk to us now. Est.response
                                 time: 5min
                              </p>
                           </div>
                        </div> --}}
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
         
         <input type="hidden" name="search_type" value="1">
@endsection