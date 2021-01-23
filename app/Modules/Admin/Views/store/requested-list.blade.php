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
						  Requested Store
						</li>
					</ul>
                </div>
                <div class="white_wrapper  pd-20">
                        <!-- store filters -->
                        @include('Admin::includes.searchbar',['is_filterable' => true,'is_creater'=>false,'searchPlaceholder'=>trans('Admin::messages.requested_store_Placeholder'),'route_name'=>''])
                        <!-- store filters -->
                </div>
                <div class="filter-form-section  white_wrapper  pd-20 animated">
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
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control filter" placeholder="From" id="startDate">
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" class="form-control filter" placeholder="To" id="endDate">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select data-text="Status" class="form-label filter filter-select" name="status" id="status">
                                        <option value="" selected>All</option>
                                        <option value="reject">Rejected</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-md-12">
								<div class="form-group mb0">
									<div class="btn-holder clearfix text-center">
                                        <button type="button" id='applyFilter' class="mr10 green-fill-btn green-border-btn" >Reset</button>
                                        <button type="button" id="applyRequestedStoreFilter" class="green-fill-btn close_filter">Apply</button>
                                    </div>
								</div>
							</div>
						</div>
                    </div>
                </div>
                <ul class="nav nav-tabs">
                    <li><a href="{{route('admin.store.index')}}">Store</a></li>
                    <li class="active"><a>Requested Store</a></li>
                </ul>
                <div class="white-wrapper clearfix">
                    <table class="outlet-table table ctd" id="requested_store_table">
                        
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- Modal Popup: to show delivery locations in store & settlement management  -->
<div id="MyPopup" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
          </div>
          <div class="modal-body">
              <div class="locationdiv">
                  <ul></ul>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
    
      </div>
</div>
{{-- End::Modal --}}
<!-- Modal Popup:: to update  -->
<div id="CommissionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="POST" action="">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="storeId" name="storeId">
                    <div class="address">
                        <p></p>
                    </div>
                    <hr>
                        <p>Set Commision Percentage</p>
                        <input type="text" name="commission_percentage" > 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
    </div>
@endsection
@section('pagescript')
<script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
<script src="{{asset('asset-admin/js/dataTables/requestedStoreList.js')}}"></script>
<script> 
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