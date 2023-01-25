<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Password</title>
    <style>
@media (max-width:501px) {
  .col {
    width: 270px;
  }
}
</style>
</head>

<body style="margin: 0px; padding: 0px; box-sizing: border-box; background-color: #f7f7f7; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; direction: ltr; text-align: left;">

    <div class="container" style="padding-top: 50px; width: 100%; height: 70vh; padding: 15px;">
        <div class="col" style="background-color: #fff; padding: 20px; padding-top: 8px; padding-bottom: 30px; width: 400px; margin: 50px auto;">
            <h2>Forget Password</h2>
            <h4 style="font-weight: 700; margin-bottom: 15px; color: #09c;"><span style="font-weight: 200; color: #000;">Code :</span>  {{ $info['code'] }}</h4>
            <h5 style="color: rgb(129, 129, 129); font-weight: 400; margin-bottom: 30px; margin-top: 0px;">Copy the code to be able to update the password change completion</h5>
            <a href="{{ $info['link'] }}" style="background-color: #09c; color: #fff; text-decoration: none; padding: 10px; border-radius: 4px; display: block; text-align: center;">Reset Link</a>
        </div>
    </div>

</body>

</html>
