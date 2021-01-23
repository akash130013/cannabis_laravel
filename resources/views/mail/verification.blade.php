<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>420 Kingdom</title>
    <style>
        body {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Sans-serif', arial;
        }
        
        @media only screen and (max-width: 680px) {
            body,
            table,
            td,
            p,
            a {
                -webkit-text-size-adjust: none !important;
            }
            img {
                height: auto !important;
                max-width: 100% !important;
            }
            table {
                width: 100% !important;
            }
            td {
                font-size: 13px !important;
            }
            td.header {
                width: auto !important;
            }
            td.header-heading {
                padding: 49px 0 10px 0 !important;
            }
            td.user {
                font-size: 16px !important;
                font-weight: 600 !important;
            }
            td.signup-msg {
                padding: 0 0 0 0 !important;
            }
            table.signup-detail {
                padding: 0 0 !important;
            }
            td.social a img {
                width: 90px;
            }
        }
    </style>
</head>

<body>
    <table border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:680px; min-width:320px; -webkit-text-size-adjust: 100%; background:#96cc4d; color:#333333;padding:15px 15px 15px 15px;">
        <tr>
            <td>
                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#fbfcff" style="padding:15px 15px 15px 15px;">

                    <tr>
                        <td valign="top" width="100%" class="header">
                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="top" style="text-align:center;">
                                        <a href="#" style="text-decoration:none;color:#333333;display:inline-block;" target="_blank">
                                            <img src="{{asset('asset-store/images/logo.svg')}}" alt="logo" style="width:250px;" />
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="header-heading user" valign="top" style="color:#323848;font-size:20px;font-weight:500;text-transform:capitalize;padding: 30px 0 25px 34px;">
                                        Hello!
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td class="signup-msg" valign="top" style="color:#363636;font-size:16px;font-weight:600;text-transform:uppercase;line-height:1.3;padding: 0 0 0 34px;">
                                        Your online authorization code is: 341141.
                                    </td>
                                </tr> --}}

                                <tr>
                                        <td class="signup-msg" valign="top" style="color:#363636;font-size:16px;font-weight:600;text-transform:uppercase;line-height:1.3;padding: 0 0 0 34px;">
                                            Welcome to Cannabis, to keep in touch with <span> 420 Kingdom</span> We are excited to have you get started. First, you need to confirm your account.
                                        </td>
                                         
                                    </tr>

                                    <tr>
                                        <td class="signup-msg" valign="top" style="    padding: 15px 0;
                                        color: #000;
                                        font-size: 14px;
                                        font-weight: 400;
                                        text-transform: uppercase;
                                        line-height: 1.3;
                                        padding: 17px 17px 17px 34px;">
                                      Your OTP is :  {{$token}}

                                        </td>
                                    </tr>
                                    

                                <tr>
                                    <td class="signup-msg" valign="top" style="    padding: 15px 0;
                                    color: #000;
                                    font-size: 14px;
                                    font-weight: 400;
                                    text-transform: uppercase;
                                    line-height: 1.3;
                                    padding: 17px 17px 17px 34px;">
                                        Kindly download the "420 Kingdom" mobile app from the Play/App store or from the links as given below. 
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" valign="top" style="text-align:center;padding-top:20px;padding-bottom:40px;" class="social">
                                        <a href="javascript:void(0)" style="display:inline-block;padding-right:5px;">
                                            <img src="{{asset('asset-store/images/appstore.png')}}" alt="App Store" />
                                        </a>
                                        <a href="javascript:void(0)" style="display:inline-block;">
                                            <img src="{{asset('asset-store/images/googleplay.png')}}" alt="Google Play" />
                                        </a>
                                    </td>
                                </tr>

                                {{-- <tr>
                                    <td class="signup-msg" valign="top" style="    padding: 15px 0;
                                    color: #000;
                                    font-size: 14px;
                                    font-weight: 400;
                                    text-transform: uppercase;
                                    line-height: 1.3;
                                    padding: 17px 17px 17px 34px;">
                                    Use this OAC during the "New User: Signup Process" to connect with your Panel. 
                                    </td>
                                </tr> --}}

                            </table>
                        </td>
                        
                    </tr>

                    <tr>
                        <td colspan="2" valign="top">
                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#fbfcff" style="padding-left:33px;padding-right:33px;" class="signup-detail">
                              

                                <tr>
                                    <td valign="top" style="color: #4c4f59; font-size: 14px; padding-bottom: 5px; line-height: 1.67;">
                                      Incase of any queries, feel free to contact us at <a href="mailto:support@cannabis.com">support@cannabis.com</a>  
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:.75pt .75pt .75pt .75pt">
                                       <p style="margin-right:0in;margin-bottom:0in;margin-left:0in;margin-bottom:.0001pt;line-height:13.5pt"><span style="    font-size: 12.0pt;
                                          font-weight: 600;">Warm Regards <br> Team 420 Kingdom</span></p>
                                    </td>
                                 </tr>

                                <tr>
                                    <td valign="top">
                                        <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="text-align:center;">

                                         

                                            <tr>
                                                <td align="center" valign="top" style="text-align:center;padding-bottom:20px;" class="social-links">
                                                    <a href="https://www.facebook.com/cannabis/" style="display:inline-block;padding-right:10px;">
                                                        <img src="{{asset('asset-store/images/facebook.png')}}" alt="Facebook" />
                                                    </a>
                                                    <a href="javascript:void(0)" style="display:inline-block;padding-right:10px;">
                                                        <img src="{{asset('asset-store/images/twitter.png')}}" alt="Twitter" />
                                                    </a>
                                                   
                                                    <a href="https://www.linkedin.com/company/cannabis" style="display:inline-block;padding-right:10px;">
                                                        <img src="{{asset('asset-store/images/linkedin-sign.png')}}" alt="Linkdin" />
                                                    </a>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="center" valign="top" style="text-align:center;font-size:11px;color:#4c4f59;">
                                                    Copyright © 2019 420 Kingdom. All rights reserved.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" valign="top" style="padding-top:5px;text-align:center;font-size:11px;color:#4c4f59;">
                                                <a href="{{route('users.home.page')}}" target="_blank">website: www.cannabis.com</a>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

    </table>

</body>

</html>