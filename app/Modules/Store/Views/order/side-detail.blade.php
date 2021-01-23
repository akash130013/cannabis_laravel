@php
    $orderDetail  = is_array($order['order_data']) ? $order['order_data'] : json_decode($order['order_data'],true);
    // info($orderDetail);
@endphp
<div class="cart_right_col">
<span class="close_img close_order_state">
                        <img src="{{asset('asset-store/images/close-line.svg')}}" />
                  </span>
    <div class="item_detail">
        <h2 class="order_detail_heading">Order Details</h2>
        <div class="items">
            @foreach ($orderDetail['cartListing'] as $item)
                <div class="flex-row">
                    <div class="flex-col-sm-10">
                        <span class="item_name_sm">{{$item['product_name']}} x{{$item['quantity']}}</span>
                    </div>
                    <div class="flex-col-sm-2">
                        <label class="form_label text-right">$ {{number_format($item['per_item_selling_price']* $item['quantity'], 2)}}</label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="total_items">
            <div class="flex-row">
                <div class="flex-col-sm-10">
                    <span class="item_name_sm">Item Total</span>
                </div>
                <div class="flex-col-sm-2">
                    <label class="form_label text-right">$ {{number_format($orderDetail['total']['cartSubTotal'], 2)}}</label>
                </div>
            </div>
            <div class="flex-row">
                <div class="flex-col-sm-10">
                    <label class="form_label">Order Packing Charges</label>
                </div>
                <div class="flex-col-sm-2 text-right">
                    <label class="form_label">$ {{$orderDetail['total']['additional_charges'] ? $orderDetail['total']['additional_charges'] : '0.00'}}</label>
                </div>
            </div>
                <div class="flex-row">
                    <div class="flex-col-sm-10">
                        <label class="form_label">Discount</label>
                    </div>
                    <div class="flex-col-sm-2 text-right">
                        <label class="form_label"> -
                @if(isset($orderDetail['total']['discounts']['promo_discount']))
                    $ {!!isset($orderDetail['total']['discounts']['promo_discount']) ? @$orderDetail['total']['discounts']['promo_discount'] : '0.00'!!}
                @elseif(isset($orderDetail['total']['discounts']['loyaltyPoint']))
                    $ {!!isset($orderDetail['total']['discounts']['loyaltyPoint']) ? @round($orderDetail['total']['discounts']['loyaltyPoint'],2) : '0.00'!!}
                @else
                    $ 0.0
                @endif
                </label>
                    </div>
                </div>
        </div>
        <div class="total_bill">
            <div class="flex-row">
                <div class="flex-col-sm-6">
                    <label class="total_bill_label primary_color">Order TOTAL</label>
                </div>
                <div class="flex-col-sm-6 text-right">
                    <label class="total_bill_label primary_color">$ {{number_format($orderDetail['total']['net_amount'], 2)}}</label>
                </div>
            </div>
            <h2 class="order_detail_heading">Verification Documents</h2>


            <div class="items">

                <div class="flex-row">
                    <div class="flex-col-sm-6">
                        <span class="item_name_sm">Date of Birth</span>
                    </div>
                    <div class="flex-col-sm-6">
                        <label class="form_label text-right">{{$order['customer']['dob']}}</label>
                    </div>
                </div>

                @foreach ($order['customer']['proofs'] as $item)
                    <div class="flex-row">
                        <div class="flex-col-sm-6">
                            <span class="item_name_sm">{{$item['type'] == 1 ? 'Age Proof' : 'Medical Proof'}}</span>
                        </div>
                        <div class="flex-col-sm-6">
                        <a href="{{$item->file_url}}" target="_blank">
                            <span class="form_label text-right"> {{$item['file_name']}}</span>
                        </a>
                        </div>
                    </div>

                @endforeach

            </div>

            <h2 class="order_detail_heading">Billing & Shipping Details</h2>

            <div class="flex-row m-t-30">
                <div class="flex-col-sm-12">
                    <input type="hidden" id="delivery_address_type" value="{{$orderDetail['delivery_address']['address_type']}}">
                    <span class="save_address_type 
                    @if($orderDetail['delivery_address']['address_type'] == 'Home') home
                    @elseif($orderDetail['delivery_address']['address_type'] == 'Office') office
                    @else other @endif">{{$orderDetail['delivery_address']['address_type']}}</span>
                    <label class="form_label">Shipping Address</label>
                    <span class="title">{{$orderDetail['delivery_address']['name']}}</span>
                    <div class="address">
                        <p>House No. {{$orderDetail['delivery_address']['address']}}</p>
                        <p> {{$orderDetail['delivery_address']['formatted_address']}}
                            ,{{$orderDetail['delivery_address']['zipcode']}}</p>
                        <p>Mobile Number: {{$orderDetail['delivery_address']['mobile']}} </p>
                    </div>
                </div>
            </div>
            <div class="flex-row m-t-30">
                @if($order->order_status == 'driver_assigned' && isset($order->distributors->first()->name))
                    <div class="flex-col-sm-12">
                        <label class="form_label">Driver Name</label>
                        <span class="title td-text-wrap">{{ @$order->distributors->first()->name }}</span>
                    </div>
                @endif
            </div>
            @if(in_array($order->order_status, [ 'order_placed','order_verified']))

                <div class="flex-row m-t-30">
                    <div class="flex-col-sm-12">
                        <div class="input-holder clearfix">
                            <input type="checkbox" name="stock" id="stock" value="1">
                            <label for="stock">I have viewed and verified the users verification
                                documents</span></label>
                        </div>
                    </div>
                </div>
            @endif
            <div class="flex-row m-t-30">
                <div class="flex-col-sm-12">
                    <div class="button_wrapper text-center">
                        <ul class="button"> 
                            @if(in_array($order->order_status, [ 'order_placed','order_verified']))
                                <li>
                                    {{-- <form action="{{route('store.order.update',$order->id)}}" method="POST"> --}}
                                    {{-- @method('PUT')
                                    @csrf --}}
                                    {{-- <input type="hidden" value="order_confirmed" name="status"/> --}}
                                    <button class="green-fill location_status custom-btn btn-effect disabled" data-msg="Accept"
                                            id="location_status" data-href="{{route('store.order.update',$order->id)}}"
                                            data-lang="{{trans('Store::home.accept_order_popup')}}"
                                            data-status="order_confirmed" disabled>Accept
                                    </button>
                                    {{-- </form> --}}
                                </li>
                            @endif
                            @if(in_array($order->order_status, [ 'order_placed','order_verified','order_confirmed','driver_assigned']))
                                <li>
                                    <a   class="green-fill outline-btn reject-btn btn-sm" data-msg="Reject"
                                            id="rejectOrder" data-orderId="{{$order->id}}" data-href="{{ route('store.cancel-order',$order->id) }}"
                                            data-lang="{{trans('Store::home.reject_order_popup')}}"
                                            data-status="order_cancelled" disabled>Reject
                                    </a>

                                </li>
                            @endif
                            @if(request()->segment('3') != 'get-driver' && in_array($order->order_status, [ 'order_confirmed']))
                                <li>
                                    <a href="{{route('store.order.driver-list',$order->id)}}"
                                       class="green-fill custom-btn btn-sm btn-effect" disabled>Assign Driver</a>
                                </li>
                            @endif
                            @if(request()->segment('3') != 'get-driver' && $order->order_status == 'driver_assigned')
                                <li>
                                    <a href="{{route('store.order.driver-list',$order->id)}}"
                                       class="green-fill custom-btn btn-sm btn-effect">Re-Assign Driver</a>
                                </li>
                                <li>
                                    <button data-request="ajax"
                                            data-message="Are you sure you want to un assign driver?"
                                            data-id="{{$order->id}}" data-type="POST"
                                            data-driver-id="{{$order->drivers?$order->drivers->distributor_id:''}}"
                                            data-url="{{route('store.order.un-assign-driver')}}"
                                            class="green-fill outline-btn reject-btn btn-sm">Un-Assign Driver
                                    </button>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
