@extends('Store::layouts.master')
@section('content')
<!-- Header End -->
<!-- Internal Container -->
<span class="profile-menu">
   <img src="/asset-store/images/menu-line.svg" alt="profile menu">
</span>
<div class="full_custom_container profile-view">
   @include('Store::layouts.pending-alert')
   <div class="wrap-row-full">
      @include('Store::profile.profile-sidebar')
      <!--Profile Detail Col-->
      <div class="right-col-space change-password">
         <div class="white_wrapper">
            <div class="col-space">
               <div class="flex-row">
                  <div class="flex-col-sm-4">
                     <form action="{{route('store.update.password')}}" method="POST">
                        @csrf
                        <div class="form-field-group">
                           <div class="text-filled-wrapper">
                              <input type="password" placeholder="Current Password" name="old_password" class="m0" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" value="{{ old('old_password') }}" required autofocus/>
                              @if(Session::has('errors'))
                              <span class="error text-danger">{{ Session::get('errors')->first('old_password')}}</span>
                              @endif
                           </div>
                        </div>
                        <div class="form-field-group">
                           <div class="text-filled-wrapper">
                              <input type="password" id="password_type" minlength="6" onKeyUp="checkPasswordStrength();" placeholder="New Password" name="password" class="m0" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}" required autofocus/>
                              <span id="show_eye" class="detect-icon" onclick="showPassword()" style="display:none"><i class="fa fa-eye" aria-hidden="true"></i></span>
                              <span id="hide_eye" class="detect-icon" onclick="showPassword()">
                              <i class="fa fa-eye-slash" aria-hidden="true"></i>
                              </span>
                           </div>
                           <div id="password-strength-status" style="color:red;"></div>
                           <span id="pass-error" class="error"></span>
                           @if(Session::has('errors'))
                           <span class="error text-danger">{{ Session::get('errors')->first('password')}}</span>
                           @endif
                        </div>
                        <div class="form-field-group">
                           <div class="text-filled-wrapper">
                              <input type="password" placeholder="Confirm Password"  name="password_confirmation" />
                           </div>
                        </div>
                        <button class="green-fill btn-effect" id="submit-btn">Submit</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--Profile Detail Col-->
   </div>
</div>
</div>
</div>
</div> 
<!--Profile Detail Col-->
</div>
@endsection