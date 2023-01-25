<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notifications</title>
    <style>
        @media (max-width:501px) {
            .col {
                width: 270px;
            }
        }

    </style>
</head>

<body
    style="margin: 0px; padding: 10px; box-sizing: border-box; background-color: #f7f7f7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; direction: ltr; text-align: left;">

    <div class="container" style="padding-top: 50px; width: 100%; height: 70vh; padding: 15px;">
        <div class="col"
            style="background-color: #fff; padding: 0px; padding-top: 8px; padding-bottom: 30px; width: 400px; margin: 50px auto; text-align:center !important;">
            <h3>{{ $info['message'] }}</h3>
            <a href="{{ url('') }}">{{ env('MAIL_FROM_NAME') }}</a>
        </div>
    </div>

</body>

</html>
