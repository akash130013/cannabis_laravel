@extends("Store::layouts.master")


@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="{{asset('asset-store/css/bootstrap.datepicker.css')}}">
@endpush

@section('content')

<div class="custom_container">
      @include('Store::layouts.pending-alert')
         <div class="white_wrapper p-sm">
         <div class="flex-row align-items-center">
            <div class="flex-col-sm-6 flex-col-xs-6">
               <h2 class="title-heading">Earnings</h2>
            </div>
            <div class="flex-col-sm-6 flex-col-xs-6 text-right">
               <!--search-->
               <!-- <div class="product-srch-col-header">
                  <div class="text-field-wrapper pro-srchbox">
                     <input type="text" placeholder="Search for product">
                     <span class="detect-icon"><img src="{{asset('asset-store/images/search-line.svg')}}" alt="search"></span>
                  </div>
               </div> -->
               <!--search close-->
            </div>
         </div>
      </div>
      </div>

      <!-- Earnings Filter -->
    
      <!-- Earnings Filter -->


      <div class="custom_container">
         <div class="white_wrapper not_found">
         <div class="empty-earnings">
            <div class="text-center">
               <figure>
                  <img src="{{asset('asset-store/images/earnings-empty.png')}}" alt="empty-earnings" />
               </figure>
               <h2>Well here’s the good news!!</h2>
               <p>You are yet to received orders from 420 KINGDOM.</p>
            </div>
         </div>
      </div>
      </div>


    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="{{asset('asset-store/js/datepicker.bootstrap.js')}}"></script>
    <script src="{{asset('asset-store/js/earning.list.js')}}"></script>
    @endpush


@endsection