@extends("Store::layouts.master")
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endpush
@section('content')
<form action="{{route('store.earning.list')}}" id="formFilterId">
   <div class=" custom_container">
      @include('Store::layouts.pending-alert')
      <div class="white_wrapper">
         <div class="flex-row align-items-center">
            <div class="flex-col-sm-3 flex-col-xs-6">
               <h2 class="title-heading">Earnings</h2>
            </div>
            <div class="flex-col-sm-9 flex-col-xs-6 text-right">
               <!--search-->
               <div class="product-srch-col-header ui search">
                  <div class="text-field-wrapper pro-srchbox ui icon input">
                     <input type="text" id="searchElementProduct" placeholder="Search for order Id" name="search"  class="prompt" value="{{Request::get('search')}}">
                     <i class="search icon"></i>
                  </div>
                  <div class="results"></div>
               </div>
               <!--search close-->
            </div>
         </div>
      </div>
   </div>
   <!-- Earnings Filter -->
   <div class="custom_container p-sm">
      <div class="flex-row align-items-center row-wrap">
         {{-- <div class="flex-col-md-3 flex-col-sm-3">
            <label class="form-label">From</label>
            <div class="form_field_wrapper">
               <div class='input-group date' >
                  <input type='text' name="start" placeholder="Start date"  value="@if(Request::has('start')){{Request::get('start')}}@endif" id='datetimepicker1' />
                  <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </span>
               </div>
            </div>
         </div>
         <div class="flex-col-md-3 flex-col-sm-3">
            <label class="form-label">To</label>
            <div class="form_field_wrapper">
               <div class='input-group date' >
                  <input type='text' name="end" placeholder="End date" value="@if(Request::has('end')){{Request::get('end')}}@endif" id='datetimepicker2' />
                  <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                  </span>
               </div>
            </div>
         </div> --}}

         <div class="flex-col-md-3 flex-col-sm-3">
            <label class="form-label">From</label>
            <div class="form_field_wrapper">
                    <div class='input-group date'> 
                           <input type='text' name="start" placeholder="Start date" class="datebox startDate" value="{{ Request::has('start') ? Request::get('start') : ''}}" id='datetimepicker1' autocomplete="off"/>
                           <span class="input-group-addon"> 
                           <i class="fa fa-calendar"></i>
                           </span> 
                        </div>
            </div>
         </div>
         <div class="flex-col-md-3 flex-col-sm-3">
            <label class="form-label">To</label>
            <div class="form_field_wrapper">
                  <div class='input-group date'> 
                           <input type='text' name="end" placeholder="End date" class="datebox endDate" value="{{ Request::has('end') ? Request::get('end') : ''}}" id='datetimepicker2' autocomplete="off"/>
                           <span class="input-group-addon">  <i class="fa fa-calendar"></i> </span> 
                        </div>
            </div>
         </div>

         <div class="flex-col-md-3 flex-col-sm-3">
            <label class="form-label">Status</label>
            <div class="form_field_wrapper">
               <div class="select_picker_wrapper">
                  <select class="selectpicker" name="status">
                     <option value="">All</option>
                     <option @if(Request::has('status') && Request::get('status') == 'open') selected="selected" @endif value="open">Open</option>
                     <option @if(Request::has('status') && Request::get('status') == 'closed') selected="selected" @endif value="closed">Close</option>
                  </select>
               </div>
            </div>
         </div>

         <div class="flex-col-md-3 flex-col-sm-3">
            <div class="form_field_wrapper">
               <div class="filter-wrapper m-t-30 text-center">
                  <button class="primary_btn green-fill btn_sm btn-effect" type="submit">Apply</button>
                  <a class="primary_btn green-fill btn btn_sm m-l-20 btn-effect" href="{{route('store.earning.list')}}">Reset</a>
               </div>
              
                  {{-- @if(Request::has('status'))
                     <a href="{{route('store.earning.list')}}" class="btn btn-info">CLear</a>
                  @endif  --}}
                  
            </div>
         </div>
      </div>
   </div>
</form>
<!-- Earnings Filter Close -->
<div class="custom_container">
   <div class="flex-row mob-row-reverse">
      <div class="flex-col-md-8 flex-col-sm-8">
         <div class="productListBodyWrapper loationArea wrapper_border">
            <div class="white_wrapper">
               <div class="table-responsive">
                  <table id="example" class="list-table table table-striped table-bordered" cellspacing="0" width="100%">
                     <thead>
                        <tr>
                           <th align="center">S.No.</th>
                           <th>Order ID</th>
                           <th>Total Amount ($)</th>
                           <th>Total Received Amount ($)</th>
                           <th>Commission ($)</th>
                           {{-- 
                           <th>Net Revenue ($)</th>
                           --}}
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        <!-- row repeat -->
                        @if(!$earningList->isEmpty())
                        @foreach($earningList as $key => $val)
                        <tr>
                           <td>{{$key + $earningList->firstItem()}}</td>
                           <td>{{$val->order_uid}}</td>
                           <td>{{$val->actual_amount}}</td>
                           <td>{{$val->amount_received}}</td>
                           <td>{{$val->commission}}</td>
                           {{-- 
                           <td>{{$val->amount_after_commission}}</td>
                           --}}
                           <td>{{ucfirst($val->status)}}</td>
                        </tr>
                        @endforeach
                        @else
                        <td colspan="7" class="text-center">You have no earnings done yet</td>
                        @endif
                        <!-- row repeat -->
                     </tbody>
                  </table>
               </div>
            </div>
            <!-- Pagination -->
            @if(!$earningList->isEmpty())
            <div class="flex-row align-items-center">
               <div class="flex-col-sm-6">
                  <h6>Display {{$earningList->count()}} of {{$earningList->total()}}</h6>
               </div>
               <div class="flex-col-sm-6">
                  <div class="paginationWrapper">
                     <div class="pagenation">
                        {{$earningList->links()}}
                     </div>
                  </div>
               </div>
            </div>
            @endif
            <!-- Pagination -->
         </div>
      </div>
      {{-- 'earningList', 'totalEarning', 'totalOutStanding' --}}
      <div class="flex-col-md-12 flex-col-sm-4">
         <div class="white_wrapper total-earnings">
            <h4>Total Earnings</h4>
            <h1>${{$totalEarning ?? 0}}</h1>
         </div>
         <div class="white_wrapper total-earnings">
            <h4>Total Outstanding</h4>
            <h1>${{$totalOutStanding ?? 0}}</h1>
         </div>
      </div>
   </div>
</div>
@push('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="{{asset('asset-store/js/datepicker.bootstrap.js')}}"></script>
<script src="{{asset('asset-store/js/Semantic-UI-master/dist/semantic.min.js')}}"></script>
{{-- <script src="{{asset('asset-store/js/earning.list.js')}}"></script> --}}
<script src="{{asset('asset-store/js/date-validation.js')}}"></script>


<script>
   $(document).ready(function(){
   
   
   $('.ui.search')
    .search({
    apiSettings: {
    url: 'earning-search?q={query}',
   },
   fields: {
    results : 'items',
    title   : 'title',
   },
   onSelect: function(result, response) {
        $("#searchElementProduct").val(result.title);
        $("#formFilterId").submit();
    }
   });
   
   
   });
</script>
@endpush
@endsection