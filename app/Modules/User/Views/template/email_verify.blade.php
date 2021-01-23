<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">      
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Thank You</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <style>
        body,html{
            height: 100%;
        }
        .mainContainer{
            min-height: 100%;
        }
        .container{
            margin: 30px auto;      
            max-width: 650px;
        }
        .wrapper{
            background: #f3f3f3;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            text-align: center;
            padding: 30px;
        }
        .wrapper img{
            width: 80px;
            overflow: hidden;
        }
        .wrapper h1{
            color: #2d2e30;
        }
        .wrapper p{
            font-size: 14px;
            font-weight: 500;
        }
        .wrapper a{
            color: #8cc83b;
            text-decoration: underline;
        }
       

    </style>

</head>

<body>
    <div class="mainContainer">
        <div class="container">
            <div class="wrapper">
                <figure>
                    <img src="{{asset('asset-user-web/images/checkbox-circle-line.png')}}"/>
                </figure>
                <h1>Thank You!</h1>
                <p>Your Email has been verified successfully.</p>
                  <a href="{{route('user.home')}}">
                        Get back to homepage
                </a>
            </div>
        </div>
    </div>

</body>

</html>