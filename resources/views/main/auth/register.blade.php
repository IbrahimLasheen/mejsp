@extends('main.layouts.master')
@section('title', 'تسجيل حساب')
@section('type', 'login')
@section('url', urldecode(Request::url()))

@section('content')
    <!--Login-->
    <section id="login" class="my-3 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="box-white">
                        <div class="section-title mb-4">
                            <h5>تسجيل حساب</h5>
                        </div>
                        <form id="form-register" action="{{ url('register/create') }}" class="sign-form widget-form "
                            method="POST">

                            @csrf

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="الاسم" name="name"
                                    value="{{ old('name') }}" required />
                                @error('name')
                                    <div class="alert-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="البريد الالكتروني" name="email"
                                    value="{{ old('email') }}" required />
                                @error('email')
                                    <div class="alert-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="رقم الهاتف" name="phone"
                                    value="{{ old('phone') }}" required />
                                @error('phone')
                                    <div class="alert-error">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="كلمة السر" name="password"
                                    required />
                                @error('password')
                                    <div class="alert-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn-main btn-block">تسجيل الدخول</button>
                            </div>

                            <p class="form-group text-center"> لديك حساب ؟
                                <a href="{{ url('login') }}" class="btn-link">سجل دخول</a>
                            </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
