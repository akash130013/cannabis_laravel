@extends('Store::register.layout')
@section('content')
<!-- Internal Container -->
<figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>
<div class="internal-container">
   <!-- Form Container -->
   <div class="form-container">
      <div class="frm-lt-sd">
         <div class="ins-frm-lt-sd">
            <span class="hd">Create Account</span>
            <span class="shd">Enter your email and create a password. Get use all our products</span>
            <form action="{{route('store.register.step-two')}}" method="get" id="store_login_validation">
               <div class="frm-sec-ins">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="first_name" maxlength="50" value="{{ empty($previousData['first_name']) ? old('first_name') : $previousData['first_name'] }}"  placeholder="First Name">
                           </div>
                           @if(Session::has('errors'))
                           <span class="error">{{ Session::get('errors')->first('first_name') }}</span>
                           @endif
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="second_name" maxlength="50" value="{{ empty($previousData['second_name']) ? old('second_name') : $previousData['second_name'] }}"  placeholder="Last Name" >
                           </div>
                           @if(Session::has('errors'))
                           <span class="error">{{ Session::get('errors')->first('second_name') }}</span>
                           @endif 
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-field-group">
                           <div class="text-field-wrapper">
                              <input type="text" name="email" maxlength="75"  value="{{ empty($previousData['email']) ? old('email') : $previousData['email'] }}"  placeholder="Email">
                           </div>
                           @if(Session::has('errors'))
                           <span class="error alreadyTaken">{{ Session::get('errors')->first('email') }}</span>
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <button class="green-fill btn-effect">Get Started</button>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="trm-cond-sec">
                           By signing up you agree to Cannabis <a href="{{route('store.static.cms.page',['slug'=>'terms-conditions'])}}" target="_blank">Terms & Conditions</a> and <a target="_blank" href="{{route('store.static.cms.page',['slug'=>'privacy-policy'])}}">Privacy Policy</a>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="frm-rt-sd">
         <figure class="ico"><img src="{{asset('asset-store/images/shop.svg')}}" alt=""></figure>
         <p class="para">Get your store listed with us</p>
      </div>
   </div>
   <!-- Form Container End -->
</div>
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
<script src="{{ asset('js/disableBackButton.js')}}"></script>
<script src="{{ asset('asset-store/js/store-signup.js')}}"></script>
@endsection
@endsection