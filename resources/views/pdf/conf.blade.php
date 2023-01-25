<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ env('APP_NAME') }} - Certificate</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>

        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        #header {
            background-image: url("assets/images/Conference-Certificate-1.jpg");
            height: 100%;
            width: 100%;
            background-position: center center;
            background-size: 100%;
        }

     

        h1 {
            width: 100%;
            text-align: center;
            padding-top: 26.3rem;
            color: #1b1b1b;
            font-size: 27px;
            font-weight: 500;
        }

        img {
            height: 100%;
            width: 100%;
        }

    </style>
</head>

<body>
    <div id="header">
        <h1>{{$name }}</h1>
    </div>


</body>

</html>
