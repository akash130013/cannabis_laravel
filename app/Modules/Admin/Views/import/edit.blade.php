@extends('Admin::includes.layout')

@section('content')
<div class="wrapper">
        <!-- Side menu start here -->
        
        @include('Admin::includes.sidebar')
        <!-- Side menu ends here -->
        <div class="right-panel">
                @include('Admin::includes.header')

            <div class="inner-right-panel">
                <div class="breadcrumb-section">
					<ul class="breadcrumb">
                        <li><a href="{{route('admin.promocode.index')}}">Add Delivery</a></li>
                        <li class="active">Edit Delivery</li> 
                    </ul>
				</div>
                <section>
                  
                    <form action="{{route('admin.update.delivery.location',encrypt($data != null?$data->id:''))}}" id="admin_promocode" method="post">
                       @csrf
                    <!-- Inner Right Panel Start -->
                    <input type="hidden" name="delivery_location_id" value="{{old('id',$data != null?$data->id:'')}}">

                    <div class="inner-right-panel">
                        <div class="white_wrapper formgroup-fields">
                            <div class="flex-row">
                                <!-- left form filled start-->
                                <div class="flex-col-sm-6">
                                    <div class="formwrap">
                                        <div class="">
                                        </div>
                                        
                                        <div class="formfilled-wrapper mb15">
                                            <label>Country</label>
                                            <div class="textfilled-wrapper">
                                                <input type="text" name="country" maxlength="25" value="{{old('country',$data != null?$data->country:'')}}"/>
                                            </div>
                                            @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('country') }}</span>
                                            @endif
                                        </div>
                                        <div class="formfilled-wrapper mb15">
                                            <label>State</label>
                                            <div class="textfilled-wrapper">
                                                <input type="text" name="state" maxlength="25" value="{{old('state',$data != null?$data->state:'')}}"/>
                                            </div>
                                            @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('state') }}</span>
                                            @endif
                                        </div>

                                        <div class="formfilled-wrapper mb15">
                                            <label>Address</label>
                                            <div class="textfilled-wrapper">
                                                <textarea maxlength="150" name="address">{{old('address',$data != null?$data->address:'')}}</textarea>
                                            </div>
                                            @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('promo_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- left form filled end-->
                                <!-- right form filled start-->
                                <div class="flex-col-sm-6">
                                    <div class="formwrap m0">
                                        <div class="formfilled-wrapper mb15">
                                            <label>City</label>
                                            <div class="textfilled-wrapper">
                                                <input type="text"  name="city" value="{{old('city',$data != null?$data->city:'')}}"  />
                                            </div>
                                            @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('city') }}</span>
                                            @endif
                                        </div>
                                        <div class="formfilled-wrapper mb15">
                                            <label>Zipcode</label>
                                            <div class="textfilled-wrapper">
                                                <input type="number" disabled maxlength="10" name="zipcode" value="{{old('zipcode',$data != null?$data->zipcode:'')}}"  />
                                            </div>
                                            @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('zipcode') }}</span>
                                            @endif
                                        </div>

                                        <div class="formfilled-wrapper mb15">
                                            <label>TimeZone</label>
                                            <div class="textfilled-wrapper">
                                                <input type="text" name="timezone" value="{{old('timezone',$data != null?$data->timezone:'')}}"/>
                                            </div>
                                            @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('timezone') }}</span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <!-- right form filled end-->
                            </div>

                            <!-- Add Cancel Buttons -->
                            <div class="mt20 text-center">
                                <a href="{{route('admin.show.import')}}"><button class="mr10 green-fill-btn green-border-btn" type="button">Cancel</button></a>
                                <button class="green-fill-btn" type="submit">{{$data != null?'Update':'Add'}} Location</button>
                            </div>
                            <!-- Add Cancel Buttons -->

                        </div>
                    </div>
                    </form>
                </section>
            </div>
        </div>
</div>
@endsection