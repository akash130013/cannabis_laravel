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
							User
						</li>
					</ul>
                </div>

                <div class="white_wrapper user-list pd-20">
                    <!-- store filters -->
                    @include('Admin::includes.searchbar',['is_filterable' => true,'is_creater'=>false,'searchPlaceholder'=>trans('Admin::messages.user_placeholder'),'route_name'=>''])
                    <!-- store filters -->
                </div>
                
                
                <div class="search-filter-section">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="export-assets" class="filter-print"></div>
                            <ul class="filter-print">
                                {{-- <li>
                                    <a href="{{route('admin.category.create')}}" class="add-icon" title="Add">
                                        <img src="{{ asset('asset-admin/images/add.svg')}}" alt="Add">
                                    </a>
                                </li> --}}
                                <li>
                                    {{-- <a href="javascript:void(0)" class="filter-icon">
                                        <img src="{{ asset('asset-admin/images/filter.svg')}}" alt="Filter">
                                    </a> --}}
                                </li>
                            </ul>
                        </div>
                    </div>
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
                           
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="form-label">Date of Registration</label>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{-- <label class="form-label">From</label> --}}
                                            <input type="text" class="form-control filter"  class="startDate" id="startDate" placeholder="From">
                                              {{-- <input type="date" class="form-control filter" placeholder="From" id="startDate"> --}}
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{-- <label class="form-label">To</label> --}}
                                            <input type="text" class="form-control filter" id="endDate" placeholder="To">
                                            {{-- <input type="date" class="form-control filter" placeholder="To" id="endDate"> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="form-label">Date of Birth</label>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{-- <label class="form-label">From</label> --}}
                                            <input type="text" class="form-control filter" id="startDOB" placeholder="From">
                                            {{-- <input type="date" class="form-control filter" placeholder="From" id="startDOB"> --}}
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{-- <label class="form-label">To</label> --}}
                                            <input type="text" class="form-control filter" id="endDOB" placeholder="To">
                                            {{-- <input type="date" class="form-control filter" placeholder="To" id="endDOB"> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="text" hidden id="promoCode" value="{{$promoCode}}">
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select data-text="Status" class="form-label filter filter-select" name="status" id="status">
                                        <option value="" selected>All</option>
                                        <option value="active">Active</option>
                                        <option value="blocked">Blocked</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-md-12">
								<div class="form-group mb0">

                                <div class="btn-space text-center clearfix">
                                    <button class="mr10 green-fill-btn green-border-btn" id="applyFilter">Reset</button>
                                    <button class="green-fill-btn close_filter"  id='applyUserFilter'>Apply</button>
                                </div>
									<!-- <div class="btn-holder clearfix">
										<button type="button" class="btn back hvr-ripple-out resetbutton">Reset</button>
										<button type="button" class="btn success hvr-ripple-out applybutton">Close</button>
									</div> -->
								</div>
							</div>
						</div>
                    </div>
                </div>
                <div class="white-wrapper clearfix">
                    <table class="outlet-table table" id="user_table">
                    </table>
                </div>



                
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
<script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
<script src="{{asset('asset-admin/js/dataTables/userList.js')}}"></script>
<script>
        $('#startDate').datetimepicker({ 
            format: 'YYYY-MM-DD',
            useCurrent: true,
        });

        $('#endDate').datetimepicker({ 
            format: 'YYYY-MM-DD',
            useCurrent: true,
        });
        $('#startDOB').datetimepicker({ 
            format: 'YYYY-MM-DD',
            useCurrent: true,
        });

        $('#endDOB').datetimepicker({ 
            format: 'YYYY-MM-DD',
            useCurrent: true,
        });
        </script>
@endsection