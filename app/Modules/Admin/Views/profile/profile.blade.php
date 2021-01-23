@section('content')
@extends('Admin::includes.layout')
@section('content')
 <!-- Side menu start here -->
 @include('Admin::includes.sidebar')
 <!-- Side menu ends here -->
 <div class="right-panel">
         @include('Admin::includes.header')
    <!--breadcrumb-->
    <div class="bred-crumbs">
        <ul>
            <li>
                <a href="#">My Profile</a> 
            </li>
        </ul>
    </div>
    <!--breadcrumb Close-->


    <div class="inner-right-panel">
        <!-- Basic Details Start-->
        <div class="white_wrapper my-profile">
            <!--block heading -->
            <div class="blok_heading">
                <h2>Basic Details</h2>
            </div>
            <!--block heading -->

            <div class="flex-row basic-details">
                <div class="flex-col-sm-3">
                    <div>
                        <h5 class="table-title">Name</h5>
                        <h5 class="table-title">Email Address</h5>
                    </div>
                </div>
                <div class="flex-col-sm-3">
                    <p class="store-detail-data">{{$user->name}}</p>
                    <p class="store-detail-data">{{$user->email}}</p>
                </div>
                {{-- <div class="flex-col-sm-6">
                    <figure class="store_img mt20">
                    <img src="{{$user->profile_pic}}" />
                    </figure>
                    <div class="btn-space text-center">
                        <button class="mr10 primary-btn" disabled>Edit Profile</button>
                    </div>
                </div> --}}
            </div>
        </div>
        <!-- Basic Details Start-->

        <!-- Edit Basic Details Start-->
        <div class="white_wrapper my-profile">
            <!--block heading -->
            <div class="blok_heading">
                <h2>Change Password</h2>
            </div>
            <!--block heading -->
            <!-- form  -->
            <form class="change-password" action="{{route('admin.change.password')}}" method="POST">
                @csrf
                <div class="formfilled-wrapper mb15">
                    <label>Old Password</label>
                    <div class="textfilled-wrapper">
                        <input id="old_password" type="text" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" name="old_password" value="{{ old('old_password') }}" required autofocus>

                        @if(Session::has('errors'))
                            <span class="error">{{ Session::get('errors')->first('old_password')}}</span>
                        @endif
                       
                    </div>
                </div> 
                <div class="formfilled-wrapper mb15">
                    <label>New Password</label>
                    <div class="textfilled-wrapper">
                        <input id="password_type" minlength="6" onKeyUp="checkPasswordStrength();" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }},modal-input" name="password" required>
                        {{-- <input type="password" placeholder="Enter Password" name="password" class="modal-input" id="password" /> --}}
                        <span id="show_eye" class="detect-icon" onclick="showPassword()" style="display:none"><i class="fa fa-eye" aria-hidden="true"></i></span>
                        <span id="hide_eye" class="detect-icon" onclick="showPassword()">
                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                        </span>
                      
                    </div>
                    <div id="password-strength-status" style="color:red;"></div>
                    <span id="pass-error" class="error"></span>
                    @if(Session::has('errors'))
                        <span class="error">{{ Session::get('errors')->first('password')}}</span>
                    @endif
                </div>
                <div class="formfilled-wrapper mb15">
                    <label>Confirm Password</label>
                    <div class="textfilled-wrapper">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
                <div class="btn-space text-center">
                <a class="mr10 green-fill-btn green-border-btn" href="{{route('admin.dashboard')}}">Cancel</a>
                    <button type="submit"class="green-fill-btn">Save</button>
                </div>
            </form>
            <!-- form  -->

        </div>
    </div>
    <!-- Edit Details Start-->  
@endsection