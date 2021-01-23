@extends('layouts.home-page')

@section('content')

<div class="internal-container">
    
        <!-- Form Container -->
        <div class="form-container">
            <div class="formBgWrapper registration dob mobile">
                <div class="container">
                    <div class="frm-lt-sd">
                        <div class="lft-msg dob">
                            <div class="lft-ms-ico">
                                <img src="{{asset('asset-user/images/cannabis_leaf.svg')}}" alt="Cannabis Logo">
                            </div>
                            <h2>This website offers cannabis products and information and is restricted to adults aged 21 years and older
                            </h2>

                        </div>
                    </div>
                    <div class="frm-rt-sd">
                        <div class="ins-frm-lt-sd">
                            <span class="hd">Date of Birth</span>
                            <div class="shd age">
                                Please enter your birthdate to confirm you are at least 21 years of age.
                            </div>

                            <form action="{{route('users.login')}}" id="user_dob_validation_form">
                            <div class="frm-sec-ins">
                               
                                <div class="flex_row">
                                    <div class="flex_col_sm_12">
                                        <div class="form-group dob">
                                            <div class="selectWrapper">
                                                <select name="day" id="dobday">
                                            </select>
                                            </div>
                                            <div class="selectWrapper">
                                                <select name="month" id="dobmonth">
                                            </select>
                                            </div>
                                            <div class="selectWrapper">
                                                <select name="year" id="dobyear">  
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span id="dob-error"></span>

                                <div class="flex_row">
                                    <div class="flex_col_sm_12">
                                        <div class="form-group">
                                            <div class="input-holder acknowledge mt-23 clearfix">
                                                <input type="checkbox" name="remember_me" id="remember_me" value="1">
                                                <label for="remember_me">I Acknowledge that the date of birth provided by me is correct</label>
                                            </div>
                                            <label id="remember_me-error" class="error" for="remember_me"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex_row">
                                    <div class="flex_col_sm_12 mt-50 mobile-space">
                                        <button class="btn custom-btn green-fill getstarted" id="submit_user_verify">Verify</button>
                                    </div>
                                </div>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <input type="hidden" id="user_login_url" value="{{route('users.login')}}">
</div>
  
    <div class="modal fade confirmation" id="minageconfirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">
                    <h2>Welcome !!</h2>
                    <p>Thank you for the verification.You can explore and purchase the product on 420 Kingdom.</p>
                    <div class="row">
                        <div class="col-sm-12 mt-50 mobile-space text-center">
                            <a href="{{route('user.home')}}" class="btn custom-btn green-fill getstarted btn-confirmation">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

       
    <div class="modal fade confirmation" id="minAgeModel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <h2>OOPS !!</h2>
                        <p>Seems like you don't meet the minimum age qualification to view this site.</p>
                        <div class="row">
                            <div class="col-sm-12 mt-50 mobile-space">
                                <a href="javascript:void(0)" class="btn custom-btn green-fill getstarted btn-confirmation" data-dismiss="modal">Re-Enter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection