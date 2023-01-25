@extends('admin.layouts.master')
@section('title', 'تفاصيل الطلب')
@section('content')


    <div class="links-bar">
        <a href="{{ admin_url('orders') }}">الطلبات</a>
        <a>تفاصيل الطلب</a>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <section>
        <div class="row justify-content-center">

            <div class="col-lg-6 mb-4">
                <div class="row">
                    <div class="col-12">
                        <div class="box-white  px-0 mb-3">


                            <h6 class="px-3 font-weight-bold">
                                معلومات الطلب

                                @if ($order->created_at + 3 * 24 * 60 * 60 > time())
                                    <span class="badge badge-primary ">جديد</span>
                                    <div class="clearfix"></div>
                                @endif
                            </h6>
                            <hr>


                            <div class="px-3">


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
                                    <span class="float-right text-secondary">بوابة الدفع</span>
                                    <span class="float-left">{{ $order->pay->source }}</span>
                                    <div class="clearfix"></div>
                                </div><!-- source -->


                                <div class="mb-3">
                                    <span class="float-right text-secondary">الحالة</span>
                                    <span class="float-left">
                                        @if ($order->pay->process_data == 'APPROVED')
                                            <span class=" text-success">عملية ناجحة</span>
                                        @else
                                            <span class="text-danger">{{ $order->pay->process_data }}</span>
                                        @endif
                                    </span>
                                    <div class="clearfix"></div>
                                </div><!-- process_data -->

                                <div class="mb-3">
                                    <span class="float-right text-secondary">الرقم التعريفي للمعاملة</span>
                                    <span class="float-left">{{ $order->pay->payment_id }}</span>
                                    <div class="clearfix"></div>
                                </div><!-- payment_id -->

                                <div class="">
                                    <span class="float-right text-secondary">تاريخ العملية</span>
                                    <span class="float-left">{{ parseTime($order->pay->created_at) }}</span>
                                    <div class="clearfix"></div>
                                </div><!-- created_at -->

                            </div>


                            <hr>
                            <h6 class="px-3 font-weight-bold">حالة الطلب</h6>
                            <hr>

                            <div class="px-3">

                                <div class="mb-3">
                                    <span class="float-right text-secondary">الطلب</span>
                                    <span class="float-left">
                                        @if ($order->status > 0)
                                            <span class="badge badge-primary float-left">مكتمل</span>
                                        @else
                                            <span class="badge badge-warning float-left">غير مكتمل</span>
                                        @endif
                                    </span>
                                    <div class="clearfix"></div>
                                </div><!--  -->

                                <div class="mb-3">
                                    <span class="float-right text-secondary">حالة العمل</span>

                                    @if ($order->status > 0)
                                        <span class="badge badge-success float-left">مكتمل</span>
                                    @else
                                        @if ($order->working > 0)
                                            <span class="badge badge-primary float-left">قيد التنفيذ</span>
                                        @else
                                            <span class="badge badge-warning float-left">لم يتم البدء</span>
                                        @endif
                                    @endif


                                    <div class="clearfix"></div>
                                </div><!--  -->


                                @if (empty($order->project))
                                    <div class="">
                                        <a href="{{ adminUrl("hire/order/$order->id/user/" . $order->user->id) }}"
                                            class="btn btn-primary btn-block btn-sm">وظف شخص</a>
                                    </div><!--  -->
                                @else
                                    <div class="mb-0">
                                        <span class="float-right text-secondary">المشروع</span>
                                        <span class="float-left">
                                            <a href="{{ adminUrl('project/show/' . $order->project->id) }}"><span
                                                    class="badge badge-light border float-left"><i
                                                        class="fa-solid fa-arrow-up-right-from-square"></i> تم فتح مشروع
                                                    للطلب</span></a>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div><!--  -->
                                @endif


                            </div>

                            <hr>
                            <h6 class="px-3 font-weight-bold">تفاصيل من العميل</h6>
                            <div class="px-3 mt-2">
                                @if ($order->details == null)
                                    لا يوجد
                                @else
                                    {{ $order->details }}
                                @endif
                                @if ($order->file != null)
                                    <a download class="badge badge-dark"
                                        href="{{ asset('assets/uploads/orders/' . $order->file) }}"><i
                                            class="fa-solid fa-download ml-1"></i> المرفقات</a>
                                @endif
                            </div>


                        </div><!-- Orders Details-->

                    </div>
                </div>
            </div><!-- Grid 1 -->

            <div class="col-lg-6">
                <div id="freelancers">
                    <div class="box-white table-responsive">
                        <h6 class=" font-weight-bold">صاحب الطلب</h6>
                        <div class="image">


                            @if ($order->user->image == null)
                                <img src="{{ asset('assets/images/defualt-avatar.png') }}">
                            @else
                                @if (checkFile('assets/uploads/user/' . $order->user->image))
                                    <img class="img-fluid"
                                        src="{{ asset('assets/uploads/user/' . $order->user->image) }}">
                                @else
                                    <img src="{{ asset('assets/images/defualt-avatar.png') }}">
                                @endif
                            @endif

                        </div><!-- image -->


                        <!-- Status -->
                        @if ($order->user->status == 1)
                            <span class="status badge font-weight-lighter badge-success pb-0 toast-title"
                                data-toggle="tooltip" data-placement="top" title="حالة الحساب">نشط </span>
                        @else
                            <span class="status badge font-weight-lighter badge-warning pb-0 toast-title"
                                data-toggle="tooltip" data-placement="top" title="حالة الحساب">غير نشط </span>
                        @endif
                        <!-- Status -->


                        <div class="info">
                            <a href="{{ adminUrl('users/show/' . $order->user->id) }}">
                                <h6 class="mt-2">
                                    {{ $order->user->name }}
                                </h6>
                            </a>
                            <h6 class=" text-secondary mb-0">{{ $order->user->email }}</h6>
                        </div><!-- info -->


                        <table class="table table-striped table-inverse table-bordered text-center mb-0 mt-3">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>الرقم التعريفي</th>
                                    <th>رقم الهاتف</th>
                                    <th>انضم في</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $order->user->id }}</td>
                                    <td>{{ $order->user->phone }}</td>
                                    <td>{{ $order->user->created_at }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div><!-- User Info -->

        </div>
    </section>


@endsection
