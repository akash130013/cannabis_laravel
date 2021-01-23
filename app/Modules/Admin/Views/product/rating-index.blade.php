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
							<a href="{{route('admin.product.listing')}}">Product</a>
                            
                        </li>
                        <li>
                            <a href="{{route('product.show',['id'=>$encryptProductId])}}">{{$data->product_name}}</a>
                        </li>
                        <li class="active">Review & Ratings</li>
					</ul>
                </div>
                <div class="white_wrapper  pd-20">
                        <!-- store filters -->
                            @include('Admin::includes.searchbar',['is_filterable' => true,'is_creater'=>false,'searchPlaceholder'=>trans('Admin::messages.product_rating_placeholder'),'route_name'=>'admin.show.add.product'])
                        <!-- store filters -->
                </div>
               
                <div class="filter-form-section animated">
                    <div class="filter-form">
                        <div class="row">
                        <input type="hidden" value="{{$encryptProductId}}" id="encryptProductId">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label">Ratings</label>
                                    <div class="row">
                                        <div class="col-mf-6 col-sm-6 col-xs-12">
                                            <input type="text" onkeypress="return isNumber(event)" class="form-control filter" id="minRate" placeholder="Min">
                                        </div>
                                        <div class="col-mf-6 col-sm-6 col-xs-12">
                                            <input type="text" onkeypress="return isNumber(event)" class="form-control filter" id="maxRate" placeholder="Max">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="form-label">Filter by Date</label>
                                        <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <input type="text" class="form-control filter" placeholder="From" id="startDate">
                                                </div>
                                                <div class="col-md-6 col-sm-6">
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
                                            <button type="button" id='applyFilter' class="mr10 green-fill-btn green-border-btn">Reset</button>
                                            <button type="button" class="green-fill-btn" id="applyProductRatingFilter">Apply</button>
                                        </div>
								</div>
							</div>  
						</div> 
                    </div>
                </div>
                <div class="white-wrapper clearfix">
                    <div class="adminTabularWrap">
                            <div class="tab-content">
                                    <table class="outlet-table table" id="product_rating_table"></table> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
 <script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
 <script src="{{asset('asset-admin/js/dataTables/productRatingList.js')}}"></script>
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