<!doctype html>
<html lang="en">

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        html,
        body {
            height: 100%;
        }
        
        img {
            display: block;
        }
        
        span {
            font-weight: 600;
        }
        
        .logo {
            width: 250px;
        }
        
        @media screen and (max-width: 500px) {
            .head {
                font-size: 25px !important;
            }
            .subhead {
                padding: 50px 0 0 !important;
                font-size: 16px !important;
            }
            .title {
                font-size: 16px !important;
            }
            .para {
                font-size: 14px !important;
                margin: 20px 0 !important;
            }
            .invbtn {
                font-size: 14px !important;
                padding: 15px 40px !important;
            }
            .logo {
                width: 250px !important;
            }
            .tablecl {
                padding: 0 15px 30px !important;
            }
            .dwntbl {
                padding: 12px 15px !important;
            }
            .copyrgt {
                font-size: 11px !important
            }
        }
    </style>
</head>

<body style="padding: 0; margin: 0;">
    <table cellpadding="0" cellspacing="0" border="0" style="padding: 0 50px 30px;margin: 0 auto; min-width:320px; max-width:700px; width:100%; font-family: Arial,sans-serif;background-color: #4b8e21;color: #ffffff;">
        <tr>
            <td style="width: 100%">
                &nbsp;
                <!-- <img src="images/image-1.png" alt="" width="100%"> -->
            </td>
        </tr>
        <tr>
            <td style="width: 100%">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td align="center" class="head" style=" padding: 0 0 20px; font-size: 45px; color: #fff;  font-weight: 600;">Welcome </td>
        </tr>
        <tr>
            <td style="width: 100%">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td style="width: 100%">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td style="width: 100%">
                <table cellpadding="0" cellspacing="0" border="0" class="tablecl" style="border-top-left-radius: 4px;border-top-right-radius: 4px;width:100%;background-color:#fff; margin:0; padding: 50px 70px 30px;">
                    <tr>
                        <td colspan="2" align="center"><img src="{{asset('asset-store/images/logo.svg')}}" width="346" alt="" class="logo"></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="subhead" style="padding: 80px 0 20px; font-size: 24px; font-weight: 600;color:#444444;">Hello! </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="para" style="font-size: 19px; font-weight: 400; line-height: 1.9; color: #444444; letter-spacing: 0.4px; padding: 15px 0 20px;">
                            New request from user, detail is listed below
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 19px; font-weight: 400; line-height: 1.9; color: #444444; letter-spacing: 0.4px; padding:15px 20px 0px 0px;vertical-align: top;">User Name - </td>
                        <td style="font-size: 19px; font-weight: 400; line-height: 1.9; color: #444444; letter-spacing: 0.4px; padding:15px 20px 0px 0px;vertical-align: top;">
                                {{$mailData['full_name']}}
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 19px; font-weight: 400; line-height: 1.9; color: #444444; letter-spacing: 0.4px; padding:15px 20px 0px 0px;vertical-align: top;">Phone Number - </td>
                        <td style="font-size: 19px; font-weight: 400; line-height: 1.9; color: #444444; letter-spacing: 0.4px; padding:15px 20px 0px 0px;vertical-align: top;">
                                {{$mailData['phone']}}
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 19px; font-weight: 400; line-height: 1.9; color: #444444; letter-spacing: 0.4px; padding:15px 20px 0px 0px;vertical-align: top;">Mail- </td>
                        <td style="font-size: 19px; font-weight: 400; line-height: 1.9; color: #444444; letter-spacing: 0.4px; padding:15px 20px 0px 0px;vertical-align: top;">{{$mailData['email']}}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 19px; font-weight: 400; line-height: 1.9; color: #444444; letter-spacing: 0.4px; padding: 15px 20px 0px 0px;vertical-align: top;">Product Name - </td>
                        <td style="font-size: 19px; font-weight: 400; line-height: 1.9; color: #444444; letter-spacing: 0.4px; padding: 15px 20px 0px 0px;vertical-align: top;">{{$mailData['favourite_product']}}</td>
                    </tr>
                   
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding:0">
                <table cellpadding="0" cellspacing="0" border="0" class="dwntbl" style="border-bottom-left-radius: 4px;border-bottom-right-radius: 4px;width:100%; padding: 14px 25px; background: #f4f7f8; ">
                    <tr>
                        <td class="copyrgt" style="font-size: 14px; color: #a0a9bd;">
                            Copyright © 2019 420kingdom.
                        </td>
                        <td align="right">
                            <a href=" javascript:void(0) " style="padding: 0 3px; display: inline-block;width:23px;height:23px; "><img src="{{asset('asset-store/images/facebook.png')}}" style="width:29px;height:29px;" alt=" "></a>
                            <a href=" javascript:void(0) " style="padding: 0 3px; display: inline-block;width:23px;height:23px;  "><img src="{{asset('asset-store/images/instagram.png')}} " style="width:29px;height:29px;" alt=" "></a>
                            <a href=" javascript:void(0) " style="padding: 0 3px; display: inline-block;width:23px;height:23px;  "><img src="{{asset('asset-store/images/twitter.png')}} " style="width:29px;height:29px;" alt=" "></a>
                            <a href=" javascript:void(0) " style="padding: 0 3px; display: inline-block;width:23px;height:23px; "><img src="{{asset('asset-store/images/linkedin.png')}} " style="width:29px;height:29px;" alt=" "></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>