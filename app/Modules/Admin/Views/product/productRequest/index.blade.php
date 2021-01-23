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
						   Requested Product
						</li>
					</ul>
				</div>
                <div class="white_wrapper  pd-20">
                        <!-- store filters -->
                        @include('Admin::includes.searchbar',['is_filterable' => false,'is_creater'=>false,'searchPlaceholder'=>trans('Admin::messages.product_placeholder'),'route_name'=>''])
                        <!-- store filters -->
                </div>
                
                <div class="white-wrapper clearfix">
                        <div class="adminTabularWrap">
    
                        <ul class="nav nav-tabs">
                            <li><a  href="{{route('admin.product.listing')}}">Product</a></li>
                            <li class="active"><a  data-toggle="tab" href="#home">Requested Product</a></li>
                        </ul>
                         
                                <div class="tab-content">
    
                                     <table class="outlet-table table" id="product_request_table"></table> 
    
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
<script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
<script src="{{asset('asset-admin/js/dataTables/productRequestList.js')}}"></script>
@endsection