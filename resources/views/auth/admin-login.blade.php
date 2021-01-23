@extends('layouts.admin')

@section('content')
   
        <div class="frm-lt-sd">
            <div class="ins-frm-lt-sd">
                <span class="hd">{{ __('Admin Login') }}</span>
                <span class="shd">Please fill the details and login to your account</span>
                <form method="POST" action="{{ route('admin.login.submit') }}"  autocomplete="off">
                    @csrf
                    <div class="frm-sec-ins">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="text-field-wrapper">
                                        <input id="email" type="email" placeholder="Email"  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus  autocomplete="off">
                                    </div>
                                             @if ($errors->has('email'))
                                                 <span class="error fadeout-error">{{ $errors->first('email') }}</span>
                                             @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    <span id="show_eye" class="detect-icon" onclick="showPassword()" style="display:none"><i class="fa fa-eye"></i></span>
                                    <span id="hide_eye" class="detect-icon" onclick="showPassword()"> <i class="fa fa-eye-slash"></i></span>
                 
                                    <span id="pass-error" class="error"></span>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-holder clearfix">
                                        <input type="checkbox" name="remember" id="remember"  {{ old('remember') ? 'checked' : '' }}>
                                        {{-- <label for="remember">{{ __('Remember Me') }}</label> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn custom-btn green-fill-btn getstarted">{{ __('Login') }}</button>
                                <a class="ch-shd back"  href="{{ route('admin.password.request') }}">Forgot password?</a>
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
@endsection
