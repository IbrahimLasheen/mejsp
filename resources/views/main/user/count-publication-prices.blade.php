@php
$removeSpinner='';
@endphp
@extends('main.layouts.master') @section('title', 'حساب رسوم النشر') @section('content') <section id="section" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <h5 class="page-name">حساب رسوم النشر</h5>
            </div>@include('main.user.aside') <div class="col-lg-9 col-md-8">
                <div class="box-white p-3">
                    <div class="result"></div>@if (session()->has('successMsg')) <div
                        class=" alert alert-success text-center">{{session()->get('successMsg')}}</div>@endif 
                        <form
                        id="form-freelancer-settings" action="{{ route('countPublicationPrices') }}" method="POST"> 
                        @if(Session::has('message'))
                         <p class="alert alert-info font-weight-bold">{{ Session::get('message') }}</p>
                        @endif
                        @csrf <div
                            class="form-group"> <label class="required">اختر المجلة</label>
                            <select class="form-control" name="journal_id">
                                <option value="">
                                    اختر مجلة
                                </option> 
                                @foreach($jour as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }} 
                                </option>
                                @endforeach
                            </select>
                            @error('journal_id') <div class="alert-error">{{$message}}</div>@enderror </div>
                        <div class="form-group"> <label class="required">عدد الصفحات</label> <input type="number"
                                class="form-control" name="default_page_count"
                                value="{{ isset($default_page_count) ? $default_page_count : '' }}" placeholder="اكتب عدد صفحات دراستك" required /> @error('default_page_count')
                            <div class="alert-error">{{$message}}</div>@enderror </div>
 
                        <div class="form-group mb-0"> <button type="submit" class="btn-main">حساب</button> </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> @endsection