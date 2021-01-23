@extends('User::includes.innerlayout')
@include('User::includes.navbar')
@include('User::settings.leftpanel')


<!--header close-->
@section('content')

@yield('nav-bar')


<section class="inner_centerpanel">
   <div class="custom_container">
      <div class="flex-row align-items-center">
         <div class="flex-col-sm-6 flex-col-xs-6">
            <h2 class="title-heading m-t-b-30">Account Overview</h2>
         </div>
         <div class="flex-col-sm-6 flex-col-xs-6 text-right">
         <img src="{{asset('asset-user-web/images/menu-line.svg')}}" class="profile-mobile-menu">
         </div>
      </div>
      <div class="flex-row account_wrapper">
         <!--Setting Menu Col-->
         @yield('left-panel')
         <!--Setting Menu Col Close-->

         <!--Setting Detail Col-->
       
            <div class="account-details-col">
               <form action="{{route('user.update.password')}}" method="post" id="smoke_validation_id">
               @csrf
               <div class="flex-row m-t-30">
                  <div class="flex-col-sm-6">
                     <div class="form-field-group">
                        <div class="text-field-wrapper">
                           <input type="password" name="current_password" placeholder="Current Password">
                        </div>

                        @if(Session::has('errors'))
                        <span class="error">{{Session::get('errors')->first('current_password')}}</span>
                        @endif

                     </div>
                  </div>
               </div>
               <div class="flex-row">
                  <div class="flex-col-sm-6">
                     <div class="form-field-group">
                        <div class="text-field-wrapper">
                           {{-- <input type="password" name="new_password" id="new_password" placeholder="New Password"> --}}
                           <input type="password" name="password"  placeholder="Enter New password" id="password_type" autocomplete="new-password">
                           {{-- <span class="dropmenu info">
                                 <img src="{{asset('asset-user-web/images/info.png')}}">
                           </span> --}}
                           <span id="show_eye" class="detect-icon" onclick="showPassword()" style="display:none"><i class="fa fa-eye" aria-hidden="true"></i></span>
                           <span id="hide_eye" class="detect-icon" onclick="showPassword()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                           {{-- <div class="dropmessage">
                              <p>1 Alphabet</p>
                              <p>1 Special Character</p>
                              <p>1 Upper & Lower Case</p>
                           </div>      --}}
                          
                        </div>
                        <span id="pass"></span>
                        {{-- <div id="password-strength-status" class="error"></div> --}}

                        @if(Session::has('errors'))
                        <span class="error fadeout-error">{{Session::get('errors')->first('password')}}</span>
                        @endif


                     </div>
                  </div>
               </div>
               <div class="flex-row">
                  <div class="flex-col-sm-6">
                     <div class="form-field-group">
                        <div class="text-field-wrapper">
                           <input type="password" name="new_confirm_password" placeholder="Confirm New Password">
                        </div>

                        @if(Session::has('errors'))
                        <span class="error">{{Session::get('errors')->first('new_confirm_password')}}</span>
                        @endif



                     </div>
                  </div>
               </div>
               <div class="flex-row">
                  <div class="flex-col-sm-6">
                     <button class="custom-btn green-fill getstarted btn-effect btn-sm" id="submit_button">Submit</button>
                  </div>
               </div>
               </form>
            </div>
         
         <!--Setting Detail Col Close-->
      </div>
   </div>
</section>

<input type="hidden" name="search_type" value="1">
@section('pagescript')
<script src="{{ asset('asset-store/js/jquery.validator.plugin.js')}}"></script>

<script>





   $("#smoke_validation_id").validate({
      errorClass: 'error',
      errorElement: 'span',
      ignore: [],
      rules: {
         current_password: {
            required:true,
            minlength: 5
         },
         password: {
            required:true,
            minlength: 6
         },
         new_confirm_password: {
            minlength: 6,
            required:true,
            equalTo: "#password_type"
         }
      },
      success: function(label, element) {
         label.parent().parent().removeClass('error-message');
         label.remove();
      },
      errorPlacement: function (error, element) { 
                if (element.attr("name") == "password") {
                           error.insertAfter("#pass");
                 }else{
                     error.appendTo($(element).parents('.text-field-wrapper')).next();
                 }
      },
      messages: {
         new_confirm_password: {
            equalTo: "Password is not matched",
        },
      },
      submitHandler: function(form, event) {
         //event.preventDefault();
         $("#submit_button").html('<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
         form.submit();
      },
   });




   function checkPasswordStrength() {
    var number = /([0-9])/;
    var alphabets = /([a-zA-Z])/;
    var upperCase = /([A-Z])/;
    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
    if ($('#password_type').val().length >= 6) {
    if ($('#password_type').val().length < 8) {
        $('#password-strength-status').removeClass();
        $('#password-strength-status').addClass('weak-password');
        $('#password-strength-status').html("Weak (good to have atleast 8 characters.)");
      //   $("#submit_button").prop('disabled', true);
        $('#password-strength-status').addClass('error');
        $('#password-strength-status').css('color', 'red');
    } else {
        if ($('#password_type').val().match(number) && $('#password_type').val().match(upperCase) && $('#password_type').val().match(alphabets) && $('#password_type').val().match(special_characters)) {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('strong-password');
            $('#password-strength-status').html("Strong");
            $('#password-strength-status').css('color', 'green');
            // $("#submit_button").prop('disabled', false);
        } else {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('medium-password');
            $('#password-strength-status').html("Medium(Good to have at least 1 alphabet,1 number,1 special character, 1 upper case and 1 lower case)");
            // $("#submit_button").prop('disabled', true);
            // $('#password-strength-status').css('color', 'red');
            $('#password-strength-status').addClass('error');

        }
    }
   }else{
      $('#password-strength-status').html('');
   }
}


function showPassword() {
  var x = document.getElementById("password_type");
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
</script>
@endsection



@endsection