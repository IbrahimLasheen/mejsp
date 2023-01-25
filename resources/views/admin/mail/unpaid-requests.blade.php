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
                            <div style="text-align: center;"> <img
                                    src="https://search-academy.com/assets/images/logo.png" alt=""> </div>
                            <h2 style="color:#212121">مرحبا {{ $data['name'] }}</h2>
                            <p style="color:#8c8c8c;font-size:17px">هذه رسالة تنبيه ، لقد طلبت خدمة جديدة وحتى الآن لم
                                تدفع فاتورة هذا الطلب ، حتى نتمكن من بدء انشاء طلبك ، يجب عليك أولاً دفع الفاتورة الخاصة
                                به.</p>
                            <h6 style=" font-weight: 600; font-size: 18px; margin: 10px 0px;color:#212121;"> معلومات
                                الطلب </h6>
                            <div style="margin-bottom: 10px;" class="mb-3"> <span style="float: right;">نوع
                                    الخدمة</span> <span style="float:left;">{{ $data['service_type'] }}</span>
                                <div style="clear: both;"></div>
                            </div>
                            <div style="margin-bottom: 10px;" class="mb-3"> <span
                                    style="float: right;">الموضوع</span> <span
                                    style="float:left;">{{ $data['subject'] }}</span>
                                <div style="clear: both;"></div>
                            </div>
                            <div style="margin-bottom: 10px;" class="mb-3"> <span style="float: right;">المستوي
                                    الاكاديمي</span> <span style="float:left;">{{ $data['academic'] }}</span>
                                <div style="clear: both;"></div>
                            </div>
                            <div style="margin-bottom: 10px;" class="mb-3"> <span style="float: right;">تنسيق
                                    الورق</span> <span style="float:left;">{{ $data['parper_format'] }}</span>
                                <div style="clear: both;"></div>
                            </div>
                            <div style="margin-bottom: 10px;" class="mb-3"> <span style="float: right;">نوع
                                    الورق</span> <span style="float:left;">{{ $data['parper_type'] }}</span>
                                <div style="clear: both;"></div>
                            </div>
                            <div style="margin-bottom: 10px;" class="mb-3"> <span style="float: right;">عدد
                                    الصفحات</span> <span style="float:left;">{{ $data['number_of_pages'] }}</span>
                                <div style="clear: both;"></div>
                            </div>
                            <div style="margin-bottom: 10px;" class="mb-3"> <span style="float: right;">عدد
                                    المصادر</span> <span style="float:left;">{{ $data['number_of_sources'] }}</span>
                                <div style="clear: both;"></div>
                            </div><a href="{{ $data['checkout_url'] }}"
                                style="text-decoration: none; background-color: #2c667e;color: #fff; padding: 10px 10px; display: block; text-align: center; border-radius: 3px;">ادفع
                                الان</a>
                            <h3>خطوات الدفع يدويا</h3>
                            <ul style="direction: rtl;">
                                <li>قم بتسجيل الدخول في المنصة <a href="https://search-academy.com/login">تسجيل</a></li>
                                <li>اضغط علي <a href="https://search-academy.com/u/my-orders">طلباتي</a> من خلال لوحه
                                    التحكم الخاصة بك</li>
                                <li>قم بالدخول علي الطلب الغير مدفوع للسداد</li>
                            </ul>
                            <h6
                                style="font-weight: 200; color: #646464; margin-top: 15px;margin-bottom: 5px; font-size: 14px;">
                                لا تتردد في التواصل معنا إذا كان لديك أي استفسارات، أو احتجت إلى مساعدة.</h6> <a
                                href="https://search-academy.com"
                                style="text-decoration: none; color: blue;">search-academy.com</a>
                        </div>
                    </tbody>
                </table>
            </td>
            <td bgcolor="#EBEBEB" style="font-size:0px">&zwnj;</td>
        </tr>
    </table>
</body>

</html>
