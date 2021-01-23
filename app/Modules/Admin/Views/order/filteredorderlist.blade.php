@extends('Admin::includes.layout')


@section('content')
    <div class="wrapper">
        <!-- Side menu start here -->
        @include('Admin::includes.sidebar')
        <!-- Side menu ends here -->
        <div class="right-panel">
                @include('Admin::includes.header')
            <div class="inner-right-panel">
                <div class="breadcrumb-section">
					<ul class="breadcrumb">
						<li class="active">
							Amount
						</li>
					</ul>
                </div>
                <div class="white_wrapper  pd-20">
                        <!-- store filters -->
                            @include('Admin::includes.searchbar',['is_filterable' => true,'is_creater'=>false,'searchPlaceholder'=>trans('Admin::messages.order_placeholder'),'route_name'=>''])
                        <!-- store filters -->
                </div>
                
                <div class="filter-form-section white_wrapper  pd-20 animated">
                    <div class="filter-form">
                    <div class="sidebar-header">
                        <span class="close_filter">
                            <img src="{{asset('asset-admin/images/cross.svg')}}" alt="close">
                        </span>
                        <label>Filter</label>
                    </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Date of Registration</label>
                                    <div class="row">
                                        <div class="col-sm-6 ">
                                            <input type="text" class="form-control filter" placeholder="From" id="startDate">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control filter" placeholder="To" id="endDate">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Order Amount</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" onkeypress="return isNumber(event)" class="form-control filter" id="minAmount" placeholder="Min">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" onkeypress="return isNumber(event)" class="form-control filter" id="maxAmount" placeholder="Max">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="text" id="status" hidden value="{{$orderType}}" >
                        </div>
                        <div class="row">
							<div class="col-md-12">
								<div class="form-group mb0">
									<div class="btn-holder text-center clearfix">
                                            <button type="button" id='applyFilter' class="mr10 green-fill-btn green-border-btn" >Reset</button>
                                            <button type="button" id="applyOrderListFilter" class="green-fill-btn close_filter">Apply</button>
                                    </div>
								</div>
							</div>  
						</div>
                    </div>
                </div>
                <div class="white-wrapper clearfix">


                    <form action="{{route('admin.order.index')}}" id="form_order_list_filter">
                    <div class="adminTabularWrap">

                    <ul class="nav nav-tabs">
                        <li class="{{ !empty($orderType)&& $orderType ==  'pending' ? 'active' : ''  }}"><a class="handle_submit_order_filter" data-orderType="pending" href="javascript:void(0);">Pending</a></li>
                        <li class="{{ !empty($orderType)&& $orderType ==  'ongoing' ? 'active' : ''  }}"><a  class="handle_submit_order_filter" data-orderType="ongoing" href="javascript:void(0);">Ongoing</a></li>
                         <li class="{{ !empty($orderType)&& $orderType ==  'complete' ? 'active' : ''  }}"><a class="handle_submit_order_filter" data-orderType="complete" href="javascript:void(0);">Completed</a></li>
                        <li class="{{ !empty($orderType)&& $orderType ==  'cancelled' ? 'active' : ''  }}"><a  class="handle_submit_order_filter" data-orderType="cancelled" href="javascript:void(0);">Cancelled</a></li>
                    </ul>
                            <div class="tab-content">
                                <input type="hidden" name="productId" id="productId" value="{{$productId}}">
                                <input type="hidden" name="userId" id="userId" value="{{$userId}}">
                                <input type="hidden" name="storeId" id="storeId" value="{{$storeId}}">
                                <input type="hidden" name="orderType" id="orderTypeId">
                                
                                 <table class="outlet-table table" id="filtered_order_table">
                                 </table> 

                            </div>
                        </div>

                        </form>
                    </div>
                    


                    
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
<script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
<script src="{{asset('asset-admin/js/dataTables/filteredOrderList.js')}}"></script>
<script>

$('body').on('click','.handle_submit_order_filter',function(){
    var orderType = $(this).attr('data-OrderType');
    $("#orderTypeId").val(orderType);
    $("#form_order_list_filter").submit();

});
$('#startDate').datetimepicker({ 
                  format: 'YYYY-MM-DD',
                  useCurrent: true,
              });
      
              $('#endDate').datetimepicker({ 
                  format: 'YYYY-MM-DD',
                  useCurrent: true,
              });
</script>
@endsection