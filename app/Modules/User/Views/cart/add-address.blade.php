@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')


<!--header close-->
@section('content')

@yield('nav-bar')


<section class="inner_centerpanel">
            <div class="custom_container">
               <div class="flex-row">
                  <div class="flex-col-sm-12">
                     <div class="cart_step">
                        <ul>
                           <li class="active"><a href="{{route('user.show.cart.list')}}"><span class="digit">1</span> <span> Cart</span> </a></li>
                           <li  class="active"><span class="digit">2</span> <span> Address</span> </li>
                           <li><span class="digit">3</span> <span> Order Summary</span> </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="flex-row align-items-center">
                  <div class="flex-col-sm-6 flex-col-xs-6">
                     <h2 class="title-heading m-t-b-30">Address</h2>
                  </div>
                  <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                  </div>
               </div>
               <div class="flex-row b-top">
                  <div class="cart_left_col">

                  <form action="{{route('add.user.cart.delivery.address')}}" method="get" id="add_delivery_address" autocomplete="off">
                     <input type="hidden" name="address_type_val" value="Home">

                     <div class="add_delivery-address">
                           <div class="add_delivery-address-in">
                  

                           <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="username" placeholder="Full name">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-group">
                           <div class="text-field-wrapper">
                              <input type="tel" name="phone" id="phone" placeholder="Contact Number" data-smk-icon="glyphicon-asterisk" required="required" class="padding-left">
                           </div>
                           {{-- <span id="valid-msg" class="hide error"></span>
                           <span id="error-msg" class="hide error"></span> --}}
                           {{-- <span id="valid-msg" class="hide error"></span>
                           <span id="error-msg" class="show error-message error"></span> --}}

                           <span id="valid-msg" class="hide"></span>
                           <span id="error-msg" class="hide error-message  "></span>

                           @if(Session::has('errors'))
                           <span class="error-message">{{Session::get('errors')->first('phone')}}</span>
                           @endif

                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">

                        <div class="form-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="address" placeholder="Auto Detect  or Type Location" id="location" value="" required>
                              <span class="detect-icon"><img src="{{asset('asset-user-web/images/detect-icon.png')}}"  id="autolocation"></span>
                           </div>
                           <span id="address-error"></span>
                        </div>

                        <input type="hidden" name="lat" id="lat" value="">
                        <input type="hidden" name="lng" id="lng" value="">
                        <input type="hidden" name="street_number" id="street_number">
                        <input type="hidden" name="country" id="country">
                        <input type="hidden" name="ip" id="ip">
                        <input type="hidden" name="route" id="route">
                        <input type="hidden" name="is_cart_redirect" value="1">

                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="locality" id="locality" placeholder="Locality/Town*">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="administrative_area_level_1" id="administrative_area_level_1" placeholder="State*">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="houseno" id="houseno" placeholder="House Number*">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="postal_code" id="postal_code" maxlength="6" placeholder="Pincode*">
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="flex-row">
                     <div class="flex-col-sm-12">
                        <label class="form_label">Type Of Address</label>
                        <div class="form-field-group">
                           <div class="address_type_list">
                              <ul>  
                                 <li>
                                 <label class="address_type active" data-text="Home">
                                    <img src="{{asset('asset-user-web/images/home.svg')}}"> Home
                                 </label>
                                </li>
                                 <li>
                                 <label class="address_type" data-text="Office">
                              <img src="{{asset('asset-user-web/images/office.svg')}}"> Office
                           </label>
                                  </li>
                                 <li>
                                 <label class="address_type" data-text="Other">
                              <img src="{{asset('asset-user-web/images/location-sm.svg')}}"> Other
                           </label>
                                  </li>
                              </ul>
                           </div>

                        </div>
                     </div>
                  </div>     
                  </div>

                  <div class="button-wrapper text-center">
                      <ul>
                        

                         <li>
                         <button type="submit" class="green-fill-btn btn-effect green-fill btn-sm" id="submit_button"> Save Address </button>
                         </li>

                         <li>
                              <a href="{{route('user.checkout.delivery.address')}}"
                              class="line_effect" data-dismiss="modal"> Cancel 
                              </a>
                                 
                         </li>
                      
                      </ul>        
                  </div>
              
                            
                     </div>
                     <input type="hidden" name="dialcode" id="setDialCodeId">
                  </form>



                  </div>


                    
                  <div class="cart_right_col">
                     <div class="item_detail">

                        {{-- {{dd($total['promo_code_applied'])}} --}}
                  
                        @if(!empty($total['promo_code_applied']))
                        <div class="apply_coupon">
                                 <div class="flex-row align-items-center">
                                    <div class="flex-col-sm-6 flex-col-xs-6">
                                       <span class="coupon_name">{{$total['promo_code_applied']}}</span>
                                       <span class="applied">Offer applied <span class="primary_color">(${{number_format($total['discounts']['promo_discount'], 2)}})</span></span>
                                    </div>

                                    <div class="flex-col-sm-6 flex-col-xs-6 text-right">
                                       <span class="remove" data-toggle="modal" data-target="#myModal-coupon-code-remove" >Remove</span>
                                    </div>

                                 </div>
                           </div>
                        @endif



                        <div class="items m-t-30">
                        <label class="form_label">{{$items}} Items</label>

                            @if(!empty($summary))
                            @foreach($summary as $val)

                            <div class="flex-row">
                            <div class="flex-col-sm-10">
                                <span class="item_name_sm">{{$val['product_name']}} ({{$val['size']}} {{$val['size_unit']}}) x {{$val['quantity']}}</span>
                            </div>
                            <div class="flex-col-sm-2">
                                <label class="form_label text-right">${{number_format($val['item_subtotal'], 2)}}</label>
                            </div>
                            </div>

                            @endforeach
                            @endif



                        </div>
                        <div class="total_items">
                  <div class="flex-row">
                     <div class="flex-col-sm-10">
                        <span class="item_name_sm">Item Total</span>
                     </div>
                     <div class="flex-col-sm-2">
                        <label class="form_label text-right">${{empty($total['cartSubTotal']) ? 0 : number_format($total['cartSubTotal'], 2) }}</label>
                     </div>
                  </div>
                  {{-- <div class="flex-row">
                     <div class="flex-col-sm-10">
                        <label class="form_label">Order Packing Charges</label>
                     </div>
                     <div class="flex-col-sm-2 text-right">
                        <label class="form_label">$3.05</label>
                     </div>
                  </div>
                  <div class="flex-row">
                     <div class="flex-col-sm-10">
                        <label class="form_label">Order Packing Charges</label>
                     </div>
                     <div class="flex-col-sm-2 text-right">
                        <label class="form_label">$3.05</label>
                     </div>
                  </div> --}}
                
                  @if(!empty($total['discounts']))
                  <div class="flex-row">
                     <div class="flex-col-sm-10">
                        <label class="form_label primary_color">Discount Applied</label>
                     </div>
                     
                       

                         <div class="flex-col-sm-2 text-right">
                           @if(!empty($total['discounts']['promo_discount']))
                          <label class="form_label primary_color" data-toggle="tooltip" title="Coupan discount">-$ {{number_format($total['discounts']['promo_discount'], 2)}}</label>
                          @endif
                          @if(!empty($total['discounts']['loyaltyPoint']))
                          <label class="form_label primary_color" data-toggle="tooltip" title="Loyalty point discount">-$ {{number_format($total['discounts']['loyaltyPoint'], 2)}}</label>
                          @endif
                       </div>

                     
                  </div>
                  @endif

               </div>

               <div class="total_bill">
                  <div class="flex-row">
                     <div class="flex-col-xs-6">
                        <label class="total_bill_label">BILL TOTAL</label>
                     </div>
                     <div class="flex-col-xs-6 text-right">
                        <label class="total_bill_label">${{empty($total['net_amount']) ? 0 : number_format($total['net_amount'], 2) }}</label>
                     </div>
                  </div>
               </div>


                     </div>
                  </div>



               </div>
            </div>
         </section>

         <input type="hidden" name="search_type" value="1">
         <div class="modal fade" id="myModal-coupon-code-remove" role="dialog">
            <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="modal-close" data-dismiss="modal"><img src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
                     <h4 class="modal-title">Remove Coupon Code</h4>
                  </div>
                  <div class="modal-body">
                     <form action="{{route('user.remove.coupon.code')}}" id="wish_list_submit_form" method="post">
                        @csrf
                        <div class="modal-padding">
                           <h1 class="confirm_heading">Confirmation</h1>
                           <p class="commn_para">Are you sure want to remove applied coupon code. </p>
         
                           <div class="flex-row m-t-30">
                              <div class="flex-col-sm-12 mt-50 mobile-space">
                                 <button type="submit" class="custom-btn green-fill getstarted btn-effect">Yes</button>
         
                                 <button type="button" class="ch-shd back line_effect" data-dismiss="modal">No</button>
         
                              </div>
                           </div>
                        </div>
                        <input type="hidden" name="id" value="{{$orderId ?? ''}}">
         
                        <input type="hidden" name="promo_code" value="{{empty($total['promo_code_applied']) ? '' : $total['promo_code_applied'] }}">
                     </form>
         
                  </div>
               </div>
            </div>
         </div>

         @section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset-store/js/intl-tel-input-master/build/css/intlTelInput.css')}}">
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/intlTelInput.min.js')}}"></script>
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/utils.js')}}"></script>
<script src="{{asset('asset-user/js/mobile.validation.intelinput.js')}}"></script>
<script src="{{ asset('asset-user/js/location/jquery.geocomplete.js')}}"></script>
<script src="{{ asset('asset-user/js/profile.location.autofill.js')}}"></script>

  

<script>

$("body").on('click','.address_type',function(){
   $('.address_type').each(function() {
      $(this).removeClass('active');
   })

   var type=$(this).data('text');
   $("input[name=address_type_val]").val(type);
   $(this).addClass('active');
})



$("#location").geocomplete({
    details: "#add_delivery_address",
    componentRestrictions: { country: "us" }
});

   $("#add_delivery_address").validate(
      {
      errorClass: 'error',
      errorElement: 'span',
      ignore: [],
      rules: {

         phone: {
            required: true,
         },
         username: {
            required: true,
            maxlength: 50,
            minlength: 4
         },
         locality: {
            required: true
         },
         administrative_area_level_1: {
            required: true
         },
         postal_code: {
            required: true,
            digits: true
         },
         houseno : {
            required : true
         }

      },
      // errorPlacement: function(error, element) {
      //    $(element).parent('div').parent("div").addClass('error-message');
      //    error.insertAfter(element);
      // },
      errorPlacement: function (error, element) {
                if (element.attr("name") == "address") {
                           error.insertAfter("#address-error");
                 }else{
                     error.appendTo($(element).parents('.text-field-wrapper')).next();
                 }
            },
      success: function(label, element) {
         label.parent().parent().removeClass('error-message');
         label.remove();
      },
      submitHandler: function(form, event) {
         // event.preventDefault();

         if (iti.isValidNumber()) {
            $("#submit_button").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            var getCode = iti.s.dialCode;
            $("#setDialCodeId").val(getCode);
            // alert(getCode);
            form.submit();
         }
      },
   });

  

  

</script>

@endsection




@endsection