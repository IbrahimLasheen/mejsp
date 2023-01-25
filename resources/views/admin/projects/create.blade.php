@extends('admin.layouts.master')
@section('title', 'انشاء مشروع')
@section('content')

    @if (empty($projectRow))
        <div class="links-bar">
            <h4>انشاء مشروع</h4>
        </div><!-- End Bar Links -->
    @endif
    <div class="result mb-3"></div>

    <section id="create-project">
        <div class="row justify-content-center">

            @if (empty($projectRow))


                <div class="col-lg-4 mb-4">
                    <div class="box-white px-0">
                        <h6 class="px-3">تحضير المشروع</h6>
                        <hr>
                        <form id="form-add-project" action="{{ adminUrl('project/store') }}" method="POST"
                            class="px-3 form" enctype="multipart/form-data">

                            <div class="">
                                <input type="hidden" name="user_id"
                                    value="{{ Crypt::encryptString(Request::segment(7)) }}">
                                <input type="hidden" name="order_id"
                                    value="{{ Crypt::encryptString(Request::segment(5)) }}">
                                <input type="hidden" name="freelancer_id"
                                    value="{{ Crypt::encryptString(Request::segment(9)) }}">
                                @csrf
                            </div><!-- ID -->

                            <div class="form-group">
                                <label class="required">سعر المشروع ( بالدولار )</label>
                                <input type="number" step="any" name="price" class="form-control" required>
                                <small class="text-muted">هذا السعر الذي سوف يتقاضاة الموظف بعد اكمال المشروع</small>
                            </div>

                            <div class="form-group">
                                <label class="required">مدة المشروع ( باليوم )</label>
                                <input type="number" name="duration" class="form-control" required>
                                <small class="text-muted">هذه المدة التي سوف يتم فيها تسليم المشروع</small>
                            </div>

                            <div class="form-group">
                                <label>ملاحظات ( اختياري )</label>
                                <textarea name="details" cols="30" rows="8" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn-main btn-block">بدء المشروع</button>

                        </form>
                    </div>
                </div><!-- Grid 1 قم بتنسيق المشروع حتا يبدء الموظف بالعمل عليه -->

                <div class="col-lg-4 mb-4">
                    <div id="freelancers">

                        <div class="box-white table-responsive mb-4">
                            <h5 class=" float-right font-weight-bold">الكاتب</h5>
                            <div class="clearfix"></div>
                            <div class="image">


                                @if ($row->image == null)
                                    <img src="{{ asset('assets/images/defualt-avatar.png') }}">
                                @else
                                    @if (checkFile('assets/uploads/user/' . $row->image))
                                        <img class="img-fluid"
                                            src="{{ asset('assets/uploads/user/' . $row->image) }}">
                                    @else
                                        <img src="{{ asset('assets/images/defualt-avatar.png') }}">
                                    @endif
                                @endif

                            </div><!-- image -->

                            <!-- Status -->
                            @if ($row->status == 1)
                                <span class="status badge font-weight-lighter badge-success pb-0 toast-title"
                                    data-toggle="tooltip" data-placement="top" title="حالة الحساب">نشط </span>
                            @else
                                <span class="status badge font-weight-lighter badge-warning pb-0 toast-title"
                                    data-toggle="tooltip" data-placement="top" title="حالة الحساب">غير نشط </span>
                            @endif
                            <!-- Status -->

                            <div class="info">
                                <a href="#">
                                    <h6 class="mt-2">
                                        <a>{{ $row->name }}</a>
                                        @if ($row->email_verification > 0)
                                            <span class="toast-title text-success" data-toggle="tooltip"
                                                data-placement="top" title="البريد موثق">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </span><!-- Email Veric.... -->
                                        @endif
                                    </h6>
                                </a>
                                <h6 class=" text-secondary mb-0">{{ $row->email }}</h6>
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
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->phone }}</td>
                                        <td>{{ $row->created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>



                        <div class="box-white table-responsive">
                            <h5 class=" float-right font-weight-bold">العميل</h5>
                            <div class="clearfix"></div>
                            <div class="image">


                                @if ($user->image == null)
                                    <img src="{{ asset('assets/images/defualt-avatar.png') }}">
                                @else
                                    @if (checkFile('assets/uploads/user/' . $user->image))
                                        <img class="img-fluid"
                                            src="{{ asset('assets/uploads/user/' . $user->image) }}">
                                    @else
                                        <img src="{{ asset('assets/images/defualt-avatar.png') }}">
                                    @endif
                                @endif

                            </div><!-- image -->

                            <!-- Status -->
                            @if ($user->status == 1)
                                <span class="status badge font-weight-lighter badge-success pb-0 toast-title"
                                    data-toggle="tooltip" data-placement="top" title="حالة الحساب">نشط </span>
                            @else
                                <span class="status badge font-weight-lighter badge-warning pb-0 toast-title"
                                    data-toggle="tooltip" data-placement="top" title="حالة الحساب">غير نشط </span>
                            @endif
                            <!-- Status -->

                            <div class="info">
                                <a href="#">
                                    <h6 class="mt-2">
                                        <a>{{ $user->name }}</a>
                                        @if ($user->email_verification > 0)
                                            <span class="toast-title text-success" data-toggle="tooltip"
                                                data-placement="top" title="البريد موثق">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </span><!-- Email Veric.... -->
                                        @endif
                                    </h6>
                                </a>
                                <h6 class=" text-secondary mb-0">{{ $user->email }}</h6>
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
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div><!-- Grid 2 -->

                <div class="col-lg-4 mb-4">


                    <div class="box-white mb-4 px-0">


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


                    </div><!-- Orders Details-->

                </div><!-- Grid 3 -->
            @else
                <div class="col-12">
                    <div class=" py-5 box-white text-center w-100">
                        <h5 class="mb-2 text-center">تم بدء مشروع لذلك الطلب من قبل , يمكنك زيارة المشروع من الرابط التالي
                        </h5>
                        <a href="{{ adminUrl('project/show/' . $projectRow->id) }}"
                            class="mb-0 mt-3 btn btn-primary">زيارة المشروع</a>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
