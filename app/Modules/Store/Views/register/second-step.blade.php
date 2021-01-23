@extends('Store::register.layout')
@section('content')
<!-- Internal Container -->
<figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
<div class="internal-container">
   <!-- Form Container -->
   <div class="form-container">
      <div class="frm-lt-sd">
         <div class="ins-frm-lt-sd">
            <span class="hd">Create Password</span>
            <div class="shd sign">signing up as <span>{{ $first_step_input['email']}}</span></div>
            <a class="ch-shd" href="{{route('store.register.user')}}?params={{ base64_encode(serialize($first_step_input))}}">Not Right?</a>
            <form action="{{ route('store.register.step-three')}}" method="get" id="password_validation">
               <div class="frm-sec-ins">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="password" name="password" minlength="6" maxlength="25" onKeyUp="checkPasswordStrength();"  placeholder="Enter password" id="password_type">
                              <div id="password-strength-status" style="color:red;"></div>
                              <img src="{{asset('asset-store/images/info.svg')}}" class="dropmenu info" alt="drop down menu">
                              <div class="dropmessage">
                                 <p>1 Alphabet</p>
                                 <p>1 Number</p>
                                 <p>1 Special Character</p>
                                 <p>1 Upper & Lower Case</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-field-group">
                           <div class="input-holder clearfix">
                              <input type="checkbox" name="remember_me" id="remember_me" value="1">
                              <label for="remember_me">Show Password</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <button class="green-fill btn-effect" id="signup_button">Sign Up</button>
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
               <input type="hidden" name="email" value="{{$first_step_input['email']}}">
               <input type="hidden" name="first_name" value="{{$first_step_input['first_name']}}">
               <input type="hidden" name="second_name" value="{{$first_step_input['second_name']}}">
            </form>
         </div>
      </div>
      <div class="frm-rt-sd">
         <figure class="ico"><img src="{{asset('asset-store/images/key.svg')}}" alt=""></figure>
         <p class="para">Get your store listed with us</p>
      </div>
   </div>
   <!-- Form Container End -->
</div>
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{ asset('js/disableBackButton.js')}}"></script>
<script src="{{asset('asset-store/js/addmethod.js')}}"></script>
<script src="{{asset('asset-store/js/store-signup.js')}}"></script>
@endsection
@endsection