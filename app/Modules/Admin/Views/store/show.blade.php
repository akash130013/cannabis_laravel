@extends('Admin::includes.layout')
@section('css')
<link rel="stylesheet" type="text/css" media="screen" href="{{asset('asset-user-web/css/owl.carousel.min.css')}}">

@endsection
@section('content')
 <!-- Side menu start here -->
 @include('Admin::includes.sidebar')
 <!-- Side menu ends here -->
 <div class="right-panel">
         @include('Admin::includes.header')
    <div class="inner-right-panel">
        <!--breadcrumb-->
        <div class="bred-crumbs">
            <ul>
                <li>
                    <a href="{{route('admin.store.index')}}">Store</a>
                </li>

                <li>
                <a href="#">Details</a>  
                </li>

            </ul>
        </div>
        
        <!--breadcrumb Close-->
        <div class="inner-right-panel">
            <!-- store details start-->
            <div class="white_wrapper store-details">


                <!--block heading -->
                <div class="blok_heading">
                    <h2>{{$data->store_name}} </h2>
                </div>
                <!--block heading -->

                <!-- main row start -->
                <div class="flex-row">
                    <div class="flex-col-sm-3">
                        <!-- Store Image -->
                        <div id="store-detail-owl" class="owl-carousel">
                          <!-- <figure class="store_img mt20 banner_img"> -->
                             @foreach ($data->storeImages as $item)
                                 <div class="item">
                                    <figure class="store_img mt20 banner_img">
                                        <img src="{{$item->file_url}}" alt="store image" />
                                        <figcaption>Store Image</figcaption>
                                     </figure>
                                  </div>
                           
                             @endforeach
                             </div>
                              
                          <!-- </figure> -->
                          <div>
                            <!-- <figure class="store_img mt20 banner_img"> -->
                              
                                   <div class="item">
                                      <figure class="store_img mt20 banner_img">
                                          <img src="{{$data->proof_url}}" alt="store image" />
                                          <figcaption>Store Proof</figcaption>
                                       </figure>
                                    </div>
                             
                            
                               </div>
               
                        </div>
                        
                        <!-- Store Image -->
                 
                    <div class="flex-col-sm-9">
                        <!-- row start -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">Status</label>
                                <span class="label-data">
                                @if($data->admin_action == config('constants.STATUS.APPROVE'))
                                    {{$data->status == 'active'?'Active':'Inactive'}}
                                @else
                                    @if($data->admin_action == config('constants.STATUS.PENDING'))
                                    Pending
                                    @elseif($data->admin_action == config('constants.STATUS.REJECT'))
                                    Reject
                                    @endif
                                @endif
                                </span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Store Name</label>
                                <span class="label-data">{{$data->store_name}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Email Address</label>
                                <span class="label-data">{{$data->email}}</span>
                            </div>
                        </div>
                        <!-- row end -->

                        <!-- row start -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">Registered On</label>
                                <span class="label-data">{{\App\Helpers\CommonHelper::convertFormat($data->created_at,'M d, Y')}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Numbers of Orders Completed</label>
                                <span class="label-data numOf">
                                <a href="{{route('admin.order.index',['storeId'=>$data->store_encrypt_id,'orderType'=>'complete'])}}">{{$data->completed_orders_count??0}} </a>
                                </span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Commission Percent ($)</label>
                                <span class="label-data">{{$data->commission?$data->commission->commison_percentage.'%':'N/A'}}</span>
                            </div>
                        </div>
                        <!-- row end -->

                        <!-- row start -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">Phone Number</label>
                                <span class="label-data">{{$data->phone}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Numbers of Drivers</label>
                            <span class="label-data numOf">
                            <a href="{{route('admin.distributor.index',['storeId'=>$data->store_encrypt_id])}}">{{$data->distributors_count}}</a>
                            </span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">No. of Product Selling</label>
                                <span class="label-data">
                                <a href="{{route('admin.product.listing',['store_id'=>$data->store_encrypt_id])}}">
                                    {{$data->store_products_count}}
                                </a>
                                </span>
                            </div>
                        </div>
                        <!-- row end -->

                        <!-- row start -->
                        <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">Store Address</label>
                                <span class="label-data">{{$data->address}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Total Earnings ($)</label>
                                <span class="label-data">{{$data->total_earning}}</span>
                            </div>
                            <div class="flex-col-sm-4">
                                <label class="table-label">Total Due ($)</label>
                                <span class="label-data">{{$data->amount_pending}}</span>
                            </div>
                        </div>
                        <!-- row end -->

                            
                         <!-- row start -->
                         <div class="flex-row row-space">
                            <div class="flex-col-sm-4">
                                <label class="table-label">License Number</label>
                                <span class="label-data">{{$data->licence_number ?? 'N/A'}}</span>
                            </div>
                            
                        </div>
                        <!-- row end -->

                    </div>

                </div>
                <!-- main row end -->
                <!-- Buttons -->
                <div class="btn-space text-center">
                        @if($data->admin_action == config('constants.STATUS.APPROVE'))
                            <a title="{{$data->status == 'active'?'Inactive':'Active'}}" data-call="blade"  data-type="store"  data-id="{{$data->store_encrypt_id}}" data-text="{{$data->status == 'active'?trans('Admin::messages.block_store_popup'):trans('Admin::messages.unblock_store_popup')}}"  id="{{$data->status =='active'?'warning-alert':'info-alert'}}" href="javascript:void(0); ">
                                    <button class="green-fill-btn mr10  green-border-btn">{{$data->status == 'active'?'Deactivate':'Activate'}}</button>
                            </a>
                            <a href="{{route('admin.store.open.settlement',['id'=>$data->store_encrypt_id,'store_name'=>$data->store_name])}}" class="green-fill-btn">Settlement</a>
                            @else
                                <a title="Approve" data-call="blade"  data-type="store"  data-id="{{$data->store_encrypt_id}}" data-text="{{trans('Admin::messages.accept_store_popup')}}"  id="approve-alert" href="javascript:void(0); ">
                                        <button class="green-fill-btn mr10  green-border-btn">Approve</button>
                                </a>
                            @if($data->admin_action == config('constants.STATUS.PENDING'))
                                <a title="Reject" data-call="blade"  data-type="store"  data-id="{{$data->store_encrypt_id}}" data-text="{{trans('Admin::messages.reject_store_popup')}}"  id="reject-alert" href="javascript:void(0); ">
                                        <button class="green-fill-btn mr10  green-border-btn">Reject</button>
                                </a>
                            @endif
                        @endif
                </div>

                <!-- Buttons -->
            </div>
            <!-- store details end-->
            
        </div>
    </div>


                
@endsection
@section('pagescript')
<script src="{{asset('asset-user-web/js/app.js')}}"></script>
@endsection