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
                        <a href="{{route('admin.promocode.index')}}">Promocodes</a> 
                    </li>

                    <li>
                        <a href="#" class="active">Details</a> 
                    </li>

                </ul>
            </div>
            <!--breadcrumb Close-->

            <div class="inner-right-panel">

                <!-- promocode details start-->
                <div class="white_wrapper promo-details pd-20">

                    <div class="text-right">
                        <a type="button" href="{{route('admin.promocode.create',['id'=>$data->promocode_id])}}" class="green-fill-btn">Edit</a>
                    </div>


                    <!-- row repeat -->
                    <div class="flex-row row-space">
                        <div class="flex-col-sm-4">
                            <label class="table-label">Offer Name</label>
                            <span class="label-data">{{$data->promo_name}}</span>
                        </div>
                        <div class="flex-col-sm-4">
                            <label class="table-label">Promotion Type</label>
                            <span class="label-data">
                                @if($data->promotional_type == 'fixed')
                                Flat
                                @else
                                Percentage
                                @endif
                            </span>
                        </div>
                        <div class="flex-col-sm-4">
                            <label class="table-label">Max Discount</label>
                            <span class="label-data">{{$data->promotional_type == 'fixed'?'$'.$data->amount:'upto $ '.$data->max_cap}}</span>
                        </div>
                    </div>
                    <!-- row repeat -->

                    <!-- row repeat -->
                    <div class="flex-row row-space">
                        <div class="flex-col-sm-4">
                            <label class="table-label">Coupon Code</label>
                            <span class="label-data">{{$data->coupon_code}}</span>
                        </div>
                        <div class="flex-col-sm-4">
                            <label class="table-label">Start Date</label>
                            <span class="label-data">{{\App\Helpers\CommonHelper::convertFormat($data->start_time)}}</span>
                        </div>
                        <div class="flex-col-sm-4">
                            <label class="table-label">End Date</label>
                            <span class="label-data">{{\App\Helpers\CommonHelper::convertFormat($data->end_time)}}</span>
                        </div>
                    </div>
                    <!-- row repeat -->

                    <!-- row repeat -->
                    <div class="flex-row row-space">
                        <div class="flex-col-sm-4">
                            <label class="table-label">Redemption Limit (Per User)</label>
                            <span class="label-data">{{$data->max_redemption_per_user}} Times</span>
                        </div>
                        <div class="flex-col-sm-4">
                            <label class="table-label">Numbers of Coupons</label>
                            <span class="label-data">{{$data->total_coupon}}</span>
                        </div>
                        <div class="flex-col-sm-4">
                            <label class="table-label">Redemptions Remained</label>
                            <span class="label-data">{{$data->coupon_remained}}</span>
                        </div>
                    </div>
                    <!-- row repeat -->

                    <!-- row repeat -->
                    <div class="flex-row row-space">
                        <div class="flex-col-sm-4">
                            <label class="table-label">Redemptions</label>
                            <span class="label-data">
                            <a href="/admin/user?search={{$data->coupon_code}}">{{$data->redeemed_users_count}}</a>
                            </span>
                        </div>
                        <div class="flex-col-sm-4">
                            <label class="table-label">Offer Status</label>
                            <span class="label-data">
                                @if($data->offer_status == 'active')
                                Active
                                @else
                                Inactive
                                @endif
                            </span>
                        </div>
                       
                    </div>
                    <div class="flex-row row-space">
                            <div class="flex-col-sm-8">
                                    <label class="table-label">Description</label>
                                    <span class="label-data">{{$data->description}}</span>
                                </div>
                    </div>
                    <!-- row repeat -->
                </div>
                <!-- promocode details end-->
            </div>
            <!-- Inner Right Panel End -->
        </div>
    </div>


</div>
@endsection