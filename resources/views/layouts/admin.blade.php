<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cannabis') }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('asset-store/images/cannabis_leaf.ico')}}" />
    <!-- Favicon End -->
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('asset-store/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('asset-store/css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('asset-admin/css/dashboardapp.css') }}" rel="stylesheet">
    <link href="{{ asset('asset-store/css/onboarding.css') }}" rel="stylesheet">
    <link href="https://www.cssscript.com/demo/message-toaster/toast.css" rel="stylesheet">
    <link href="https://www.cssscript.com/demo/message-toaster/toast.css" rel="stylesheet">
</head>
<body>

    <div class="app_wrapper">

            <header>
                    <div class="container">
                        <!-- Branding -->
                        <a href="#" class="branding"><img src="{{asset('asset-store/images/logo.svg')}}" alt=""></a>
                        <!-- Branding End -->
                        <!-- Right Container -->
                        <div class="header-right-container">
                            {{-- <a href="#" class="log-sign-btn line">Login</a> --}}
                            {{-- <a href="#" class="log-sign-btn fill">Sign Up</a> --}}
                        </div>
                        <!-- Right Container End -->
                    </div>
                </header>
    <!-- Header End -->
    <!-- Internal Container -->
    <div class="internal-container">
        <!-- Form Container -->
        <div class="form-container">
             @yield('content')
            
        </div>
        <!-- Form Container End -->
    </div>

</div>
<figure class="tree-des"><img src="{{asset('asset-store/images/sig-tree.png')}}" alt=""></figure>

</body>
<script src="{{asset('asset-store/js/jquery.min.js')}}"></script>
<script src="{{asset('asset-store/js/bootstrap.min.js')}}"></script>
<script src="{{asset('asset-store/js/common.js')}}"></script>
<script src="{{asset('asset-store/js/toster.js')}}"></script>  
<script src="{{asset('js/disable.autocomplete.js')}}"></script>
<script src="{{asset('js/custom.autocompletedisable.js')}}"></script>
<script>
 var myToast = new Toast({
        title: '', 
        content: "@if(Session::has('success')) {{Session::get('success')['message'] }} @endif",
        append: false, // selector
        timeout: 10000,
        showProgress: true ,
        easing: 'quart-in-out',
        // warning, info, success, caution
        type: 'success'

    })
    @if(Session::has('success'))
     
      myToast.show();
    @endif

    function showPassword() 
    {
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
    function checkPasswordStrength() {
      
    var number = /([0-9])/;
    var alphabets = /([a-zA-Z])/;
    var upperCase = /([A-Z])/;
    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
    if ($('#password_type').val().length < 8) {
        $('#password-strength-status').removeClass();
        $('#password-strength-status').addClass('weak-password');
        $('#password-strength-status').html("Weak (should be atleast 8 characters.)");
        $("#submit_button").prop('disabled', true);
        $('#password-strength-status').css('color', 'red');
    } else {
        if ($('#password_type').val().match(number) && $('#password_type').val().match(upperCase) && $('#password_type').val().match(alphabets) && $('#password_type').val().match(special_characters)) {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('strong-password');
            $('#password-strength-status').html("Strong");
            $('#password-strength-status').css('color', 'green');
            $("#submit_button").prop('disabled', false);
        } else {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('medium-password');
            $('#password-strength-status').html("Medium (should include alphabets, uppercase, numbers and special characters.)");
            $("#submit_button").prop('disabled', true);
            $('#password-strength-status').css('color', 'red');
        }
    }
}
$('.getstarted').on('click',function()
        {
            $('.error').html('');
        })
    
</script>
</html>
