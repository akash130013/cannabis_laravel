@extends('Admin::includes.layout')


@section('content')
<div class="dashboard">
        <!-- Side menu start here -->
        @include('Admin::includes.sidebar')
        <!-- Side menu ends here -->
        <div class="right-panel">

                @include('Admin::includes.header')
            <div class="main-content">
                <!-- Inner Right Panel Start -->
            <div class="inner-right-panel">
                    <div class="white_wrapper dashboard-panel pd-20">
    
                        <!-- filters by date -->
                        {{-- <div class="date-filter">
                            <div class="formfilled-wrapper mb15">
                                <label>From</label>
                                <div class="input-group date datetimepickerclass" id="datetimepicker1">
                                    <input type="text" id="datetimepicker1" class="date-input startDate">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="formfilled-wrapper mb15 ml20">
                                <label>To</label>
                                <div class="input-group date datetimepickerclass" id="datetimepicker2">
                                    <input type="text" id="datetimepicker2" class="date-input">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div> --}}
                        <!-- filters by date -->
    
                        <div class="module-wrap">
                            <!-- module list start -->
                            <div class="module-list">
                                <!-- module repeat -->
                                <div class="module">
                                    <div class="module-detail pd-20">
                                        <div>
                                            <label>Users</label>
                                            <p class="num-of-count">{{$data->userCount}}</p>
                                        </div>
                                        <figure>
                                            <img src="{{asset('asset-admin/images/cann-users.svg')}}" alt="Users" />
                                        </figure>
                                    </div>
                                    <div class="module-status">
                                        {{-- <p>New Users</p>
                                        <p>20</p> --}}
                                    </div>
                                </div>
                                <!-- module repeat -->
                                <!-- module repeat -->
                                <div class="module">
                                    <div class="module-detail pd-20">
                                        <div>
                                            <label>Drivers</label>
                                            <p class="num-of-count">{{$data->driverCount}}</p>
                                        </div>
                                        <figure>
                                            <img src="{{asset('asset-admin/images/taxi-driver.svg')}}" alt="Drivers" />
                                        </figure>
                                    </div>
                                    <div class="module-status">
                                        {{-- <p>New Drivers</p>
                                        <p>20</p> --}}
                                    </div>
                                </div>
                                <!-- module repeat -->
                                <!-- module repeat -->
                                <div class="module">
                                    <div class="module-detail pd-20">
                                        <div>
                                            <label>Completed Orders</label>
                                            <p class="num-of-count">{{$data->orderCount}}</p>
                                        </div>
                                        <figure>
                                            <img src="{{asset('asset-admin/images/cart.svg')}}" alt="Completed Orders" />
                                        </figure>
                                    </div>
                                    <div class="module-status">
                                        {{-- <p>Pending Orders</p>
                                        <p>20</p> --}}
                                    </div>
                                </div>
                                <!-- module repeat -->
                            </div>
                            <!-- module list end -->
    
                            <!-- module list start -->
                            <div class="module-list">
    
                                <!-- module repeat -->
                                <div class="module">
                                    <div class="module-detail pd-20">
                                        <div>
                                            <label>Products</label>
                                            <p class="num-of-count">{{$data->productCount}}</p>
                                        </div>
                                        <figure>
                                            <img src="{{asset('asset-admin/images/products.svg')}}" alt="Products" />
                                        </figure>
                                    </div>
                                    <div class="module-status">
                                            {{-- <p>Pending Orders</p>
                                            <p>20</p> --}}
                                        </div>
                                </div>
                                <!-- module repeat -->
    
                                <!-- module repeat -->
                                <div class="module">
                                    <div class="module-detail pd-20">
                                        <div>
                                            <label>Payments</label>
                                            <p class="num-of-count">{{$data->paymentCount}}</p>
                                        </div>
                                        <figure>
                                            <img src="{{asset('asset-admin/images/money.svg')}}" alt="Payments" />
                                        </figure>
                                    </div>
                                    <div class="module-status">
                                            {{-- <p>Pending Orders</p>
                                            <p>20</p> --}}
                                        </div>
                                </div>
                                <!-- module repeat -->
    
                                <!-- module repeat -->
                                <div class="module">
                                    <div class="module-detail pd-20">
                                        <div>
                                            <label>Requested Stores</label>
                                            <p class="num-of-count">{{$data->requestedStoretCount}}</p>
                                        </div>
                                        <figure>
                                            <img src="{{asset('asset-admin/images/cann-store.svg')}}" alt="Requested Stores" />
                                        </figure>
                                    </div>
                                    <div class="module-status">
                                            
                                        </div>  
                                </div>
                                <!-- module repeat -->
                            </div>
                            <!-- module list end -->
                        </div>
                    </div>
                </div>
                <!-- Inner Right Panel end -->  

            </div>
        </div>
    </div>
</div>
@endsection