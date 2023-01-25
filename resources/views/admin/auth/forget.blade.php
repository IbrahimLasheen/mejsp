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
    <title>تغير كلمة السر</title>
</head>

<body>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                @if (session()->has('error'))
                    <div class="alert alert-danger text-center">{{ session()->get('error') }}</div>
                @endif
                
                @if (session()->has('message'))
                    <div class="alert alert-success text-center">{{ session()->get('message') }}</div>
                @endif

                @error('email')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
                <div class=" shadow rounded p-4 bg-white">
                    <form action="{{ admin_url('send-mail') }}" method="post">

                        <div class="form-group text-right">
                            <input type="email" name="email" class="form-control text-right" value="{{ old('email') }}"
                                placeholder="البريد الإلكتروني">

                        </div>
                        @csrf

                        <button type="submit" class=" btn btn-success btn-block">التحقق من البريد</button>

                    </form>
                </div>
                <div class=" text-right mt-3">
                    <a href="{{ admin_url('') }}">تسجيل الدخول ؟</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
