@extends('Store::register.layout')
@section('content')
<!-- Tabs menu -->
<div class="tabularProMenu">
   <div class="form-container">
      <ol>
         <li class="active"><span>Store Details</span></li>
         {{-- 
         <li class="nextTab">Operating Hours</li>
         --}}
         <li class="nextTab"><span>Operating Hours</span></li>
         <li><span>Store Images</span></li>
         <li><span>Store Delivery Locations</span></li>
      </ol>
   </div>
</div>
<!-- Tabs menu End -->
<!-- Internal Container -->
<div class="internal-container">
   <!-- Form Container -->
   <form action="{{route('submit.store.details')}}" id="store_details_submit" method="post" autocomplete="off">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <div class="form-container cstm-map stepForm step1 active">
         <h4>Store Details</h4>
         <div class="operat-hours">
            <div class="frm-lt-sd">
               <div class="ins-profilefrm-lt-sd">
                  <div class="frm-sec-ins">
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <input type="text" @if($userdata && $userdata->storeDetail) value="{{$userdata->storeDetail->store_name??''}}" @endif name="store_name"  placeholder="Enter Store Name">
                              </div>
                              @if(Session::has('errors'))
                              <span class="error">{{Session::get('errors')->first('store_name')}}</span>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-field-group">
                              <div class="text-field-wrapper"> 
                                 <input type="tel" class="pl-90" id="phone" @if($userdata && $userdata->storeDetail) value="{{$userdata->storeDetail->contact_number}}" @endif name="phone" placeholder="Enter Store Contact Number">
                              </div>
                              <span id="valid-msg" class="hide"></span>
                              <span id="error-msg" class="hide error"></span>
                              <span id="mobile-error"></span>
                              @if(Session::has('errors'))
                              <span class="error">{{Session::get('errors')->first('contact_number')}}</span>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-field-group">
                              <div class="text-field-wrapper">
                                 <input type="text" name="address" @if($userdata && $userdata->storeDetail) value="{{$userdata->storeDetail->formatted_address}}" @endif maxlength="150" id="address" value=""  autocomplete="off" placeholder="Enter Location as per google Maps">                                            
                              </div>
                           </div>
                           @if(Session::has('errors'))
                           <span class="error">{{Session::get('errors')->first('address')}}</span>
                           @endif
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-field-group">
                              <div class="text-field-wrapper"> 
                                 <textarea name="about" placeholder="About Your Store">@if($userdata && $userdata->storeDetail){{($userdata->storeDetail->about_store)}}@endif</textarea>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="frm-rt-sd" id="map">
            </div>
            <div class="frm_btn w-100">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="btn-group">
                        <button type="submit" class="green-fill btn-effect m-t-20">Next</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <input type="hidden"  name="street_number" value="" id="street_number">
      <input type="hidden" name="locality" value="" id="locality">
      <input type="hidden" name="postal_code" value="" id="postal_code">
      <input type="hidden" name="country" value="" id="country">
      <input type="hidden" name="state" value="" id="administrative_area_level_1">
      <input type="hidden" @if($userdata && $userdata->storeDetail) value="{{$userdata->storeDetail->lat}}" @endif name="lat"  id="lat">
      <input type="hidden" @if($userdata && $userdata->storeDetail)  value="{{$userdata->storeDetail->lng}}" @endif name="lng"  id="lng">
      <input type="hidden" name="time_zone" value="" id="time_zone">
   </form>
   <!-- Form Container End -->
</div>
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{ asset('asset-store/js/autocomplete.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjN4ZWartGxRef-S_LYQWqhfCsWWvZBbI&libraries=places&callback=initialize" async defer></script>
<link rel="stylesheet" href="{{asset('asset-store/js/intl-tel-input-master/build/css/intlTelInput.css')}}">
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/intlTelInput.min.js')}}"></script>
<script src="{{asset('asset-store/js/intl-tel-input-master/build/js/utils.js')}}"></script>
<script src="{{ asset('js/disableBackButton.js')}}"></script>
<script>
   var input = document.querySelector("#phone"),
       errorMsg = document.querySelector("#error-msg"),
       validMsg = document.querySelector("#valid-msg");
   
   // here, the index maps to the error code returned from getValidationError - see readme
   var errorMap = ["Please enter valid mobile number", "Invalid country code", "Mobile number length is too short", "Mobile number length is too long", "Please enter valid mobile number"];
   
   
   // initialise plugin
   var iti = window.intlTelInput(input, {
       hiddenInput: "contact_number",
       onlyCountries : ["us"],
       preferredCountries : ["us"],
       allowDropdown : false,
       utilsScript: "{{asset('asset-store/js/intl-tel-input-master/src/js/utils.js')}}"
   });
   
   var reset = function() {
       input.classList.remove("error");
       errorMsg.innerHTML = "";
       errorMsg.classList.add("hide");
       validMsg.classList.add("hide");
   };
   
   // on blur: validate
   input.addEventListener('blur', function() {
       reset();
       if (input.value.trim()) {
           if (iti.isValidNumber()) {
               validMsg.classList.remove("hide");
               
           } else {
               input.classList.add("error");
               var errorCode = iti.getValidationError();
               errorMsg.innerHTML = errorMap[errorCode];
               errorMsg.classList.remove("hide");
           }
       }
   });
   
   // on keyup / change flag: reset
   input.addEventListener('change', reset);
   input.addEventListener('keyup', reset);
   
   
   
   // $("body").on("click",".nextTab", function(){
   
   //     if (iti.isValidNumber()) {
   //       $("#store_details_submit").submit();
   //     }
   // })
   
   
   $("#store_details_submit").validate({
       errorClass:'error',
       errorElement:'span',
       rules: {
           store_name: {
               required: true,
               maxlength : 50,
               minlength : 3
           },
           phone: {
               required: true
           },
   
           address: {
               required: true
           }
   
       },
       // errorPlacement: function (error, element) {
       //         if (element.attr("name") == "phone") {
       //                    error.insertAfter("#mobile-error");
       //          }else{
       //              insertAfter(element);
       //          }
       //     },
       messages: {
           store_name: {
               required: "Please enter your store name"
           },
           contact_number: {
               required: "Please enter store contact number"
           },
           address: {
               required: "Please enter store address"
           }
   
       },
      
       submitHandler: function(form,event) {
            event.preventDefault();
           if (iti.isValidNumber()) {
               form.submit();
           }
   
   
       }
   });
   
   $(document).ready(function() {
       $(window).keydown(function(event){
           if(event.keyCode == 13) {
           event.preventDefault();
           return false;
           }
       });
   });
   
</script>
@endsection
@endsection