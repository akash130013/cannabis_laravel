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
							Location
						</li>
					</ul>
                </div>
                <div class="white_wrapper  pd-20">
                     <!-- store filters -->
                        @include('Admin::includes.searchbar',['is_filterable' => false,'is_creater'=>false,'searchPlaceholder'=>trans('Admin::messages.distributor_location_placeholder'),'route_name'=>''])
                        <!-- store filters -->

                    @if ($toImport > 0)
                        <p>Please wait, CSV file upload is in progress ..!</p>
                    @endif


                    <form action="{{ route('admin.upload.delivery.address') }}" id="save_delivery_location" method="POST" enctype="multipart/form-data">
                        @csrf
{{--                        <div class="form-group">--}}
{{--                            <label class="form-label">Upload Delivey address</label>--}}
{{--                            <input type="file" accept=".csv,.txt" name="file">--}}
{{--                        </div>--}}

                        <div class="flex-col-sm-12">
                            <div class="seprate-menu">
                                <!-- apply filters -->
                                <ul>
                                    <li style="width:300px">
                                       <div class="textfilled-wrapper">
                                            {{-- <input type="file" accept=".csv,.txt" name="file"> --}}
                                         <input type="text" placeholder="Upload Delivery Address" readonly="false" id="fileName">
                                         <label for="upload_img" class="upload_doc">CHOOSE</label>
                                       </div>
                                       <span id="upload-error"></span>
                                    </li>

                                    <li>

                                    <button class="green-fill-btn" type="submit">Import</button>
                                    </li>

                                    <li>
                                        <a class="green-fill-btn btn" href="{{asset('/AddressUploadFormat.csv')}}" type="button" download>
                                            Download
                                        </a>
                                    </li>
                                    <li>

                                        <input type="file" accept=".csv,.txt" name="file" style="visibility:hidden" id="upload_img">
                                    </li>


                                </ul>
                                <!-- apply filters -->
                                <label id="upload_img-error" class="error" for="upload_img"></label>

                            </div>
                        </div>
                        {{-- <button class="btn btn-success">Import</button> --}}
                        @if(Session::has('error'))
                        <span class="error">{{Session::get('error')['message']}}</span>
                        @endif

                        @if(Session::has('success') && Session::get('success')['code']==config('constants.SuccessCode'))
                        <span class="success">{{Session::get('success')['message']}}</span>
                        @endif

                        @if(Session::has('success') && Session::get('success')['code']==config('constants.NonAuthonticate'))
                        <span class="error fadeout-error">{{Session::get('success')['message']}}</span>
                        @endif


                    </form>
                    <!-- store filters -->

                    <!-- <label>Download Sample CSV</label>
                <a href="{{asset('/AddressUploadFormat.csv')}}" download type="button">Download</a> -->
                </div>
                <div class="white-wrapper clearfix">
                    <table class="outlet-table table" id="deliver_location_table">


                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pagescript')
<script src="{{asset('asset-admin/js/nprogress.js')}}"></script>
<script src="{{asset('asset-admin/js/dataTables/deliveryLocation.js')}}"></script>
<script src="{{asset('asset-admin/js/location.js')}}"></script>
@endsection
