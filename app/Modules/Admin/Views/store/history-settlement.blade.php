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
							<a href="{{route('admin.store.index')}}">Store</a>
                        </li>
                        <li class="active">
                            <a href="{{route('admin.store.show',['id'=>$encryptId])}}">{{$store_name}}</a>
                        </li>
                        <li class="active">
                            <a href="#" class="active">Settlement</a>
                        </li>
					</ul>
                </div>
                <div class="white_wrapper pd-20">
                        <!-- store filters -->
                        @include('Admin::includes.searchbar',['is_filterable' => false,'is_creater'=>false,'searchPlaceholder'=>trans('Admin::messages.open_settlement_Placeholder'),'route_name'=>''])
                        <!-- store filters -->
                </div>
                <div class="filter-form-section animated">
                    <div class="filter-form">
                        <div class="row">
                           
                            <div class="col-md-3 col-sm-6 col-xs-12">
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
                            
                        </div>
                        <div class="row">
							<div class="col-md-12">
								<div class="form-group mb0">
									<div class="btn-holder clearfix">
										<button type="button" id='applyFilter' class="btn back hvr-ripple-out resetbutton">Reset</button>
										<button type="button" class="btn success hvr-ripple-out applybutton">Close</button>
									</div>
								</div>
							</div>
                        </div>
                        <input type="hidden" id="status" value="{{config('constants.STATUS.CLOSED')}}">
                        <input type="hidden" id="encryptStoreId" value="{{$encryptId}}">
                    </div>
                </div>
                <ul class="nav nav-tabs">
                    <li><a  href="{{route('admin.store.open.settlement',['id'=>$encryptId,'store_name'=>$store_name])}}">Settlement Due</a></li>
                    <li class="active"><a >Settlement History</a></li>
                </ul>
                <div class="white-wrapper clearfix">
                    <table class="outlet-table table ctd" id="open_settlement">
                        
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
<script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
<script src="{{asset('asset-admin/js/dataTables/openSettlement.js')}}"></script>
<script> $('#startDate').datetimepicker({ 
        format: 'YYYY-MM-DD',
        useCurrent: true,
    });

    $('#endDate').datetimepicker({ 
        format: 'YYYY-MM-DD',
        useCurrent: true,
    });
    
</script>
@endsection