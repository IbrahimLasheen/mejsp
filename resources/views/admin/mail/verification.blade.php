<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
    <style>
        @media (max-width:501px) {
            .col {
                width: 270px;
            }
        }

    </style>
</head>

<body
    style="margin: 0px; padding: 0px; box-sizing: border-box; background-color: #f7f7f7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; direction: ltr; text-align: left;">

    <div class="container" style="padding-top: 50px; width: 100%; height: 70vh; padding: 15px;">
        <div class="col"
            style="background-color: #fff; padding: 20px; padding-top: 8px; padding-bottom: 30px; width: 400px; margin: 50px auto;">
            <h2>Email Verification</h2>
            <a href="{{ $info['link'] }}"
                style="background-color: #09c; color: #fff; text-decoration: none; padding: 10px; border-radius: 4px; display: block; text-align: center;">Verify
                My Account</a>
            <h5 style="color: rgb(129, 129, 129); font-weight: 400; margin-bottom: 30px; margin-top: 0px;">Click on the
                link to activate your account</h5>

        </div>
    </div>

</body>

</html>
