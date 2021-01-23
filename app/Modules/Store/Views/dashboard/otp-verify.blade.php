@extends('Store::register.layout')
@section('content')
{{-- @include('Store::includes.header') --}}
<!-- Header End -->
<!-- Internal Container -->
<figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
<div class="internal-container">
   <!-- Form Container -->
   <div class="form-container">
      <div class="frm-lt-sd">
         <div class="counter"><span>2</span>/3</div>
         <div class="ins-frm-lt-sd">
            <span class="hd">OTP verify</span>
            <div class="shd sign">OTP successfully sent to <br> <span>{{$phone}}</span></div>
            <a class="ch-shd" href="{{route('store.register.mobile')}}">Not Right?</a>
            <form action="{{ route('store.verify.mobile.otp')}}" method="get" id="step_three_verification">
               <div class="frm-sec-ins">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-field-group invalid">
                           <div class="text-field-wrapper">
                              <input type="text" maxlength="6" id="otp_input" name="otp" autocomplete="off"  placeholder="Enter OTP">
                              <div><span id="timer"></span></div>
                           </div>
                           <span class="error alreadyTaken" id="opt_validation_error"></span>
                           <span class="success" style="color:green;" id="opt_resent_error"></span>
                           {{-- @if(!empty(Request::get('message')))  
                           <div class="alert alert-success">
                              {{Request::get('message')}}
                           </div>
                           @endif  --}}
                           @if (!empty(Request::get('message')))
                           <div class="alert alert-success">
                              {{Request::get('message')}}
                           </div>
                           @endif 
                        </div>
                     </div>
                     @if(Session::has('errors'))
                     <span class="error alreadyTaken">{{ Session::get('errors')->first('otp') }}</span>
                     @endif
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <button type="button"  class="green-fill btn-effect" id="submit_button_otp">Submit</button>
                        <button type="button" class="disable_input ch-shd back line_effect" disabled="disabled" id="resent_api_button" data-resend = "{{$phone}}" href="javascript:void(0);" data-phone_code={{$phone_code}}>Resend <span id="show_tool_tip_message">?</span></button>
                     </div>
                  </div>
                  {{-- 
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="trm-cond-sec">
                           By signing up you agree to Cannabis <a href="{{route('store.static.cms.page',['slug'=>'terms-conditions'])}}">Terms & Conditions</a> and 
                           <a href="{{route('store.static.cms.page',['slug'=>'privacy-policy'])}}">Privacy Policy</a>
                        </div>
                     </div>
                  </div>
                  --}}
               </div>
               <input type="hidden" name="otphash" id="otp_has_pass" value="{{$otp}}">
               <input type="hidden" name="phone" value="{{$phone}}">
            </form>
         </div>
         <div class="progressBorder"></div>
         <div class="step step1"></div>
      </div>
      <div class="frm-rt-sd">
         <figure class="ico"><img src="{{asset('asset-store/images/user.svg')}}" alt=""></figure>
         <p class="para otp">Let’s quickly verify your account
         </p>
      </div>
   </div>
   <!-- Form Container End -->
</div>
<input type="hidden" id="hidden_resent_url" value="{{route('store.reset.password.resend.mobile')}}">
@section('pagescript')
<script src="{{ asset('js/disableBackButton.js')}}"></script>
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script>
   var sha256 = function a(b) {
       function c(a, b) {
           return a >>> b | a << 32 - b
       }
       for (var d, e, f = Math.pow, g = f(2, 32), h = "length", i = "", j = [], k = 8 * b[h], l = a.h = a.h || [], m = a.k = a.k || [], n = m[h], o = {}, p = 2; 64 > n; p++)
           if (!o[p]) {
               for (d = 0; 313 > d; d += p) o[d] = p;
               l[n] = f(p, .5) * g | 0, m[n++] = f(p, 1 / 3) * g | 0
           } for (b += "\x80"; b[h] % 64 - 56;) b += "\x00";
       for (d = 0; d < b[h]; d++) {
           if (e = b.charCodeAt(d), e >> 8) return;
           j[d >> 2] |= e << (3 - d) % 4 * 8
       }
       for (j[j[h]] = k / g | 0, j[j[h]] = k, e = 0; e < j[h];) {
           var q = j.slice(e, e += 16),
               r = l;
           for (l = l.slice(0, 8), d = 0; 64 > d; d++) {
               var s = q[d - 15],
                   t = q[d - 2],
                   u = l[0],
                   v = l[4],
                   w = l[7] + (c(v, 6) ^ c(v, 11) ^ c(v, 25)) + (v & l[5] ^ ~v & l[6]) + m[d] + (q[d] = 16 > d ? q[d] : q[d - 16] + (c(s, 7) ^ c(s, 18) ^ s >>> 3) + q[d - 7] + (c(t, 17) ^ c(t, 19) ^ t >>> 10) | 0),
                   x = (c(u, 2) ^ c(u, 13) ^ c(u, 22)) + (u & l[1] ^ u & l[2] ^ l[1] & l[2]);
               l = [w + x | 0].concat(l), l[4] = l[4] + w | 0
           }
           for (d = 0; 8 > d; d++) l[d] = l[d] + r[d] | 0
       }
       for (d = 0; 8 > d; d++)
           for (e = 3; e + 1; e--) {
               var y = l[d] >> 8 * e & 255;
               i += (16 > y ? 0 : "") + y.toString(16)
           }
       return i
   };
   
   
   $("body").on('click','#submit_button_otp',function(){
   
           var otp = $("#otp_input").val();
           $("#opt_validation_error").html("");
           if(otp.length == 0) {
               $("#opt_validation_error").html("Please enter OTP received.");
               return false;
           }
         
           
           if(localMsg.BY_PASS_OTP==parseInt(otp)){
               $("#step_three_verification").submit();
               return;
           }
           
           if(sha256(otp.toString()) != $("#otp_has_pass").val() ) {
               $("#opt_validation_error").html("Your have entered invalid OTP.");
               return false;
           }
   
           $("#step_three_verification").submit();
   
   });
   
   //used to stop hit button
   $('#step_three_verification').on('keyup keypress', function(e) {
   var keyCode = e.keyCode || e.which;
   if (keyCode === 13) { 
   var otp = $("#otp_input").val();
           $("#opt_validation_error").html("");
           if(otp.length == 0) {
               $("#opt_validation_error").html("Please enter OTP received.");
               return false;
           }   
   
           if(localMsg.BY_PASS_OTP==parseInt(otp)){
               $("#step_three_verification").submit();
               return true;
           }
   
           if(sha256(otp.toString()) != $("#otp_has_pass").val() ) {
               $("#opt_validation_error").html("Your have entered invalid OTP.");
               return false;
           }
   
           $("#step_three_verification").submit();
   
   }
   });
   
   
   var RESEND_EMAIL_TO_CLIENT = {
   __submit_new_otp: function(phone,phone_code) {
     
   $.ajax({
       type: "get",
       url:$("#hidden_resent_url").val(),
       data: {
           "phone": phone,
           "phone_code":phone_code,
       },
       cache: false,
       beforeSend : function() {
   
                   $("#resent_api_button").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
                   $("#opt_resent_error").html("");
       },
       dataType : 'json',
       success: function(response) {
               if(parseInt(response.code) == 200) {
   
                   $("#opt_resent_error").html('<div class="alert alert-success"><strong>Success!</strong> '+ response.messages +'<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                   $("#otp_has_pass").val(response.hash);
               }else{
                   $("#opt_validation_error").text(response.messages);
               }
       },
       error : function() {
   
               alert('Something went wrong');
       },
       complete : function() {
   
           $("#resent_api_button").html('Resend');
           $("#resent_api_button").prop('disabled',true);
           timer(90);
     
       }
   });
   
   
   }
   }
   
   
   
   let timerOn = true;
   
   function timer(remaining) {
   var m = Math.floor(remaining / 60);
   var s = remaining % 60;
   
   m = m < 10 ? '0' + m : m;
   s = s < 10 ? '0' + s : s;
   document.getElementById('timer').innerHTML = m + ':' + s;
   remaining -= 1;
   
   if (remaining >= 0 && timerOn) {
       setTimeout(function() {
           timer(remaining);
       }, 1000);
       return;
   }
   
   if (!timerOn) {
       // Do validate stuff here
       return;
   }
   $("#timer").html("");
   $("#otp_has_pass").val("");
   $("#resent_api_button").prop('disabled',false);
   }
   
   timer(90);
   
   
   $("body").on('click','#resent_api_button',function(){
   var phone = $(this).attr('data-resend');
   var phone_code=$(this).data('phone_code');
   RESEND_EMAIL_TO_CLIENT.__submit_new_otp(phone,phone_code);
   });
   
   
</script>
@endsection
@endsection