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
         <h2 class="sub-title">{{$data->name ?? 'N/A'}}</h2>
         <div class="question_wrapper m-t-b-30">
            {{-- <p class="question_faq">{{$data->name ?? 'N/A'}}</p> --}}
            <p class="commn_para">
               {!!$data->content ?? 'N/A'!!}
            </p>
         </div>
      </div>
      <!--Setting Detail Col Close-->
   </div>
</div>
         <input type="hidden" name="search_type" value="1">
         @endsection
