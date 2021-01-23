@extends('Admin::includes.layout')
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
                        <a href="{{route('admin.user.index')}}">User</a> 
                    </li>

                    <li>
                        <a href="#">Details</a> 
                    </li>

                </ul>
            </div>
            <!--breadcrumb Close-->

            <div class="inner-right-panel">
                <!-- store details start-->
                <div class="white_wrapper user-details">


                    <!--block heading -->
                    <div class="blok_heading">
                        <h2>{{$data->name}}</h2> 
                    </div>
                    <!--block heading -->

                    <!-- main row start -->
                    <div class="flex-row">

                        <div class="flex-col-sm-3">
                            @if($data->avtaar)
                                <!-- Store Image -->
                                <figure class="store_img mt20">
                                    <img src="{{$data->avtaar?$data->avtaar:''}}" />
                                </figure>
                                <figcaption>Profile Image</figcaption>
                                <!-- Store Image -->
                            @endif
                        </div>
                        <div class="flex-col-sm-9">
                            <!-- row start -->
                            <div class="flex-row row-space">
                                {{-- <div class="flex-col-sm-4">
                                    <label class="table-label">User Id</label>
                                    <span class="label-data">{{$data->id}}</span>
                                </div> --}}
                                <div class="flex-col-sm-4">
                                    <label class="table-label">User Name</label>
                                    <span class="label-data">{{$data->name}}</span>
                                </div>
                                <div class="flex-col-sm-4">
                                    <label class="table-label">Email Address</label>
                                    <span class="label-data">{{$data->email}}</span>
                                </div>
                                <div class="flex-col-sm-4">
                                    <label class="table-label">Date of Birth</label>
                                    <span class="label-data">{{\App\Helpers\CommonHelper::dateformat($data->dob)}}</span>
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
                                    <label class="table-label">Numbers of Orders</label>
                                    <span class="label-data numOf">
                                    <a href="{{route('admin.order.index',['userId'=>$data->user_id,'orderType'=>'pending'])}}">{{$data->orders_count}}</a>
                                    </span>
                                </div>
                                <div class="flex-col-sm-4">
                                    <label class="table-label">Contact Number</label>
                                    <span class="label-data">{{$data->phone_number}}</span>
                                </div>
                            </div>
                            <!-- row end -->

                            <!-- row start -->
                            <div class="flex-row row-space">

                                @if (count($data->userProof) >0)
                                <div class="flex-col-sm-4">
                                    <label class="table-label">Verification ID</label>
                                    

                                    
                                    @foreach($data->userProof as $item)
                                        <span class="label-data txt-caps">
                                            <a target="_blank" download href="{{$item->file_url}}">{{$item->file_name}}</a>

                                        </span> 
                                    @endforeach
                                    
                                </div>
                                @else
                                
                                @endif
                                <div class="flex-col-sm-4">
                                    <label class="table-label">
                                    <!-- <figure class="verified-img">
                                        <img src="{{asset('asset-admin/images/image-line.svg')}}" alt="image" />
                                </figure>  -->
                                Status</label>
                                    <span class="label-data">{{$data->status =='active'?'Active':'Blocked'}}</span>
                                </div>
                             
                            </div>
                            <!-- row end -->

                        </div>
                    </div>
                    <!-- main row end -->
                    <!-- Buttons -->
                    <div class="btn-space text-center">
                        <a title="{{$data->status == 'active'?'Deactivate':'Activate'}}" data-call="blade"  data-type="user"  data-id="{{$data->user_id}}" data-text="{{$data->status == 'active'?trans('Admin::messages.block_user_popup'):trans('Admin::messages.unblock_user_popup')}}"  id="{{$data->status =='active'?'warning-alert':'info-alert'}}" href="javascript:void(0); ">
                                <button class="mr10 green-fill-btn green-border-btn">{{$data->status == 'active'?'Deactivate':'Activate'}}</button>
                        </a>
                        <a title="View Orders" href="{{route('admin.order.index',['userId'=>$data->user_id,'orderType'=>'pending'])}}" class="green-fill-btn" type="button">View Orders</a>
                            {{-- <a class="primary-btn" href="/admin/order?orderType=pending&userId={{$data->user_id}}" type="button">View Orders</a> --}}
                    </div>
                    <!-- Buttons -->
                </div>
                <!-- store details end-->

            </div> 
        </div>
@endsection