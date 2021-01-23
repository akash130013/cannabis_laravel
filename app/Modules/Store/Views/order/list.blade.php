@extends("Store::layouts.master")
@section('content')

    <div class="custom_container">
            @include('Store::layouts.pending-alert')
        <div class="white_wrapper padd-t-20">
            <div class="flex-row align-items-center">
                <div class="flex-col-sm-6 mob-order-menu">
                    <!-- menu-->
                    <div class="head-nav tab_wrapper">
                        <ul>
                            <li><a class="{{request()->query('type') == 'pending' ? 'active':''}}"
                                   href="{{route('store.order.list',['type'=>'pending'])}}">Pending</a></li>
                            <li><a class="{{request()->query('type') == 'on-going' ? 'active':''}}"
                                   href="{{route('store.order.list',['type'=>'on-going'])}}">On-going</a></li>
                            <li><a class="{{request()->query('type') == 'completed' ? 'active':''}}"
                                   href="{{route('store.order.list',['type'=>'completed'])}}">Completed</a></li>
                            <li><a class="{{request()->query('type') == 'cancelled' ? 'active':''}}"
                                   href="{{route('store.order.list',['type'=>'cancelled'])}}">Cancelled</a></li>
                        </ul>
                    </div>
                    <!-- menu close-->
                </div>

                <div class="flex-col-sm-6">
                    
                    <form method="GET" action="{{route('store.order.list')}}" id="list-form">


                        <div class="text-field-wrapper product-srch-col-header ui category search">
                            <div class="text-field-wrapper pro-srchbox ui icon input">
                                <input class="prompt" type="text" placeholder="Search by order Id"
                                       id="searchElementProduct" name="keyword" value="{{request()->query('keyword')}}">
                                <i class="search icon"></i>

                                @if(Request::has('keyword') && !empty(Request::get('keyword')) )
                                    <a href="{{route('store.order.list').'?type='.request()->query('type')}}"><img
                                                src="{{asset('asset-store/images/cross.svg')}}" class="closeProductMenu"
                                                alt="cross"></a>
                                @endif

                                <input type="hidden" id="orderType" name="type" value="{{request()->query('type')}}">
                            </div>
                            <div class="results"></div>


                        </div>


                        <!--search-->
                        <div class="product-srch-col-header">
                        {{-- <div class="text-field-wrapper pro-srchbox">
                            <input type="text" name="keyword" value="{{request()->query('keyword')}}" placeholder="Search by order Id, customer name">
                            <input type="hidden"    name="type"  value="{{request()->query('type')}}">
                            <span class="detect-icon"><img src="{{asset('asset-store/images/search-line.svg')}}" alt="detect"></span>
                        </div> --}}

                        <!-- <div class="ui search">
                <div class="text-field-wrapper product-srch-col-header ui category search">



                </div>

              </div>
            </div> -->
                            <!--search close-->
                    

                </div>
            </div>
        </div>
    </div>
  
        <form method="get" action="{{('store.order.list')}}" id="filtered-order-list">
             <!-- Order Filter -->
                        <div class="custom_container p-sm">
                            <div class="flex-row align-items-center row-wrap">
                                <div class="flex-col-md-3 flex-col-sm-3">
                                    <label class="form-label">From</label>
                                    <div class="form_field_wrapper">
                                    <div class='input-group date' >
                                        <input type='text' name="startDate" placeholder="Start date" value="{{request()->query('startDate')}}" id='datetimepicker1'  class="datebox startDate" autocomplete="off"/>
                                        <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                    </div>
                                </div>
                                <div class="flex-col-md-3 flex-col-sm-3">
                                    <label class="form-label">To</label>
                                    <div class="form_field_wrapper">
                                    <div class='input-group date' >
                                            <input type='text' name="endDate" placeholder="End date" value="{{request()->query('endDate')}}" class="datebox endDate" autocomplete="off" id='datetimepicker2' />
                                            <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="flex-col-md-4 flex-col-sm-4">
                                    <div class="form_field_wrapper">
                                    <div class="filter-wrapper m-t-30 text-center">
                                      <button class="primary_btn green-fill btn_sm btn-effect" type="submit">Apply</button>
                                      <button class="primary_btn green-fill btn_sm m-l-20 btn-effect" id="resetButton">Reset</button>
                                    </div>
                                    <!--
                                        @if(Request::has('status'))
                                            <a href="{{route('store.earning.list')}}" class="btn btn-info">CLear</a>
                                        @endif -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
       <!-- Order Filter Close -->
               
              
        </form>
    </div>
  
    <div class="full_custom_container_order">
        <div class="wrap-row-full">
            <div class="col-left-lg mob-row-reverse`">
                <div class="white_wrapper">
                <div class="table-responsive">
                    <table id="example" class="list-table table table-bordered" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Order ID</th>
                            <th>Order Status</th>
                            <th>Order Date & Time</th>
                            <th>Customer Name</th>
                            <th>Delivery Location</th>
                            @if(request()->get('type') !== "pending")
                                <th>Driver Name</th>
                            @endif
                            <th>Total Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($data['list'] as $key => $item)
                            @php
                                $address =  json_decode($item->delivery_address,true);
                            @endphp

                            <tr class="order-row" data-url="{{route('store.order.show',$item->id)}}">
                                <td>{{$srNo++}}</td>
                                <td><span class="driver-status td-text-wrap numOf">{{$item->order_uid}}</span></td>

                                <td><span class="td-text-wrap">{{ucWords(str_replace('_',' ' ,$item->order_status))}}</span></td>
                                <td><span class="td-text-wrap">{{$item->format_created_at}}</span></td>

                                <td><span class="td-text-wrap">{{$item->customer->name}}</span></td>

                                <td><span class="td-text-wrap">{{$address['formatted_address']}}</span></td>
                                @if(request()->get('type') !== "pending") 
                                    <td><span class="td-text-wrap">{{@$item->distributors->first()->name??'--'}}</span></td>
                                @endif
                                    <td><span class="">$ {{number_format($item->net_amount,2)}}</span></td>
                            </tr>
                            @empty
                            <td colspan="8">No Order Found</td>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                </div>
                    <div class="flex-row">
                        <div class="flex-col-sm-12 text-center">
                            {{$data['list']->appends(request()->query())->links()}}
                        </div>
                    </div>
            </div>
            @if($data['list']->items())
                @php
                    $order = $data['list'][0];
                @endphp

                <div class="order-detail-col" id="side-detail">
                    @include('Store::order.side-detail',$order)
                </div>
            @endif
        </div>
    </div>
    <input type="hidden" name="searchUrl" value="{{route('store.order.search')}}">
@endsection
@push('script')
    <script src="{{asset('asset-store/js/request.js')}}"></script>
    <script src="{{asset('asset-store/js/datepicker.bootstrap.js')}}"></script>
    <script src="{{asset('asset-store/js/order-list.js')}}"></script>
    <script src="{{asset('asset-store/js/Easy-jQuery-Client-side-List-Filtering-Plugin-list-search/js/list-search-min.js')}}"></script>
    <script src="{{asset('asset-store/js/Semantic-UI-master/dist/semantic.min.js')}}"></script>
    <script src="{{asset('asset-store/js/search-list.js')}}"></script>
     <script src="{{asset('asset-store/js/date-validation.js')}}"></script>
  
@endpush

    