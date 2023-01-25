<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Email Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Cairo&display=swap');

        #outlook a {
            padding: 0;
        }

        .ExternalClass {
            width: 100% !important;
        }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        img {
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        a img {
            border: none;
        }

        .appleLinksGrey a {
            color: #919191 !important;
            text-decoration: none !important;
        }

        .ExternalClass img[class^=Emoji] {
            width: 10px !important;
            height: 10px !important;
            display: inline !important;
        }

        .CTA:hover {
            background-color: #5FDBC4 !important;
        }

        @media screen and (max-width:640px) {
            .mobilefullwidth {
                width: 100% !important;
                height: auto !important;
            }

            .logo {
                padding-left: 30px !important;
                padding-right: 30px !important;
            }

            .h1 {
                font-size: 36px !important;
                line-height: 48px !important;
                padding-right: 30px !important;
                padding-left: 30px !important;
                padding-top: 30px !important;
            }

            .h2 {
                font-size: 18px !important;
                line-height: 27px !important;
                padding-right: 30px !important;
                padding-left: 30px !important;
            }

            .p {
                font-size: 16px !important;
                line-height: 28px !important;
                padding-left: 30px !important;
                padding-right: 30px !important;
                padding-bottom: 30px !important;
            }

            .CTA_wrap {
                padding-left: 30px !important;
                padding-right: 30px !important;
                padding-bottom: 30px !important;
            }

            .footer {
                padding-left: 30px !important;
                padding-right: 30px !important;
            }

            .number_wrap {
                padding-left: 30px !important;
                padding-right: 30px !important;
            }

            .unsubscribe {
                padding-left: 30px !important;
                padding-right: 30px !important;
            }
        }

    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body
    style="padding:0; margin:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:100%; background-color:#e8e8e8; font-family: 'Cairo', sans-serif; font-size:16px; line-height:24px; color:#919191">
    <table style="padding-top: 20px; padding-bottom:20px;" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td bgcolor="#EBEBEB" style="font-size:0px">&zwnj;</td>
            <td align="center" width="600" bgcolor="#FFFFFF" style="border-radius: 5px">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <div style="text-align:right; padding:20px ;font-family: 'Cairo', sans-serif;">
                            <div style="text-align: center;"> <img src="{{ env('APP_URL') . env('APP_LOGO') }}"
                                    alt=""> </div>
                            <h2 style="color:#212121">{{ $info['mail_title'] }}    </h2>
                            
                             <p>{{ $info['mail_details1'] }} </p>
                             
                               
                                    <a href="{{ $info['link_facture'] }}" style="margin-top:10px;background-color: #09c; color: #fff; text-decoration: none; padding: 10px; border-radius: 4px; display: block; text-align: center;">سداد رسوم النشر </a>

                        </div>
                    </tbody>
                </table>
            </td>
            <td bgcolor="#EBEBEB" style="font-size:0px">&zwnj;</td>
        </tr>
    </table>
</body>

</html>
