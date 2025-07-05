<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Welcome to Bhutan Echoes</title>    <!-- CSS Reset -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
    <style>
        html, body {
            font-family: 'Roboto', sans-serif;
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        .tel {
            font-size: 26px;
            font-weight: 700;
            color: #777777;
            line-height: 20px;
            padding: 0px;
            margin: 4px 0;
        }

        ul {
            margin: 0px;
            padding: 0px;
        }

        ul li {
            display: inline-block;
            padding-left: 10px;
        }

        table, td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        table table table {
            table-layout: auto;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        h1 {
            color: #f75d00;
            font-size: 28px;
            padding: 0px;
            margin: 0px;
            line-height: 50px;
            font-weight: 400;
        }

        /* Media Queries */
        @media screen and (max-width: 480px) {
            .fluid {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            .stack-column, .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }

            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }

            table.center-on-narrow {
                display: inline-block !important;
            }

            /* What it does: Adjust typography on small screens to improve readability */
            .email-container p {
                font-size: 17px !important;
                line-height: 22px !important;
            }
        }
    </style>
</head>
<body width="100%" bgcolor="#fff" style="margin: 0; mso-line-height-rule: exactly;">
<center style="width: 100%; background: #efefef; text-align: left;">
    <div style="max-width: 600px; margin: auto;" class="email-container">
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center"
               width="100%" style="max-width: 680px;">
            <tr>
                <td style="padding:25px 0; text-align: center; background-color:#07253f; border-bottom:1px solid #fff;">
                    <img src="{{ asset('assets/dist/img/buzz.png') }}" height="100px" alt="logo"/></td>
            </tr>
            <tr>
                <td style="padding:3px 0; text-align: center; background-color:#f75d00; border-bottom:1px solid #fff;"></td>
            </tr>
        </table>
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center"
               width="100%" style="max-width: 600px;" bgcolor="#ffffff" class="email-container">
            <tr>
                <td bgcolor="#ffffff" style="text-align:center; padding: 40px 40px 20px; ">
                    <h1>Dear {{ $name }},</h1>
                    <span style="font-size:20px; display:block; line-height:40px;">Welcome to Bhutan Echoes</span>
                    <hr style="border-bottom: 1px; border-style:solid; width:250px;  border-color:#e4e4e4"/>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; padding:5px 0px 40px 0;"><span style="font-size:20px;">Thank you for registering your account.<br/> You can log-in to your account with following details:</span>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ebebeb">
                    <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0"
                           width="100%">
                        <tr>
                            <td style="padding:20px 40px 20px; text-align: center;">
                                <h1 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 27px; color: #f75d00; font-weight: normal;">
                                    Email/Username:</h1>
                                <div style="margin:15px 0px 0px 0px;">{{$email}}</div>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
           
                <tr>
                    <td style="text-align:center; padding:25px 0px 10px 0;"><span style="font-size:20px;">Please Verify Your Email Before Login By Clicking Below Link :-</span>
                        <div style="text-align:center; padding:25px 0px 40px 0;font-family: sans-serif; font-size: 24px; line-height: 27px; color: #f75d00; font-weight: normal;">
                            <a href="{{ $verificationLink }}"
                    style="font-family:Arial; border-radius:17px; font-size:15px; font-weight:500; color:#FFF; display:inline-block; padding:7px 12px; background:#598200; text-decoration:none;">
                    Verify Email !!
                </a></div>
                    </td>
                </tr>
          
            <tr>
                <td style="padding:0px 40px 20px; text-align: center;">
                    <span style="font-size:20px;">If you have any question about your account or any help,<br/> please contact us at<br/>
                        <a style="font-size:16px;"
                           href="mailto:support@amplepoints.com">support@bhutanechoes.com</a> </span>
                </td>
            </tr>
            <tr>
                <td style="padding:0px 10px 0 10px; text-align: center;">
                    <hr style="border-bottom: 1px; border-style:solid;  border-color:#e4e4e4"/>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding:20px 20px;">
                    <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0"
                           width="100%" style="font-size: 14px;text-align: left;">
                        <tr>
                            <td><b>Sincerely,</b><br/> Bhutan Echoes Support Team!</td>
                            {{-- <td style="text-align:right;" class="stack-column">
                                <div><p class="tel">702 799 9321</p></div>
                                <ul>
                                    <li style="display: inline-block;padding-left: 10px;"><a
                                                href="https://www.facebook.com/AmplePoints-1954178721495977/"><img
                                                    src="https://amplepoints.com/emailtemplate/latestimg/f-icon.png"
                                                    alt="f-icon"/> </a></li>
                                    <li style="display: inline-block;padding-left: 10px;"><a
                                                href="https://twitter.com/amplepoints_"><img
                                                    src="https://amplepoints.com/emailtemplate/latestimg/t-icon.png"
                                                    alt="t-icon"/> </a></li>
                                    <li style="display: inline-block;padding-left: 10px;"><a
                                                href="https://in.pinterest.com/amplepoints/"><img
                                                    src="https://amplepoints.com/emailtemplate/latestimg/p-icon.png"
                                                    alt="f-icon"/> </a></li>
                                    <li style="display: inline-block;padding-left: 10px;"><a
                                                href="https://www.instagram.com/amplepoints/"><img
                                                    src="https://amplepoints.com/emailtemplate/latestimg/ins-icon.png"
                                                    alt="f-icon"/> </a></li>
                                </ul>
                            </td> --}}
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center"
               width="100%" style="max-width: 680px;">
            <tr>
                <td style="padding:2px 0; text-align: center; background-color:#f75d00; border-bottom:1px solid #fff;"></td>
            </tr>
            <tr>
                <td style="padding:7px 0; text-align: center; background-color:#07253f; border-bottom:1px solid #fff;"></td>
            </tr>
        </table>
    </div>
</center>
</body>
</html>