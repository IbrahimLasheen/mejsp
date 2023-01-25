@extends('admin.layouts.master')
@section('title', 'ملف الكاتب الشخصي')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('freelancers') }}">الكاتبون</a>
        <a href="{{ admin_url('freelancer/show/' . $row->id) }}">{{ $row->name }}</a>
    </div><!-- End Bar Links -->

    @if (session()->has('success'))
        <div class="alert  box-success alert-dismissible fade show mb-3" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">

        <div class="col-lg-4 ">
            <div class="row">

                <div id="freelancers" class="col-12">

                    <div class="box-white">
                        <div class="image">


                            @if ($row->image == null)
                                <img src="{{ asset('assets/images/defualt-avatar.png') }}">
                            @else
                                @if (checkFile('assets/uploads/freelancer/' . $row->image))
                                    <img class="img-fluid"
                                        src="{{ asset('assets/uploads/freelancer/' . $row->image) }}">
                                @else
                                    <img src="{{ asset('assets/images/defualt-avatar.png') }}">
                                @endif
                            @endif

                        </div><!-- image -->

                        <div class="controls">
                            <a href="{{ adminUrl('freelancer/show/' . $row->id) }}"><i
                                    class="fas fa-external-link-alt"></i></a>
                        </div><!-- Controls -->


                        <div class="send-message toast-title" data-id="{{ $row->id }}" data-toggle="tooltip"
                            data-placement="top" title="ارسال رسالة">
                            <button type="button" data-toggle="modal" data-target="#send-message-modal"><i
                                    class="far fa-envelope"></i></button>
                        </div><!-- Send Message -->


                        <!-- Status -->
                        @if ($row->status == 1)
                            <span class="status badge font-weight-lighter badge-success pb-0 toast-title"
                                data-toggle="tooltip" data-placement="top" title="حالة الحساب">نشط </span>
                        @else
                            <span class="status badge font-weight-lighter badge-warning pb-0 toast-title"
                                data-toggle="tooltip" data-placement="top" title="حالة الحساب">غير نشط </span>
                        @endif
                        <!-- Status -->

                        <span class="wallet badge font-weight-lighter badge-dark pb-0 toast-title" data-toggle="tooltip"
                            data-placement="top" title="رصيد الحساب">${{ $row->balance }}
                        </span><!-- Wallet -->


                        <div class="info">
                            <a href="#">
                                <h6 class="mt-2 text-dark"><a>{{ $row->name }}</a>
                                    @if ($row->email_verification > 0)
                                        <span class="toast-title text-success" data-toggle="tooltip" data-placement="top"
                                            title="البريد موثق">
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

                </div>

                <div class="col-12 my-4">

                    <div class="box-white">
                        <h5 class="mb-3">التحكم</h5>
                        <div class="row">
                            <div class="col">
                                <form action="{{ adminUrl('freelancer/status') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $row->id }}" name="id">
                                    @if ($row->status == 1)
                                        <button type="submit" class="btn btn-warning btn-block">حظر الحساب</button>
                                    @else
                                        <button type="submit" class="btn btn-success btn-block">تفعيل الحساب</button>
                                    @endif
                                </form><!-- Form Active And UnActive -->
                            </div>

                            <div class="col">
                                <form class="delete" action="{{ adminUrl('freelancer/delete') }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <input type="hidden" value="{{ $row->id }}" name="id">
                                    <button type="submit" class="btn btn-outline-danger btn-block">حذف الحساب</button>
                                </form>
                            </div>

                        </div>
                    </div>

                </div><!-- Controls -->

            </div>
        </div><!-- Grid 1-->


        <div class="col-lg-8 mb-4">
            <div class="row">

                <div class="col-12 mb-4">
                    <div class="box-white table-responsive">
                        <h6 class="mb-3 font-weight-bold">المشاريع التي عمل عليها</h6>

                        <table class="table table-striped table-inverse mb-0 table-bordered text-center table-with-avatar">
                            <thead class="thead-inverse">
                                <tr>
                                    <th class=" font-weight-normal">تكلفة المشروع</th>
                                    <th class=" font-weight-normal">مدة المشروع</th>
                                    <th class=" font-weight-normal">موعد التسليم</th>
                                    <th class=" font-weight-normal">تفاصيل المشروع</th>
                                    <th class=" font-weight-normal">حالة المشروع</th>
                                    <th class=" font-weight-normal"> تفاصيل المشروع</th>
                                    <th class=" font-weight-normal"> تفاصيل الطلب</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $pro)
                                    <tr>
                                        <td>${{ $pro->price }}</td>
                                        <td>{{ $pro->duration }} يوم</td>
                                        <td>{{ date('Y-m-d', $pro->duration_date) }}</td>
                                        <td>
                                            @if ($pro->details == null)
                                                لا يوجد
                                            @else
                                                {{ $pro->details }}
                                            @endif

                                        </td>

                                        <td>
                                            @if ($pro->order->status > 0)
                                                <span class=" badge badge-success">مكتمل</span>
                                            @else
                                                <span class=" badge badge-warning">غير مكتمل</span>
                                            @endif
                                        </td>

                                        <td><a href="{{ adminUrl('project/show/' . $pro->id) }}"
                                                class=" btn btn-sm btn-outline-primary">عرض المشروع</a></td>

                                        <td><a href="{{ adminUrl('orders/show/' . $pro->order->id) }}"
                                                class=" btn btn-sm btn-outline-primary">عرض الطلب</a></td>



                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="col-12">
                    <h6 class=" font-weight-bold">عمليات السحب</h6>

                    @foreach ($balanceWithdrawal as $balance)
                        <div class=" box-white px-0 mb-4">
                            @if ($balance->status == 0)
                                <div class="px-3">
                                    <span class="float-right">طلب سحب ارباح</span>
                                    <div class="clearfix"></div>
                                </div>
                                <hr>

                                <div class="px-3 mb-3">
                                    <span class="float-right">نوع العملية</span>
                                    <span class="float-left">سحب</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="px-3 mb-3">
                                    <span class="float-right">القيمة</span>
                                    <span class="float-left font-weight-bold">${{ $balance->amount }}</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="px-3 mb-3">
                                    <span class="float-right">حالة الطلب</span>
                                    <span class="float-left badge badge-warning">في انتظار الموافقة</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="px-3 mb-3">
                                    <span class="float-right">سحب عن طريق</span>
                                    <span class="float-left text-uppercase">{{ $balance->method }}</span>
                                    <div class="clearfix"></div>
                                </div>


                                <div class="px-3 mb-3">
                                    @if ($balance->method == 'wallet')
                                        <span class="float-right">سحب علي رقم</span>
                                        <span class="float-left">{{ $balance->phone }}</span>
                                    @else
                                        <span class="float-right">سحب علي بريد</span>
                                        <span class="float-left">{{ $balance->email }}</span>
                                    @endif
                                    <div class="clearfix"></div>
                                </div>

                                <div class="px-3 mb-3">
                                    <span class="float-right">تاريخ الطلب</span>
                                    <span class="float-left text-uppercase">{{ parseTime($balance->created_at) }}</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="px-3">
                                    <span class="float-right">التحكم</span>
                                    <span class="float-left">
                                        <form action="{{ adminUrl('freelancer/withdrawal') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="balance_id" value="{{ $balance->id }}" required>
                                            <input type="hidden" name="id" value="{{ $row->id }}" required>

                                            <button type="submit" class="btn btn-primary btn-sm"> اتمام التحويل</button>
                                        </form>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                            @else
                                <div class="px-3">
                                    <span class="float-right">طلب سحب ارباح</span>
                                    <div class="clearfix"></div>
                                </div>
                                <hr>



                                <div class="px-3 mb-3">
                                    <span class="float-right">نوع العملية</span>
                                    <span class="float-left">سحب</span>
                                    <div class="clearfix"></div>
                                </div>


                                <div class="px-3 mb-3">
                                    <span class="float-right">القيمة</span>
                                    <span class="float-left font-weight-bold">${{ $balance->amount }}</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="px-3 mb-3">
                                    <span class="float-right">حالة الطلب</span>
                                    <span class="float-left badge badge-success">مكتمل</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="px-3 mb-3">
                                    <span class="float-right">سحب عن طريق</span>
                                    <span class="float-left text-uppercase">{{ $balance->method }}</span>
                                    <div class="clearfix"></div>
                                </div>


                                <div class="px-3 mb-3">
                                    @if ($balance->method == 'wallet')
                                        <span class="float-right">سحب علي رقم</span>
                                        <span class="float-left">{{ $balance->phone }}</span>
                                    @else
                                        <span class="float-right">سحب علي بريد</span>
                                        <span class="float-left">{{ $balance->email }}</span>
                                    @endif
                                    <div class="clearfix"></div>
                                </div>

                                <div class="px-3">
                                    <span class="float-right">تاريخ الطلب</span>
                                    <span class="float-left">{{ parseTime($balance->created_at) }}</span>
                                    <div class="clearfix"></div>
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>

            </div>
        </div><!-- Grid 2 -->



    </div>





    <!-- Modal Messages -->
    <div class="modal fade" id="send-message-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">رسالة جديدة</h5>
                </div>
                <div class="modal-body">
                    <div class="result"></div>
                    <form class="form" action="{{ admin_url('freelancer/send-message') }}" method="POST">
                        @csrf
                        <input type="hidden" id="recipient-id" name="recipient_id">
                        <div class="form-group">
                            <textarea class="form-control" name="message" cols="8" rows="8" autofocus placeholder="الرسالة" required></textarea>
                        </div>

                        <button type="submit" id="btn-send-message" class="btn btn-primary">أرسل رسالة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{ asset('assets/plugins/chart/chart.min.js') }}"></script>
    <script>

    </script>
@endsection
