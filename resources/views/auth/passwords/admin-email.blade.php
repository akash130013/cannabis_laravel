@extends('layouts.admin')

@section('content')
<div class="frm-lt-sd">
    <div class="ins-frm-lt-sd">
        <span class="hd">{{ __('Admin Forget Password') }}</span>
        <span class="shd sign">Enter your email and we will send you a email to reset your password</span>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.password.email') }}">
            {{ csrf_field() }}
            <div class="frm-sec-ins">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <input id="email" type="email" placeholder="Enter Email" class="form-control" name="email" value="{{ old('email') }}" required>
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
                        <button class="btn custom-btn green-fill-btn getstarted">{{ __('Send') }}</button>
                        <a class="ch-shd back"  href="{{ route('admin.login') }}">Back to Login</a>
                    </div>
                </div>
            </div>
        </form>        
    </div>
</div>
<div class="frm-rt-sd">
    <figure class="ico"><img src="{{asset('asset-store/images/lock.svg')}}" alt=""></figure>
    <p class="para">Let’s quickly update your password</p>
</div>

<!-- 
<div class="container">
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

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
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