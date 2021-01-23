@extends("Store::layouts.master")

@section('content')


<div class=" custom_container p-sm">
    @include('Store::layouts.pending-alert')
    <div class="white_wrapper">
        <form action="{{route('store.order.driver-list',$order->id)}}" method="GET" id="list-form">
            <div class="flex-row align-items-center">
                <div class="flex-col-sm-6 flex-col-xs-6">
                    <h2 class="title-heading m-t-b-30">Assign Driver (Order ID: {{$order->order_uid}})</h2>
                </div>
                <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                    <!--search-->
                    
                    <div class="product-srch-col-header ui search">
                        <div class="text-field-wrapper  pro-srchbox ui left icon input">
                            <input class="prompt" type="text" placeholder="Search by driver name" id="searchElementProduct" name="keyword" value="{{request()->query('keyword')}}">
                            <i class="search icon"></i>
                            
                            @if(Request::has('keyword') && !empty(Request::get('keyword')) )
                            <a href="{{route('store.order.driver-list',['id'=>$id])}}"><img  src="{{asset('asset-store/images/cross.svg')}}" class="closeProductMenu" alt="cross"></a>
                            @endif
                            
                        </div>
                        
                        
                    </div>
                    
                    <!--search close-->
                </div>
            </div>
        </form>
    </div>
</div>

<div class="full_custom_container">
    <div class="wrap-row-full">
        <div class="col-left-lg">
            
            <div class="white_wrapper">
                <table id="example" class="list-table table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Sr. No</th>
                            <th>Driver Status</th>
                            <th>Driver Name</th>
                            <th>Vehicle Details</th>
                            <th>Order Delivery Allocated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($driver_list as $key => $item)
                        <tr>
                            <td>
                                <div class="input-holder clearfix">
                                <input type="radio" name="driver" id="{{$key}}" data-driver-id="{{$item->distributor->id}}" class="select_driver" value="{{$order->id}}" data-url="{{route('store.order.driver-orders',$item->distributor->id)}}">
                                    <label for="{{$key}}"></label>
                                </div>
                            </td>
                            <td>
                                {{$key+1}}
                            </td>
                            <td>
                                <span class="driver-status @if($item->distributor->current_status == 'online') online 
                                    @elseif($item->distributor->current_status == 'busy')busy
                                    @else offline @endif">{{ucFirst($item->distributor->current_status)}}</span>
                                </td>
                                
                                <td><span class="td-text-wrap">{{$item->distributor->name ?? 'N/A'}}</span></td>
                                
                                <td><span class="td-text-wrap">{{$item->distributor && $item->distributor->vehicle_number ? $item->distributor->vehicle_number : 'N/A'}}</span></td>
                                <td><span class="">{{$item->assgined_orders_count ?? 'N/A'}}</span></td>
                            </tr>
                            @empty
                            
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{$driver_list->links()}}
                <div id="allocation_detail" class="hide">
                    
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
                            {{-- <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Order ID</th>
                                    <th>Delivery Location</th>
                                    <th>Delivery Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead> --}}

                        </table>
                        
                    </div>
                    <div class="input-holder clearfix m-t-20">
                        <input type="checkbox" name="agree" id="agree">
                        <label for="agree">I have gone through already allocated Orders and the driver will still be able to deliver it</label>
                    </div>
                    
                    <form action="{{route('store.order.assign-driver',$order)}}" id="assign-driver" method="POST" class="hide">
                        @csrf
                        <div class="flex-row m-t-30 align-items-center m-b-0 ">
                            <div class="flex-col-sm-4">
                                
                                <div class="text-field-wrapper">
                                    <input type="hidden" id="driver_id"  name="driver_id" value="">
                                    <input type="text" value="{{ Request::has('start') ? Request::get('start') : date('d.m.Y', strtotime('today'))}}"  name="delivery_time" id="datepicker" class="m-b-0" placeholder="Add Estimated Arrival Time" autocomplete="off">
                                </div>
                                
                            </div>
                            <div class="flex-col-sm-4">
                                <button type="button" id="submit-form" class="full-btn custom-btn green-fill getstarted btn-effect">Assign Driver</button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
            <div class="order-detail-col">
                <div  id="side-detail">
                    @include('Store::order.side-detail',$order)
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="searchUrl" value="{{route('store.order.search.driver')}}">
    @endsection
    
    @push('css')
    <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet"/>
    @endpush
    
    @push('script')
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('asset-store/js/request.js')}}"></script>
    <script src="{{asset('asset-store/js/order-list.js')}}"></script>
    <script src="{{asset('asset-store/js/Easy-jQuery-Client-side-List-Filtering-Plugin-list-search/js/list-search-min.js')}}"></script>
    <script src="{{asset('asset-store/js/Semantic-UI-master/dist/semantic.min.js')}}"></script>
    <script src="{{asset('asset-store/js/search-list.js')}}"></script>
    
    <script>
        
        // $(document).ready(function()
        // {
            //     var delivery_type = $('#delivery_address_type').val();
            //     var type = 'other';
            //     if(delivery_type.toLowerCase == 'home')
            //     {
                //         type ='home';
                //     }
                //     else if(delivery_type.toLowerCase == 'office')
                //     {
                    //         type ='office';
                    //     }
                    
                    //     $('.save_address_type').addClass(type);
                    
                    // })
                    
                    appendOrder=(next_url)=>{
                        
                        $.ajax({
                            type: "get",
                            url:next_url,
                            cache: false,
                            dataType: 'json',
                            data : {"order_id" : "{{$order->id}}" },
                            success: function (response) {
                                $("#allocated_order").append(response.html)
                                
                            },
                        });
                        
                    }
                </script>
                @endpush
                