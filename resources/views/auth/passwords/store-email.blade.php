@extends('layouts.store')

@section('content')
<div class="frm-lt-sd">
                <div class="ins-frm-lt-sd">
                    <span class="hd">Forgot Password</span>
                    <span class="shd">Enter your email and we will send you an email to reset your password</span>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('store.password.email') }}" method="POST"  role="form"  >
                       {{ csrf_field() }}
                    <div class="frm-sec-ins">
                        <div class="row">
                            <div class="col-sm-12">
                               
                                <div class="form-field-group">
                                        <div class="text-field-wrapper{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <input id="email" placeholder="Enter email" type="email"  name="email" value="{{ old('email') }}" required>
                                            </div>
                                            @if ($errors->has('email'))
                                            <span class="error store">{{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="green-fill btn-effect">Send Password Reset Link</button>
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

@endsection