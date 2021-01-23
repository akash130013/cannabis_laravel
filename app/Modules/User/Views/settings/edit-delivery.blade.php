
<div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="modal-close" data-dismiss="modal"><img
                     src="{{asset('asset-user-web/images/close-card.svg')}}"></button>
                  <h4 class="modal-title">Update Address</h4>
               </div>
              
               <form action="{{route('edit.user.delivery.address')}}" method="get" id="edit_delivery_address">
               <input type="hidden" name="address_type_val" value="{{$deliveryAddress->address_type}}">

               <div class="modal-body">
                  <div class="modal-padding">
                
                     <div class="flex-row">
                           <div class="flex-col-sm-12">
                              <div class="form-field-group">
                                 <div class="text-field-wrapper">
                                    <input type="text" name="username" value="{{$deliveryAddress->name}}" placeholder="Full name" onkeypress="return removeSpace(event,$(this).val())">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="flex-row">
                           <div class="flex-col-sm-12">
                                 <div class="form-group">
                                    <div class="text-field-wrapper">
                                          <input type="tel" class="padding-left" maxlength="15" onkeypress="return isNumber(event)" name="phone" id="phone-edit" value="{{$deliveryAddress->mobile}}" placeholder="Contact Number" data-smk-icon="glyphicon-asterisk" required="required">
                                    </div>
                                   
                                      <span id="valid-msg-edit" class="hide-edit"></span>
                                       <span id="error-msg-edit" class="hide-edit error-message"></span>
                                       {{-- <span id="valid-msg" class="hide"></span>
                                       <span id="error-msg" class="hide error-message"></span> --}}
                                 </div>
                           </div>
                        </div>

                        <div class="flex-row">
                           <div class="flex-col-sm-12">
                          
                                <div class="form-group">
                                    <div class="text-field-wrapper">
                                        <input type="text" name="address" value="{{$deliveryAddress->formatted_address}}" placeholder="Auto Detect  or Type Location" id="location-edit" value="" required>
                                        <span class="detect-icon"><img src="{{asset('asset-user-web/images/detect-icon.png')}}"  id="autolocation"></span>
                                    </div>
                                    <span id="address-error"></span>
                                </div>

                                <input type="hidden" name="lat" id="lat-edit" value="{{$deliveryAddress->lat}}">
                                <input type="hidden" name="lng" id="lng-edit" value="{{$deliveryAddress->lng}}">
                                <input type="hidden" name="street_number" id="street_number-edit">
                                <input type="hidden" name="country" id="country-edit" value="{{$deliveryAddress->country}}">
                                <input type="hidden" name="ip" id="ip-edit">
                                <input type="hidden" name="route" id="route-edit">

                           </div>
                        </div>

                        <div class="flex-row">
                           <div class="flex-col-sm-12">
                              <div class="form-field-group">
                                 <div class="text-field-wrapper">
                                    <input type="text" name="city" id="locality-edit" value="{{$deliveryAddress->city}}" placeholder="Locality/Town*">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="flex-row">
                           <div class="flex-col-sm-12">
                              <div class="form-field-group">
                                 <div class="text-field-wrapper">
                                    <input type="text" name="state" value="{{$deliveryAddress->state}}" id="administrative_area_level_1-edit" placeholder="State*">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="flex-row">
                           <div class="flex-col-sm-12">
                              <div class="form-field-group">
                                 <div class="text-field-wrapper">
                                    <input type="text" name="houseno" id="houseno-edit" value="{{$deliveryAddress->address}}" placeholder="House Number*">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="flex-row">
                           <div class="flex-col-sm-12">
                              <div class="form-field-group">
                                 <div class="text-field-wrapper">
                                    <input type="text" name="postal_code" maxlength="6" id="postal_code-edit" value="{{$deliveryAddress->zipcode}}" placeholder="*Pincode">
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
                                       <label class="address_type @if($deliveryAddress->address_type=='Home') active @endif" data-text="Home">
                                          <img src="{{asset('asset-user-web/images/home.svg')}}"> Home
                                       </label>
                                      </li>
                                       <li>
                                       <label class="address_type @if($deliveryAddress->address_type=='Office') active @endif" data-text="Office">
                                    <img src="{{asset('asset-user-web/images/office.svg')}}"> Office
                                 </label>
                                        </li>
                                       <li>
                                       <label class="address_type @if($deliveryAddress->address_type=='Other') active @endif" data-text="Other">
                                    <img src="{{asset('asset-user-web/images/location-sm.svg')}}"> Other
                                 </label>
                                        </li>
                                    </ul>
                                 </div>
      
                              </div>
                           </div>
                        </div>



                     </div>
                 

               </div>

               <div class="button-wrapper text-center">
                  <ul>
                    

                     <li>
                     <button type="submit" class="green-fill-btn btn-effect green-fill btn-sm" id="submit_button_Edit"> Update </button>
                     </li>

                     <li>
                          <a href="javascript:void(0)" class="line_effect" data-dismiss="modal"> Cancel</a>
                         
                         
                     </li>
                  
                  </ul>        
              </div>

               {{-- <div class="addressAccordian-buttons">
                  <button type="submit" class="green-fill-btn btn-effect green-fill btn-sm" id="submit_button_Edit">Update</button>
                  <button type="button" class="line_effect" data-dismiss="modal"> Cancel </button>
               </div>    --}}

               <input type="hidden" name="dialcode" id="setDialCodeId-edit">
               <input type="hidden" name="delivery_id" value="{{$deliveryAddress->id}}">
               
               </form>


            </div>
            
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<link rel="stylesheet" href="{{asset('asset-store/js/intl-tel-input-master/build/css/intlTelInput.css')}}">
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/intlTelInput.min.js')}}"></script>
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/utils.js')}}"></script>
<script src="{{asset('asset-user/js/edit-mobile.validation.intelinput.js')}}"></script>
<script src="{{asset('asset-user/js/edit-auto-fill-location.js')}}"></script>
<script src="{{ asset('asset-user/js/location/jquery.geocomplete.js')}}"></script>

<script>

$("#edit-address").on('shown.bs.modal', function (e) {
  // do something...
$("#location-edit").geocomplete({
    details: "form",
    componentRestrictions: {
    country: "us"
  }
});

});

   $("#edit_delivery_address").validate({
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
         city: {
            required: true
         },
         state: {
            required: true
         },
         houseno:{
           required:true
         },
         postal_code: {
            required: true,
            digits: true,
         }

      },
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
         if (iti.isValidNumber()) {
            $("#submit_button_Edit").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            var getCode = iti.b.dataset.dialCode;
            $("#setDialCodeId-edit").val(getCode);
            form.submit();
         }
      },
   });
</script>