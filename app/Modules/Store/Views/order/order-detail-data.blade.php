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