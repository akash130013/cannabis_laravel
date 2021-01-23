@extends('Admin::includes.layout')

@section('content')
    <style>
        #cropper_modal .modal-lg {
            max-width: 500px;
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
        }

        img {
            max-width: 100%;
        }

        .webcam_cropped_image_preview {
            overflow: hidden;
        }

        .cropped_image_preview {
            overflow: hidden;
        }

        .modal-backdrop {
            opacity: 0.1 !important;
        }

        .close {
            width: 32px;
            height: 32px;
            position: absolute;
            top: -10px;
            right: -10px;
            background: #ff8338;
            border-radius: 50%;
            padding: 3px 4px;
            opacity: 1;
            cursor: pointer;
            outline: none;
            border: 2px solid #fff;
        }

        /* .cropper-view-box,
              .cropper-face {
              border-radius: 50%;
              } */
    </style>
    <div class="wrapper">
        <!-- Side menu start here -->

    @include('Admin::includes.sidebar')
    <!-- Side menu ends here -->
        <div class="right-panel">
            @include('Admin::includes.header')

            <div class="inner-right-panel">
                <div class="breadcrumb-section">
                    <ul class="breadcrumb">
                        <li><a href="{{route('admin.promocode.index')}}">Promocode</a></li>
                        <li class="active">Add Promocode</li>
                    </ul>
                </div>
                <section>

                    <form action="{{route('admin.promocode.store',encrypt($data != null?$data->id:''))}}"
                          id="admin_promocode" method="post">
                    @csrf
                    <!-- Inner Right Panel Start -->
                        <input type="hidden" name="promocode_id" value="{{old('id',$data != null?$data->id:'')}}">

                        <div class="inner-right-panel">
                            <div class="white_wrapper formgroup-fields">

                            <div class="flex-row" style="flex-flow:wrap;">
                              <div class="flex-col-sm-6">
                                     <div class="formfilled-wrapper mb15">
                                                <label>Offer Name</label>
                                                <div class="textfilled-wrapper">
                                                    <input type="text" maxlength="50" name="promo_name"
                                                           value="{{old('promo_name',$data != null?$data->promo_name:'')}}"/>
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('promo_name') }}</span>
                                                @endif
                                            </div>
                              </div>
                              <div class="flex-col-sm-6">
                                             <div class="formfilled-wrapper mb15" id="checkPrmotionalType">
                                                <label>Maximum Discount</label>
                                                <div class="textfilled-wrapper">
                                                    <input type="number" maxlength="5" id="maxCap" name="max_cap"
                                                           value="{{old('max_cap',$data != null?$data->max_cap:'')}}"/>
                                                    <img src="{{ asset('asset-admin/images/dollar.svg')}}" alt="$"
                                                         class="hint-icons">
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('max_cap') }}</span>
                                                @endif
                                            </div>
                              </div>

                            <div class="flex-col-sm-6">
                            @if($data == null)
                                                <div class="formfilled-wrapper mb15">
                                                    <label>Coupon Code</label>
                                                    <div class="textfilled-wrapper">
                                                        <input type="text" name="coupon_code" maxlength="25"
                                                               value="{{old('coupon_code',$data != null?$data->coupon_code:'')}}"/>
                                                    </div>
                                                    <span></span>
                                                    @if(Session::has('errors'))
                                                        <span class="error">{{ Session::get('errors')->first('coupon_code') }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <input type="hidden" name="coupon_code" maxlength="25"
                                                       value="{{old('coupon_code',$data != null?$data->coupon_code:'')}}"/>

                                            @endif
                                            <div class="select-dropdown mb15">
                                                <label>Promotional Type</label>
                                                <div class="select_picker_wrapper">
                                                    <select name="promotional_type" id="promotionalType"
                                                            class="selectpicker">
                                                        <option value="percentage" @if(old('promotional_type',$data != null?$data->promotional_type:'') == 'percentage') {{'selected'}} @endif>
                                                            Percentage
                                                        </option>
                                                        <option value="fixed" @if(old('promotional_type',$data != null?$data->promotional_type:'')=='fixed') {{'selected'}} @endif>
                                                            Flat
                                                        </option>
                                                    </select>
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('promotional_type') }}</span>
                                                @endif
                                            </div>

                            </div>   <div class="flex-col-sm-6"></div>

                            <div class="flex-col-sm-6">
                                  <div class="formfilled-wrapper mb15">
                                                <label>Start Date</label>
                                                <div class="input-group date textfilled-wrapper datetimepickerclass"
                                                     id="datetimepicker1">
                                                    <input type="text" name="start_time"
                                                           value="{{old('start_time',$data != null?$data->start_time:'')}}"
                                                           id="datetimepicker1" placeholder="Start Date"
                                                           class="date-input start_time">
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('start_time') }}</span>
                                                @endif
                                            </div>
                            </div>  
                            
                            <div class="flex-col-sm-6">
                                    <div class="formfilled-wrapper mb15">
                                                <label>End Date</label>
                                                <div class="input-group textfilled-wrapper date datetimepickerclass"
                                                     id="datetimepicker2">
                                                    <input type="text" name="end_time"
                                                           value="{{old('end_time',$data != null?$data->end_time:'')}}"
                                                           id="datetimepicker2" placeholder="End Date"
                                                           class="date-input">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('end_time') }}</span>
                                                @endif
                                     </div>
                            </div>


                            <div class="flex-col-sm-6">
                                   <div class="select-dropdown mb15">
                                                <label>Offer Status</label>
                                                <div class="textfilled-wrapper">
                                                    <div class="select_picker_wrapper">
                                                        <select name="offer_status" class="selectpicker">
                                                            <option value="active" @if(old('offer_status', $data != null?$data->offer_status:'')=='active') {{'selected'}} @endif>
                                                                Active
                                                            </option>
                                                            <option value="inactive" @if(old('offer_status', $data != null?$data->offer_status:'')=='inactive') {{'selected'}} @endif>
                                                                Inactive
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('offer_status') }}</span>
                                                @endif
                                            </div>
                            </div>  
                             <div class="flex-col-sm-6">
                                   <div class="formfilled-wrapper mb15">
                                                <label>Min Cart Amount</label>
                                                <div class="textfilled-wrapper">
                                                    <input type="number" id="min_amount" maxlength="10" name="min_amount"
                                                           value="{{old('min_amount',$data != null?$data->min_amount:'')}}"/>
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('min_amount') }}</span>
                                                @endif
                                            </div>
                             </div>


                            <div class="flex-col-sm-6">
                                   <div class="formfilled-wrapper mb15">
                                                <label>Number of Coupons</label>
                                                <div class="textfilled-wrapper">
                                                    <input type="number" maxlength="10" name="total_coupon" id="total_coupon"
                                                           value="{{old('total_coupon',$data != null?$data->total_coupon:'')}}"/>
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('total_coupon') }}</span>
                                                @endif
                                            </div>
                            </div>  
                               <div class="flex-col-sm-6">
                               <div class="formfilled-wrapper mb15">
                                            <label>Redemtion Limit (Per User)</label>
                                            <div class="textfilled-wrapper">
                                                <input type="number" maxlength="10" name="max_redemption_per_user"
                                                       value="{{old('max_redemption_per_user',$data != null?$data->max_redemption_per_user:'')}}"/>
                                            </div>
                                            <span></span>
                                            @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('max_redemption_per_user') }}</span>
                                            @endif
                                        </div>
                               </div>

                            <div class="flex-col-sm-6">
                                 <div class="formfilled-wrapper mb15">
                                                <label id="amount_placeholder"></label>
                                                <div class="textfilled-wrapper">
                                                    <input type="number" id="amount" maxlength="10" name="amount"
                                                           value="{{old('amount',$data != null?$data->amount:'')}}"/>
                                                    <img src="{{ asset('asset-admin/images/dollar.svg')}}" alt="$"
                                                         class="hint-icons">
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('amount') }}</span>
                                                @endif
                                            </div>
                                         
                            </div>   
                            <div class="flex-col-sm-6">
                                 @if(isset($data) && !empty($data))                                        
                                        <div class="formfilled-wrapper mb15">
                                            <label>Number of Coupon Used</label>
                                            <div class="textfilled-wrapper">
                                                <input type="number" maxlength="10" name="used_coupon" id="used_coupon"
                                            value="{{$data->total_coupon-$data->coupon_remained}}" readonly>
                                            </div>
                                            <span></span>
                                            @if(Session::has('errors'))
                                                <span class="error">{{ Session::get('errors')->first('used_coupon') }}</span>
                                            @endif
                                        </div>
                                        @else
                                         <input type="hidden" name="used_coupon" id="used_coupon" value="0">
                                         @endif
                            </div>


                            <div class="flex-col-sm-12">
                                   <div class="formfilled-wrapper mb15">
                                                <label>Description</label>
                                                <div class="textfilled-wrapper">
                                                    <textarea maxlength="500" class="form-control" maxlength="250"
                                                              name="description"> {{old('description',$data != null?$data->description:'')}}</textarea>
                                                </div>
                                                <span></span>
                                                @if(Session::has('errors'))
                                                    <span class="error">{{ Session::get('errors')->first('description') }}</span>
                                                @endif
                                            </div>
                            </div>  


                            </div>

                               

                                <!-- Add Cancel Buttons -->
                                <div class="mt20 text-center">
                                    <a href="{{route('admin.promocode.index')}}"
                                       class="green-fill-btn mr10  green-border-btn">Cancel</a>
                                    <button id="signup_button" class="green-fill-btn"
                                            type="submit">{{$data != null?'Update':'Add'}} Coupon
                                    </button>
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
@section('pagescript')
    <script>
        var isValidPercentage = function(value, element) {
            if(element === "fixed") {
                return true;
            }
            if(element === "percentage") {
                return  value < 100;
            }
        }
        $.validator.addMethod("validatePercentage", function (value, element) {
            return isValidPercentage(value, $('#promotionalType').val());
        }, "Percentage can't be greater than 100");

        $.validator.addMethod("checkUsedCoupon", function (value, element) {
            return Number($("#used_coupon").val())<=Number($("#total_coupon").val());
        }, "Total coupon can not less than Used coupon or Invalid total coupon");

        $.validator.addMethod("validateStartDate",function(value,element){
            return value > $('.start_time').val();
        }, "End date should be greater then start date");

        var message = "Minimum cart amount should not be less than Max. discount";
        
        $.validator.addMethod("validateMinAmount",function(value,element){
            if($('#promotionalType').val() == 'fixed')
            {
               

                return Number($('#min_amount').val()) >= Number($('#amount').val());
            }
            if($('#promotionalType').val() == 'percentage')
            {
                return Number($('#min_amount').val()) >= Number($('#maxCap').val());
            }
            return true;
           
        },"Minimum cart amount should not be less than max. discount / amount");

        $("#admin_promocode").validate({

            rules: {
                promo_name: {
                    required: true,
                    maxlength: 50,
                    minlength: 3,
                },
                coupon_code: {
                    required: true,
                    maxlength: 150
                },
                promotional_type: {
                    required: true,
                },
                start_time: {
                    required: true,
                },
                offer_status: {
                    required: true,
                },
                max_cap:{
                    required:function () {
                        return  $('#promotionalType').val() === "percentage";
                    }
                },
                amount: {
                    required: true,
                    maxlength: 5,
                    digits: true,
                    validatePercentage: true
                },
                min_amount: {
                    required: true,
                    maxlength: 5,
                    digits: true,   
                    validateMinAmount:true
                },
                max_redemption_per_user: {
                    required: true,
                    maxlength: 5,
                    digits: true
                },
                end_time: {
                    required: true,
                    validateStartDate : true
                },
                total_coupon: {
                    required:true,
                    checkUsedCoupon:true,
                    maxlength: 5,
                    digits: true
                },
            },

            highlight: function (element) {
                $(element).parent('div').addClass('error-message');
            },
            unhighlight: function (element) {
                $(element).parent().parent().removeClass('error-message');

            },
            errorPlacement: function (error, element) {
                error.appendTo($(element).parents('.textfilled-wrapper').next());
            },
            messages: {
                promo_name: {
                    required: "Please enter  offer name",
                },
                coupon_code: {
                    required: "Please enter coupon code ",
                },
                promotional_type: {
                    required: "Please enter promotional",
                },
                start_time: {
                    required: "Please enter start date",
                },
                offer_status: {
                    required: "Please enter offer status",
                },
                amount: {
                    required: "Please enter amount/percentage",
                    digits:"Please enter number more than 0",
                },
                max_cap:{
                    required:"Please enter maximum discount"
                },
                min_amount: {
                    required: "Please enter minimum amount",
                    digits:"Please enter number more than 0"
                },
                max_redemption_per_user: {
                    required: "Please enter max. redemption per user",
                    digits:"Please enter number more than 0",
                },
                end_time: {
                    required: "Please enter end date",
                },
                total_coupon: {
                    required: "Please enter total coupon",
                    digits:"Please enter number more than 0",
                },
            },
            submitHandler: function (form, event) {
                $("#signup_button").attr('disabled',true);
                $("#signup_button").html(`<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>`);
                form.submit();
            }
        });

    </script>
@endsection
