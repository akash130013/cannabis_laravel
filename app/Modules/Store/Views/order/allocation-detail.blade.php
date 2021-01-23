
@if(count($driver_allocation['data']))
<div class="custom_container p-sm">
        @include('Store::layouts.pending-alert')
    <div class="flex-row align-items-center">
        <div class="flex-col-sm-6 flex-col-xs-6">
            <h2 class="title-heading m-t-b-30">Total Allocated Order</h2>
        </div>
    </div>
</div>
<div class="white_wrapper">
    <table id="order_allocation" class="list-table table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>Order ID</th>
                <th>Delivery Location</th>
                <th>Delivery Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="allocated_order">
            @foreach ($driver_allocation['data'] as $key => $item)
            @php
            $address = json_decode($item['order_detail']['delivery_address'],true);
            @endphp
            <tr>

                <td>{{$key+1}}</td>
                <td>
                    <span class="driver-status">{{$item['order_detail']['order_uid']}}</span>
                </td>

                <td><span>{{$address['formatted_address']}}</span></td>

                <td><span>{{\App\Helpers\CommonHelper::convertFormat($item['schedule_date'],'M d, Y')}}</span></td>

                <td><span class="">{{str_replace('_',' ',$item['order_detail']['order_status'])}}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- {{$driver_allocation['data']['orders']->links()}} --}}
</div>
<div class="input-holder clearfix m-t-20">
    <input type="checkbox" name="agree" id="agree">
    <label for="agree">I have gone through already allocated Orders and the driver will still be able to deliver it</label>
</div>
@endif

<form action="{{route('store.order.assign-driver',$order)}}" id="assign-driver" method="POST" class="{{count($driver_allocation['data']) ? 'hide' : ''}}">
    @csrf
    <div class="flex-row m-t-30 align-items-center m-b-0 ">
        <div class="flex-col-sm-4">

            <div class="text-field-wrapper">
                <input type="hidden" id="driver_id"  name="driver_id" value="{{$driver_id}}">
                <input type="text" value="{{ Request::has('start') ? Request::get('start') : date('d.m.Y', strtotime('today'))}}"  name="delivery_time" id="datepicker" class="m-b-0" placeholder="Add Estimated Arrival Time" autocomplete="off">
            </div>

        </div>
        <div class="flex-col-sm-4">
            <button type="button" id="submit-form" class="full-btn custom-btn green-fill getstarted btn-effect">Assign Driver</button>
        </div>
    </div>
</form>


