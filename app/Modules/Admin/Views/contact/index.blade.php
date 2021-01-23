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
							Contact
						</li>
					</ul>
                </div>

                <div class="white_wrapper user-list pd-20">
                    <!-- store filters -->
                    @include('Admin::includes.searchbar',['is_filterable' => false,'is_creater'=>false,'searchPlaceholder'=>trans('Admin::messages.contact_query_placeholder'),'route_name'=>''])
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
                
                <div class="white-wrapper clearfix">
                    <table class="outlet-table table" id="contact_query_table">
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
<script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
<script src="{{asset('asset-admin/js/dataTables/contactList.js')}}"></script>
@endsection