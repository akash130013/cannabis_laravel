<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cannabis</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <!-- <link href="{{asset('asset-store/css/header.css')}}" rel="stylesheet" type="text/css"> -->

        <link href="{{asset('asset-store/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('asset-store/css/header.css')}}" rel="stylesheet">
        <link href="{{asset('asset-store/css/onboarding.css')}}" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background: #f7f9fc;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .guestUser{
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .guestUser ul{
                width: 100%;
                padding: 0;
                display: flex;
                justify-content: center;
            }
            .guestUser li{
                list-style:none;
            }
            .guestUser li a{    
                border: 1px solid #8cc83b;
                padding: 20px 60px;
                margin: 0 40px;
                text-decoration: none;
                color: #8cc83b;
                text-transform: uppercase;
                font-weight: 600;
                transition: all 0.6s ease;
                outline: none;
                cursor:pointer;
                -webkit-transition: all 0.6s ease;
                -moz-transition: all 0.6s ease;
                -ms-transition: all 0.6s ease;
                -o-transition: all 0.6s ease;
            }
            .guestUser li a:hover,.guestUser li a:focus,.guestUser li a.active{
                color:#fff;
                background: #8cc83b;;
            }
        </style>
    </head>
    <body>
    <header>
        <div class="container">
            <!-- Branding -->
            <a href="#" class="branding"><img src="{{asset('asset-store/images/logo.svg')}}" alt=""></a>
            <!-- Branding End -->
        </div>
    </header>
        <div class="flex-center position-ref full-height">
            <!-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif -->

            
            <div class="guestUser">
                <ul>
                        <li>
                                <a href="{{route('admin.login')}}"> Admin</a>
                         </li>

                         <li>
                         <a href="{{route('store.login')}}"> Store</a>
                         </li>

                        <li>
                            <a href="{{route('users.login')}}">User</a>
                        </li>

                </ul>
            </div>
        </div>
    </body>
</html>
