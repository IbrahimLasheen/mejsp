{{ $removeSpinner = '' }}
@extends('main.layouts.master')
@section('title', 'المشاريع')
@section('content')
    <section id="section" class="py-5">
        <div class="container-fluid">
            <div class="row">

                <!-- Include Aside -->
                @include('main.user.aside')

                @if (count($projects) > 0)
                    <div class="col-lg-9 col-md-8">
                        <h5 class="page-name">المشاريع</h5><!-- Page Name -->
                        <div class="row">

                            @foreach ($projects as $row)
                                <div id="id-{{ $row->id }}" class="col-lg-6 mb-5">
                                    <div class="box-white px-0">
                                        <h6 class="px-3 font-weight-bold">تفاصيل المشروع</h6>
                                        <hr>


                                        <div class=" px-3 mb-3">
                                            <span class="float-right text-secondary">حالة المشروع</span>

                                            @if ($row->order->status > 0)
                                                <span class="float-left badge badge-success">مكتمل</span>
                                            @else
                                                <span class="float-left badge badge-warning">غير مكتمل</span>
                                            @endif

                                            <div class="clearfix"></div>
                                        </div>

                                        <div class=" px-3 mb-3">
                                            <span class="float-right text-secondary">منفذ الخدمة</span>
                                            <span class="float-left text-secondary">
                                                <a class="text-primary"
                                                    href="{{ userUrl('messages/' . $row->freelancer->id) }}">{{ $row->freelancer->name }}</a>
                                            </span>
                                            <div class="clearfix"></div>
                                        </div>


                                        <div class=" px-3 mb-3">
                                            <span class="float-right text-secondary">مدة التسليم</span>
                                            <span class="float-left">{{ $row->duration }} يوم</span>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class=" px-3 mb-3">
                                            <span class="float-right text-secondary">بدء العمل</span>
                                            <span class="float-left">{{ parseTime($row->created_at) }}</span>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class=" px-3 mb-3">
                                            <span class="float-right text-secondary">موعد التسليم</span>
                                            <span class="float-left">{{ date('Y-m-d', $row->duration_date) }}</span>
                                            <div class="clearfix"></div>
                                        </div>


                                        <div class=" px-3">
                                            <a href="{{ userUrl('my-orders#order-') . $row->order->id }}"
                                                class="btn btn-outline-dark btn-sm btn-block">تفاصيل الطلب</a>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        </div><!-- Row -->
                    </div><!-- End Content -->
                @else
                    <div class="col-lg-8">
                        <div class="box-white text-center py-5">
                            <h5>لا توجد مشاريع حتى الان !</h5>
                            <small>سوف يتم عرض المشاريع الخاصة بك عندما يتم توظيف شخص لطلباتك</small>
                        </div>
                    </div>
                @endif
                
            </div>
        </div>
    </section>
@endsection
