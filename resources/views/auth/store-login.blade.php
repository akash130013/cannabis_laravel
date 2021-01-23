@extends('layouts.store')

@section('content')

<div class="internal-container">
<div class="form-container">
            <div class="frm-lt-sd">
                <div class="ins-frm-lt-sd">
                    <span class="hd">{{ __('Store Login') }}</span>
                    <span class="shd">Please fill the details and login to your account</span>
                    @if (Session::has('message'))
                        <div class="alert alert-danger remove-alert" role="alert">
                            {{Session::get('message')}}
                            {{-- {{ __('A fresh verification link has been sent to your email address.') }} --}}
                        </div>
                    @endif
                    <form action="{{ route('store.login.submit') }}" method="POST"  autocomplete="off">
                        @csrf
                    <div class="frm-sec-ins">
                        <div class="row">
                            <div class="col-sm-12">
                              
                                <div class="form-field-group">
                                        <div class="text-field-wrapper">
                                                <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus autocomplete="off">
                                        </div>
                                    @if($errors->has('email'))
                                        <span class="error fadeout-error">{{ $errors->first('email') }}
                                        </span>
                                    @endif                
                                    </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                              
                                <div class="form-field-group">
                                        <div class="text-field-wrapper">
                                                <input id="password" type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                                                <span id="show_eye" class="detect-icon" onclick="showPassword()" style="display:none"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                                <span id="hide_eye" class="detect-icon" onclick="showPassword()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                        
                                            </div>
                                @if ($errors->has('password'))
                                    <span class="error">{{ $errors->first('password') }}
                                    </span>
                                @endif
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="green-fill btn-effect">{{ __('Login') }}</button>
                                <a class="ch-shd back line_effect"  href="{{ route('store.password.request') }}">Forgot password?</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="trm-cond-sec">
                                    By signing up you agree to Cannabis <a target="_blank" href="{{route('store.static.cms.page',['slug'=>'terms-conditions'])}}">Terms & Conditions</a> and <a target="_blank" href="{{route('store.static.cms.page',['slug'=>'privacy-policy'])}}">Privacy Policy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
            <div class="frm-rt-sd">
                <figure class="ico"><img src="{{asset('asset-store/images/truck.svg')}}" alt=""></figure>
                <p class="para">Get your store listed with us</p>
            </div>
        </div>
            </div>
@endsection
@section('pagescript')
    <script>
    function showPassword() {
  var x = document.getElementById("password");
  if (x.type === "password") {
     $("#show_eye").show(); 
     $("#hide_eye").hide(); 
    x.type = "text";
  } else {
    x.type = "password";
    $("#show_eye").hide(); 
    $("#hide_eye").show(); 
  }
}
setTimeout(function(){
    removeAlertDiv()
}, 4000)
function removeAlertDiv()
{
    $('.remove-alert').remove();
};
    </script>
@endsection
