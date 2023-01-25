{{ $removeSpinner = '' }}
@extends('main.layouts.master')
@section('title', 'طلباتي')
@section('content')
    <section id="section" class="py-5">
        <div class="container-fluid">
            <div class="row">

                <!-- Include Aside -->
                @include('main.user.aside')


                @if (count($orders) > 0)
                    <div class="col-lg-9 col-md-8">
                        <h5 class="page-name">طلباتي</h5><!-- Page Name -->
                        <div class="row">

                            @foreach ($orders as $order)
                                <div id="order-{{ $order->id }}" class="col-lg-6 mb-4">
                                    <div class="box-white px-0">
                                        <h6 class="px-3 font-weight-bold">
                                            معلومات الطلب

                                            @if (time() + 3 * 24 * 60 * 60 > $order->created_at)
                                                <span class="badge badge-primary ">جديد</span>
                                                <div class="clearfix"></div>
                                            @endif
                                        </h6>
                                        <hr>

                                        <div class="px-3">

                                            <div class="mb-3">
                                                <span class="float-right text-secondary">حالة العمل</span>
                                                <span class="float-left">
                                                    @if ($order->status > 0)
                                                        <span class="badge badge-success float-left">مكتمل</span>
                                                    @else
                                                        @if ($order->working == 0)
                                                            <span class="badge badge-warning float-left">لم يتم البدء</span>
                                                        @else
                                                            <span class="badge badge-success float-left">قيد التنفيذ</span>
                                                        @endif
                                                    @endif

                                                </span>
                                                <div class="clearfix"></div>
                                            </div><!--  -->


                                            <div class="mb-3">
                                                <span class="float-right text-secondary">نوع الخدمة</span>
                                                <span class="float-left">{{ $order->service_type }}</span>
                                                <div class="clearfix"></div>
                                            </div><!-- service_type -->

                                            <div class="mb-3">
                                                <span class="float-right text-secondary">الموضوع</span>
                                                <span class="float-left">{{ $order->subject }}</span>
                                                <div class="clearfix"></div>
                                            </div><!-- subject -->


                                            <div class="mb-3">
                                                <span class="float-right text-secondary">المستوي الاكاديمي</span>
                                                <span class="float-left">{{ $order->academic }}</span>
                                                <div class="clearfix"></div>
                                            </div><!-- academic -->

                                            <div class="mb-3">
                                                <span class="float-right text-secondary">تنسيق الورق</span>
                                                <span class="float-left">{{ $order->parper_format }}</span>
                                                <div class="clearfix"></div>
                                            </div><!-- parper_format -->

                                            <div class="mb-3">
                                                <span class="float-right text-secondary">نوع الورق</span>
                                                <span class="float-left">{{ $order->parper_type }}</span>
                                                <div class="clearfix"></div>
                                            </div><!-- parper_type -->


                                            <div class="mb-3">
                                                <span class="float-right text-secondary">عدد الصفحات</span>
                                                <span class="float-left">{{ $order->number_of_pages }}</span>
                                                <div class="clearfix"></div>
                                            </div><!-- number_of_pages -->


                                            <div class="">
                                                <span class="float-right text-secondary">عدد المصادر</span>
                                                <span class="float-left">{{ $order->number_of_sources }}</span>
                                                <div class="clearfix"></div>
                                            </div><!-- number_of_sources -->




                                        </div>



                                        <hr>
                                        <h6 class="px-3 font-weight-bold">معلومات الدفع</h6>
                                        <hr>

                                        <div class="px-3">


                                            <div class="mb-3">
                                                <span class="float-right text-secondary">التكلفة</span>
                                                <span class="float-left">{{ $order->pay->amount }}<small
                                                        class="ml-1">{{ $order->pay->currency }}</small></span>
                                                <div class="clearfix"></div>
                                            </div><!-- currency amount -->

                                            <div class="mb-3">
                                                <span class="float-right text-secondary">حالة الدفع</span>
                                                <span class="float-left">
                                                    @if ($order->pay->process_data == 'APPROVED')
                                                        <span class=" text-success">عملية ناجحة</span>
                                                    @else
                                                        <span
                                                            class="text-danger">{{ $order->pay->process_data }}</span>
                                                    @endif
                                                </span>
                                                <div class="clearfix"></div>
                                            </div><!-- process_data -->

                                            <div class="mb-3">
                                                <span class="float-right text-secondary">الرقم التعريفي للمعاملة</span>
                                                <span class="float-left">{{ $order->pay->payment_id }}</span>
                                                <div class="clearfix"></div>
                                            </div><!-- payment_id -->

                                            <div class="mb-3">
                                                <span class="float-right text-secondary">تاريخ العملية</span>
                                                <span
                                                    class="float-left">{{ parseTime($order->pay->created_at) }}</span>
                                                <div class="clearfix"></div>
                                            </div><!-- created_at -->

                                        </div>

                                        @if (!empty($order->project))
                                            <div class=" px-3">
                                                <a href="{{ userUrl('projects#id-') . $order->project->id }}"
                                                    class="btn btn-outline-dark btn-sm btn-block">تفاصيل المشروع</a>
                                            </div>
                                        @endif



                                    </div>
                                </div>
                            @endforeach

                        </div><!-- Row -->
                    </div><!-- End Content -->
                @else
                    <div class="col-lg-8">
                        <div class="box-white text-center py-5">
                            <h5>لا توجد طلبات حتى الان !</h5>
                            <small class="d-block mb-3">سوف يتم اضافة اول مشروع عندما تقوم بشراء طلب جديد</small>
                            <a href="{{ url("order") }}" class=" btn-custom">اطلب الان</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
