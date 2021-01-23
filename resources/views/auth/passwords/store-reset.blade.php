@extends('layouts.store')

@section('content')

        <div class="form-container">
            <div class="frm-lt-sd">
                <div class="ins-frm-lt-sd">
                    <span class="hd">Store Reset Password</span>
                    <span class="shd">Please fill the details and reset your password</span>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal frm-sec-ins" role="form" method="POST" action="{{ route('store.password.request') }}" id="forgetPassFormId">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                           
                           
                             <div>
                            
                            <input type="hidden" name="email" value="{{$email}}">

                                @if ($errors->has('email'))
                                    <span class="error">
                                        {{ $errors->first('email')}}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div>
                                <div class="form-field-group">
                                        <div class="text-field-wrapper">
                                                <input type="password" minlength="6" name="password" onKeyUp="checkPasswordStrength();"  placeholder="Enter password" id="password_type">

                                                <div id="password-strength-status" style="color:red;"></div>
                                                <img src="{{asset('asset-store/images/info.svg')}}" class="dropmenu info" alt="drop down menu">
                                                <div class="dropmessage">
                                                    <p>1 Alphabet</p>
                                                    <p>1 Number</p>
                                                    <p>1 Special Character</p>
                                                    <p>1 Upper & Lower Case</p>
                                                </div>
                                        </div>
                                        @if ($errors->has('password'))
                                        <span class="error">
                                        {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        
                            <div class="">
                              
                                <div class="form-field-group">
                                        <div class="text-field-wrapper">
                                                <input id="password-confirm" type="password" placeholder="Confirm Password"  name="password_confirmation"  minlength="8">
                                        </div>
                                @if ($errors->has('password_confirmation'))
                                    <span class="error" >
                                        {{ $errors->first('password_confirmation') }}
                                    </span>
                                @endif
                                    </div>
                            </div>
                        </div>

                        <div class="row">
                                <div class="col-sm-12">
                                    <button class="green-fill btn-effect" type="submit" id="reset_store_btn">Reset Password</button>
                                    
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

        

<script src="{{asset('asset-store/js/jquery.min.js')}}"></script>
    <script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>
    {{-- <script src="{{asset('asset-store/js/common.js')}}"></script> --}}
 <script>
          
    $("#forgetPassFormId").validate({
        rules: {
             password: "required",
             password_confirmation: {
              required: true,
               equalTo: "#password_type",
             },
            submitHandler: function (form) { 
                    $("#reset_store_btn").html(`<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>`);
                     form.submit();
                }
        },
    });

         function checkPasswordStrength() {
            
        var number = /([0-9])/;
        var alphabets = /([a-zA-Z])/;
        var upperCase = /([A-Z])/;
        var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
        if ($('#password_type').val().length < 8) {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('weak-password');
            $('#password-strength-status').html("Weak (should be atleast 8 characters.)");
            // $("#reset_store_btn").prop('disabled',true);
            $('#password-strength-status').css('color','red');
        } else {
            if ($('#password_type').val().match(number) && $('#password_type').val().match(upperCase) && $('#password_type').val().match(alphabets) && $('#password_type').val().match(special_characters)) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('strong-password');
                $('#password-strength-status').html("Strong");
                $('#password-strength-status').css('color','green');
                // $("#reset_store_btn").prop('disabled',false);
            } else {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('medium-password');
                $('#password-strength-status').html("Medium");
                // $("#reset_store_btn").prop('disabled',true);
                $('#password-strength-status').css('color','red');
            }
        }
    }
        </script>
@endsection