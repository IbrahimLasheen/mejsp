@extends('main.layouts.master')
@section('title', 'صفحة غير موجودة')
@section('content')
    <div class="container py-5 my-5">
        <div class="row">
            <div class="col-12">
                <div class="box-white py-5 text-center">
                    <img width="70px" src="{{ asset("assets/images/notfound-sad.png") }}" alt="">
                    <h2 class=" text-center mb-3 mt-3">هذه الصفحة غير موجودة</h2>
                    <a href="{{ url("") }}">الصفحة الرئيسية</a>
                </div>
            </div>
        </div>
    </div>
@endsection
