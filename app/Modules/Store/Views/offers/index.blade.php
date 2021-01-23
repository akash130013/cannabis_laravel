@extends("Store::layouts.master")
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

@endpush
@section('content')
<form action="{{route('store.offer.list')}}" id="formFilterId">
   <div class="custom_container">
      @include('Store::layouts.pending-alert')
      <div class="white_wrapper">
         <div class="flex-row align-items-center">
            <div class="flex-col-sm-3 flex-col-xs-6">
               <h2 class="title-heading">Offers</h2>
            </div>
            <div class="flex-col-sm-9 flex-col-xs-6">
            <!--search-->
            <div class="product-srch-col-header ui search">
               <div class="text-field-wrapper pro-srchbox ui icon input">
                  <input type="text" id="searchElementProduct" placeholder="Search for Product Name" name="search"  class="prompt" value="{{Request::get('search')}}">
                  <span class="detect-icon"><img src="{{asset('asset-store/images/search-line.svg')}}" alt="detect"></span>
               </div>
               <a href="{{route('store.add.offer.page')}}" class="primary_btn green-fill btn_sm btn-effect">Add Offer</a>
            </div>
            <!--search close-->
            <div class="flex-col-sm-6 flex-col-xs-6">
            </div>
         </div>
      </div>
   </div>

      <!-- Offer Filter -->
      <div class="custom_container p-sm">
      <div class="flex-row align-items-center row-wrap">
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
                       <select class="selectpicker" id="offer_status" name="status">
                              <option value="">All</option>
                              <option @if(Request::has('status') && Request::get('status') == 'Live') selected="selected" @endif value="Live">Live</option>
                              <option @if(Request::has('status') && Request::get('status') == 'Upcoming') selected="selected" @endif value="Upcoming">Upcoming</option>
                              <option @if(Request::has('status') && Request::get('status') == 'Expire') selected="selected" @endif value="Expire">Expire</option>
                           </select>
               </div>
            </div>
         </div>
         <div class="flex-col-md-3 flex-col-sm-3">
            <div class="form_field_wrapper">
               <div class="filter-wrapper m-t-30 text-center">
                      <button type="submit" class="primary_btn green-fill btn_sm btn-effect">Apply</button>
                     <a href="{{route('store.offer.list')}}" class="primary_btn green-fill btn_sm m-l-20 btn-effect">Reset</a>
               </div>
               <!--
                  @if(Request::has('status'))
                     <a href="{{route('store.earning.list')}}" class="btn btn-info">CLear</a>
                  @endif -->
            </div>
         </div>
      </div>
   </div>
</form>
<!-- Offer Filter Close -->
<div class="custom_container">
<div class="white_wrapper">
<div class="table-responsive">
<table id="example" class="list-table table table-striped table-bordered" cellspacing="0" width="100%">
<thead>
<tr>
      <th>Sr. No</th>
      <th>Status</th>
      <th>Product Name</th>
      <th>Actual Price</th>
      <th>Discount</th>
      <th>Offer Start Date</th>
      <th>Offer End Date</th>
      <th>Action</th>
</tr>
</thead>
<tbody>
@if(!$storeProduct->isEmpty())
@foreach($storeProduct as $key => $item)
<tr>
            <td>{{$key + $storeProduct->firstItem()}}</td>
            <td>
            <span>{{$item->offer_status ?? 'N/A'}}</span>
            </td>
            <td><span class="td-text-wrap">{{$item->product->product_name ?? 'N/A'}}</span></td>
            <td><span>{{$item->price_range ?? 'N/A'}}</span></td>
            <td><span>{{$item->offer_range ?? 'N/A'}}</span></td>
            <td><span>{{date('d.m.Y',strtotime($item->offer_start))}}</span></td>
            <td><span>{{date('d.m.Y',strtotime($item->offer_end))}}</span></td>
            <td class="user_info">

<span class="info_icon">
<button class=""></button>
{{-- <a href="{{route('offer.edit',['id' => encrypt($item->id)])}}"><img src="{{asset('asset-store/images/pencil-edit-button.svg')}}" title="Edit"></a> --}}
<img data-request="changestatus" data-message="You want to delete this offer" data-url="{{route('offer.cancel.offer')}}" data-id = "{{encrypt($item->id)}}"  src="{{asset('asset-store/images/delete.svg')}}" title="Delete">
</span>
</td>
</tr>
@endforeach
@else
<td colspan="8">No Offer Found</td>
@endif
</tbody>
</table>
</div>
</div>
<!--Pagination-->
@if(!$storeProduct->isEmpty())
            <div class="flex-row align-items-center">
            <div class="flex-col-sm-6">
            <h6>Displaying {{$storeProduct->count()}} Records</h6>
            </div>
            <div class="flex-col-sm-6">
            <div class="paginationWrapper">
            <div class="pagenation">
            {{$storeProduct->links()}}
            </div>
            </div>
            </div>
            </div>
@endif  
<!--Pagination Close-->
</div>
</div>
@push('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="{{asset('asset-admin/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('asset-store/js/Semantic-UI-master/dist/semantic.min.js')}}"></script>
<script src="{{asset('asset-admin/js/validation.js')}}"></script>
<script src="{{asset('asset-store/js/commonFunction-store.js')}}"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script> 
<link href="{{asset('asset-store/css/jquery.ui.css')}}">
<script src="{{asset('asset-store/js/request.js')}}"></script>
<script src="{{asset('asset-store/js/datepicker.bootstrap.js')}}"></script>
<script src="{{asset('asset-store/js/offers.list.js')}}"></script>
<script>
   $(document).ready(function(){
   
   $('.ui.search')
   .search({
   apiSettings: {
   url: 'offer-search?q={query}',
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

   
   $(function () {
        $('#datetimepicker1').datetimepicker({
         format: 'YYYY-MM-DD',
        });
        $('#datetimepicker2').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD',
        });
        $("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });
    });


   });
   
</script>
@endpush
@endsection