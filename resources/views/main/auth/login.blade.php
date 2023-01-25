@extends('main.layouts.master')
@section('title', 'تسجيل الدخول')
@section('type', 'login')
@section('url', urldecode(Request::url()))

@section('content')
    <!--Login-->
    <section id="login" class=" my-5 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class=" box-white">
                        <div class="section-title mb-4">
                            <h4>تسجيل الدخول</h4>
                        </div>
                        @if (session()->has('auth_error_message'))
                            <div class="alert alert-danger text-center">{{ session()->get('auth_error_message') }}</div>
                        @endif
                        <form action="{{ url('login/check') }}" class="sign-form widget-form " method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="البريد" name="email"
                                    value="@if (session()->has('email')) {{ session()->get('email') }} @endif" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="كلمة السر" name="password" />
                            </div>
                            <div class="sign-controls form-group">
                                <a href="{{ url('forget-password') }}" class=" text-secondary"><small> نسيت كلمة
                                        السر؟</small></a>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn-main btn-block">تسجيل الدخول</button>
                            </div>

                            <p class="form-group text-center"> ليس لديك حساب ؟
                                <a href="{{ url('register') }}" class="btn-link">انشئ واحد</a>
                            </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
