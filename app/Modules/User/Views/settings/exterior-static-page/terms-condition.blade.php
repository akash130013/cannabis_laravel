@extends('User::register.layout')

@section('content')
@include('includes.header')
      
            <div class="custom_container tnc-page-wrapper">
              
               <div class="flex-row account_wrapper">
                  <!--Setting Menu Col-->
                    {{-- @yield('left-panel') --}}
                   <!--Setting Menu Col Close-->
                   <!--Setting Detail Col-->
                  <div class="account-details-col">
                  {{-- <h2 class="sub-title">{{$data->name ?? 'N/A'}}</h2> --}}
                  {!!$data->content ?? 'N/A'!!}
                  </div>
                  
                   <!--Setting Detail Col Close-->

               </div>
            </div>
         

         <input type="hidden" name="search_type" value="1">
      @endsection