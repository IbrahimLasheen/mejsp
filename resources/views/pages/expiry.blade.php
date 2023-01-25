@extends('main.layouts.master')
@section('title', 'صفحة منتهية')
@section('content')
    <div class="container py-5 my-5">
        <div class="row">
            <div class="col-12">
                <div class="box-white py-5 text-center">
                    <h2 class=" text-center mb-3">هذه الصفحة قد انتهت صلاحيتها</h2>
                    <a href="{{ url("") }}">الصفحة الرئيسية</a>
                </div>
            </div>
        </div>
    </div>
@endsection
