@extends('Admin::includes.layout')

@section('content')
<div class="dashboard">
   <!-- Side menu start here -->
  
  
   @include('Admin::includes.sidebar')
   <!-- Side menu ends here -->


   
    <!--Right Panel-->
    <div class="right-panel">
        <!-- Header Start-->
        @include('Admin::includes.header')
        <!-- Header End-->
        <!-- Inner Right Panel Start -->

        <div class="inner-right-panel">
            <!--breadcrumb-->
            <div class="bred-crumbs">
                <ul>
                    <li>
                        <a href="{{route('admin.order.index')}}">Order</a> 
                    </li>

                    <li>
                        <a href="#" class="active">Details</a> 
                    </li>

                </ul>
            </div>
            <!--breadcrumb Close-->
            <div class="inner-right-panel">

                <!-- Order Details -->
                <div class="white_wrapper order-details">
                    <div>
                        <!-- row repeat -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">Order Id</label>
                                <span class="label-data">{{$data->order_uid}}</span>
                            </div>
                            
                            <div class="flex-col-sm-4">
                                <label class="table-label">Store name</label>
                                <span class="label-data numOf">
                                    <a href="/admin/store/show/{{$data->store_id}}">
                                    {{$data->order_data['cartListing'][0]['storeDetail']}}
                                </a>
                                </span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Order Date</label>
                                <span class="label-data">{{\App\Helpers\CommonHelper::dateFormat($data->created_at,'M d, Y')}}</span>
                            </div>
                        </div>
                        <!-- row repeat -->

                        <!-- row repeat -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">Delivery Address</label>
                                <span class="label-data">{{$data->delivery_address['formatted_address']??'--'}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">No. of Products</label>
                                <span class="label-data">{{$data->order_data['itemCount']}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Status</label>
                                <span class="label-data">{{ucfirst(str_replace('_',' ',$data->order_status))}}</span>
                            </div>
                        </div>
                        <!-- row repeat -->

                        <!-- row repeat -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">Customer Details</label>
                            <span class="label-data numOf"><a href="/admin/user/show/{{$data->user_id}}">{{$data->user->name??'--'}} </a></span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Ratings</label>
                                <span class="label-data">NA</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Total Payable Amount</label>
                                <span class="label-data">$ {{$data->net_amount}}</span>
                            </div>
                        </div>
                        <!-- row repeat -->

                        <!-- row repeat -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">Discounted Coupon</label>
                            <span class="label-data">{{$data->order_data['total']['promo_code_applied']??'--'}} </span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Discounted Amount</label>
                            
                            @if(isset($data->order_data['total']['discounts']['promo_discount']))
                                <span class="label-data"> $ {!!isset($data->order_data['total']['discounts']['promo_discount']) ? @$data->order_data['total']['discounts']['promo_discount'] : '0.00'!!} </span>
                            @elseif(isset($data->order_data['total']['discounts']['loyaltyPoint']))
                            <span class="label-data">  $ {!!isset($data->order_data['total']['discounts']['loyaltyPoint']) ? @round($data->order_data['total']['discounts']['loyaltyPoint'],2) : '0.00'!!} </span>
                            @else
                            <span class="label-data">   $ 0.0 </span>
                            @endif
                            </div>
                        </div>
                        <!-- row repeat -->

                    </div>
                </div>
                <!-- Order Details -->

                <!-- Order Detail Table -->
                <div class="">
                    <!--block heading -->
                    <div class="blok_heading">
                        <h2>Order Details</h2> 
                    </div>
                    <!--block heading -->

                    <div>
                        <!-- List Table -->
                        <table class="table table-striped">
                            <!-- Table Header -->
                            <thead>
                                <tr>
                                    <th>S.NO</th>
                                    {{-- <th>Product ID</th> --}}
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Product Packing</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    {{-- <th>Coupon Used</th>--}}
                                    <th>Offered Price</th> 
                                </tr>
                            </thead>
                            <!-- Table Header -->
                            <!-- Table Body -->
                            <tbody>
                                <!-- Table Row Repeat -->
                                @foreach ($data->products as $item)
                                <tr>
                                    <td>{{$item['s_no']}}</td>
                                    {{-- <td>{{$item[0]}}</td> --}}
                                    <td class="numOf"> <a href="/admin/product/show/{{$item['encrypt_product_id']}}">{{$item['product_name']}}</a></td>
                                    <td>{{$item['category']}}</td>
                                    <td>{{$item['product_packing']}}</td>
                                    <td>{{$item['quantity']}}</td>
                                    <td>$ {{$item['price']}}</td>
                                    {{-- <td class="txt-caps">{{$data->order_data['total']['promo_code_applied']}}</td>--}}
                                    <td>{{$item['offered_price']}}</td> 
                                </tr>
                                @endforeach
                                <!-- Table Row Repeat -->
                            </tbody>
                        </table>
                        <!-- List Table -->

                    </div>

                    
                </div>
                <!-- Order Detail Table -->




            </div>
        </div>
    </div>

</div>
@endsection