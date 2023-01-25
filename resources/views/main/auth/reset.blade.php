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
    <title>إعادة تعين كلمة السر</title>
</head>

<body>


    <div class="container mt-5">


        <div class="row justify-content-center">
            <div class="col-md-4">

                @if (session()->has('error'))
                    <div class="alert alert-danger text-center">{{ session()->get('error') }}</div>
                @endif
                <div class=" shadow rounded p-4 bg-white">
                    <form action="{{ url('update-password/' . request()->segment(2)) }}" method="post">


                        <div class="form-group text-right">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control text-right" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="alert-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-right">
                            <label>الكود</label>
                            <input type="number" name="code" class="form-control text-right" value="{{ old('code') }}" required>
                            @error('code')
                                <div class="alert-error">{{ $message }}</div>
                            @enderror
                        </div>

                        @csrf

                        <div class="form-group text-right">
                            <label>كلمه السر الجديدة</label>
                            <input type="password" name="password" class="form-control text-right" required>
                            @error('password')
                                <div class="alert-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class=" btn btn-success btn-block">حفظ البيانات</button>

                    </form>
                </div>
                <div class=" text-right mt-3">
                    <a href="{{ url('login') }}">تسجيل الدخول ؟</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
