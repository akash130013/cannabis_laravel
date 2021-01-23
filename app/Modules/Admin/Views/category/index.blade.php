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
							Category
						</li>
					</ul>
                </div>
                <div class="white_wrapper  pd-20">
                        <!-- store filters -->
                            @include('Admin::includes.searchbar',['is_filterable' => true,'is_creater'=>true,'searchPlaceholder'=>'Search By Category name','route_name'=>'admin.category.create'])
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
                                {{-- <li>
                                    <a href="javascript:void(0)" class="filter-icon">
                                        <img src="{{ asset('asset-admin/images/filter.svg')}}" alt="Filter">
                                    </a>
                                </li> --}}
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
                            {{-- <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select >
                                        <option value="">Category 1</option>
                                        <option value="">Category 2</option>
                                        <option value="">Category 3</option>
                                        <option value="">Category 4</option>
                                        <option value="">Category 5</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label">No Of Product</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" onkeypress="return isNumber(event)" class="form-control filter" placeholder="Min" id="minProduct">
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" onkeypress="return isNumber(event)" class="form-control filter" placeholder="Max" id="maxProduct">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            <div class="col-xs-12">
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

                               <div class="btn-space text-center">
                                    <button class="mr10 green-fill-btn green-border-btn" id="applyFilter">Reset</button>
                                    <button class="green-fill-btn close_filter"  id='applyCategoryFilter'>Apply</button>
                                </div>


                                <!-- <div class="form-group mb0">
									<div class="btn-holder clearfix">
										<button type="button" id='applyFilter' class="mr10 green-fill-btn green-border-btn" >Reset</button>
										<button type="button" id="applyCategoryFilter" class="green-fill-btn">Apply</button>
									</div>
								</div> -->
							</div>
						</div>
                    </div>
                </div>
                <div class="white-wrapper clearfix">
                    <table class="outlet-table table" id="category_table">
                        
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
<script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
<script src="{{asset('asset-admin/js/dataTables/categoryList.js')}}"></script>

@endsection