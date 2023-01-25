<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}" />
    @yield('css')
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/global.css') }}" />
    <title>تسجيل دخول المشرف</title>
</head>

<body>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @if (session()->has("auth_error_message"))
                    <div class="alert alert-danger text-center">{{ session()->get("auth_error_message") }}</div>
                @endif
                <div class="  rounded p-4 bg-white">
                    <form action="{{ adminUrl("login") }}" method="post">


                        <div class="form-group text-right">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control text-right" value="{{ old("email") }}">
                        </div>
                        @csrf

                        <div class="form-group text-right">
                            <label>كلمه السر</label>
                            <input type="password" name="password" class="form-control text-right">
                        </div>

                        <button type="submit" class="btn-main btn-block">تسجيل الدخول</button>

                    </form>
                </div>
                <div class=" text-right mt-3">
                    <a href="{{ adminUrl("forget-password") }}">هل نسيت كلمة السر ؟</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
