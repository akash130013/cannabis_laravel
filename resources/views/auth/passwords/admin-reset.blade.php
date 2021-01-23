@extends('layouts.admin')

@section('content')
<div class="frm-lt-sd">
    <div class="ins-frm-lt-sd">
        <span class="hd">{{ __('Admin Reset Password') }}</span>
        <span class="shd sign">Please enter your new password and get use all our products</span>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.password.request') }}">
               {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
               <div class="frm-sec-ins">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {{-- <input id="email" type="email" placeholder="Email Address" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus> --}}
                            <input type="hidden" name="email" value="{{$email}}">
                                @if ($errors->has('email'))
                                    <span class="error reset">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password"  placeholder="Enter New Password" type="password" class="form-control" name="password" required minlength="6" maxlength="25">
                                {{-- <div id="password-strength-status" style="color:red;"></div> --}}
                                <span id="show_eye" class="detect-icon-admin" onclick="showPassword()" style="display:none"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                <span id="hide_eye" class="detect-icon-admin" onclick="showPassword()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                <span id="pass-error" class="error"></span>
                                @if ($errors->has('password'))
                                    <span class="error fadeout-error">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="error reset">
                                        {{ $errors->first('password_confirmation') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn custom-btn green-fill getstarted">{{ __('Reset') }}</button>
                        </div>
                    </div>
               </div>
        </form>
    </div>
</div>
<div class="frm-rt-sd">
    <figure class="ico"><img src="{{asset('asset-store/images/shop.svg')}}" alt=""></figure>
    <p class="para">Let’s quickly create your new password</p>
</div>

<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

@endsection