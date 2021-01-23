@extends('Store::register.layout')
@section('content')
<!-- Internal Container -->
<figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
<div class="internal-container">
   <!-- Form Container -->
   <div class="form-container">
      <div class="frm-lt-sd">
         <div class="counter"><span>1</span>/3</div>
         <div class="ins-frm-lt-sd">
            <span class="hd">Mobile Number</span>
            <div class="shd">Please enter the number on which you would want us to send verificaton</div>
            <form action="{{ route('store.submit.mobile')}}" id="store_register_mobile">
               <input type="hidden" name="phone_code">
               <div class="frm-sec-ins">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="tel" maxlength="16" id="phone" name="phone" class="pl-90" placeholder="Enter Mobile Number">
                           </div>
                           <span id="valid-msg" class="hide"></span>
                           <span id="error-msg" class="hide error"></span>
                           <span id="mobile-error"></span>
                           @if(Session::has('errors'))
                           <span class="error alreadyTaken">{{ Session::get('errors')->first('full_phone') }}</span>
                           @endif
                           @if(Session::has('error'))
                           <span class="error">{{ Session::get('error')['message'] }}</span>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <button type="submit" class="green-fill btn-effect">Generate OTP</button>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="trm-cond-sec">
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <div class="progressBorder"></div>
         <div class="step step1"></div>
      </div>
      <div class="frm-rt-sd">
         <figure class="ico"><img src="{{asset('asset-store/images/phone.svg')}}" alt=""></figure>
         <p class="para mobile">Let's quickly verify your mobile number
         </p>
      </div>
   </div>
   <!-- Form Container End -->
</div>
<!-- The Modal -->
<div class="modal logout" id="logout">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">Logout</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <h4>
               Are you sure you want to logout?
            </h4>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <div class="btn-holder logout clearfix">
                        <button type="submit" class="btn success hvr-ripple-out" data-dismiss="modal">Cancel</button>
                        <a href="{{route('store.logout')}}">
                        <button type="button" class="btn success hvr-ripple-out">Logout</button>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
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
       hiddenInput: "full_phone",
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
   
   
   $("#store_register_mobile").validate({
           errorClass:'error',
   rules: {
               phone: {
                   required : true
               }
           },
           errorPlacement: function (error, element) {
               if (element.attr("name") == "phone") {
                          error.insertAfter("#mobile-error");
                }else{
                    insertAfter(element);
                }
           },
   messages: {
   phone: {
                   required : "Please enter your mobile number"
               }	
           },
           
           submitHandler: function(form) {
               if (iti.isValidNumber()) {
                $("input[name='phone_code']").val(iti.s.dialCode);
                
               form.submit();
         }
    }
       });
   
   
   
   
   
   
       
</script>
@endsection
@endsection