{{ $removeSpinner = '' }}
@extends('main.layouts.master')
@section('title', 'عملية شراء')
@section('content')
    <section id="section" class="py-5">
        <div class="container-fluid">
            <div class="row">

                <!-- Include Aside -->
                @include('main.user.aside')

                @if (session()->has('error'))
                    <div class="col-lg-9 col-md-8">
                        <div class="box-white">
                            <div class=" text-center">
                                <i class="fas fa-times-circle fa-4x text-danger"></i>
                                <h3 class="my-3">تمت رفض عملية الشراء</h3>
                                <span class=" text-muted">{{ session()->get('error') }}</span>
                            </div>

                        </div>
                    </div><!-- End Content -->
                @else
                    <div class="col-lg-9 col-md-8">
                        <div class="box-white">
                            <div class=" text-center">
                                <i class="fas fa-check-circle fa-4x text-success"></i>
                                <h3 class="my-3">تمت عملية الشراء بنجاح</h3>
                                <span class=" text-muted">المرحلة القادمة سوف يتم التواصل معك من خلال متخصص ليقوم باتمام
                                    كافة
                                    الطلب الخاص بك</span>

                            </div>

                        </div>
                    </div><!-- End Content -->
                @endif



            </div>
        </div>
    </section>
@endsection
