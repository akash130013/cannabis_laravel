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
							CMS
						</li>
					</ul>
                </div>
                <div class="white_wrapper  pd-20">
                    <!-- store filters -->
                    @include('Admin::includes.searchbar',['is_filterable' => false,'is_creater'=>false,'searchPlaceholder'=>trans('Admin::messages.cms_Placeholder'),'route_name'=>'admin.promocode.create'])

                    <!-- store filters -->
            </div>
                <div class="white-wrapper clearfix">
                    <table class="outlet-table table" id="cms_table">
                        
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
<script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
<script src="{{asset('asset-admin/js/dataTables/cmsList.js')}}"></script>
@endsection