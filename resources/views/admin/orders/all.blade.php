@extends('admin.layouts.master')
@section('title', 'الطلبات')
@section('content')

    <div class="links-bar my-4 ">
        <h4>الطلبات</h4>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <section id="orders">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box-white table-responsive">
                    <table class="table table-striped mb-0 text-center table-inverse table-bordered ">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>دفع بواسطة</th>
                                <th>بوابة الدفع</th>
                                <th>سعر الطلب</th>
                                <th>الرقم التعريفي للمعاملة</th>
                                <th>حالة عملية الدفع</th>
                                <th>تاريخ العملية</th>
                                <th>حالة الطلب</th>
                                <th>حالة العمل</th>
                                <th>التفاصيل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $row)
                                @if (!empty($row->pay) && $row->pay->order_id == $row->id)
                                    @if ($row->pay->process_data == 'APPROVED')
                                        <tr>
                                            <td>{{ $row->id }}</td><!-- ID -->
                                            <td><a
                                                    href="{{ adminUrl('users/show/' . $row->user->id) }}">{{ $row->user->name }}</a>
                                            </td>
                                            <td>{{ $row->pay->source }}</td>
                                            <td>{{ $row->pay->amount }}<small
                                                    class="ml-1">{{ $row->pay->currency }}</small></td>
                                            <td>{{ $row->pay->payment_id }}</td>
                                            <td class="text-success">عملية ناجحة</td>
                                            <td>{{ parseTime($row->pay->created_at) }}</td>
                                            <td>
                                                @if ($row->status > 0)
                                                    <span class="badge badge-success">مكتمل</span>
                                                @else
                                                    <span class="badge badge-warning">غير مكتمل</span>
                                                @endif
                                            </td><!-- ID -->
                                            <td>

                                                @if ($row->status > 0)
                                                    <span class="badge badge-success">مكتمل</span>
                                                @else
                                                    @if ($row->working == 0)
                                                        <span class="badge badge-warning">لم يتم البدء</span>
                                                    @else
                                                        <span class="badge badge-success">قيد التنفيذ</span>
                                                    @endif
                                                @endif

                                            </td><!-- ID -->

                                            <td><a href="{{ adminUrl("orders/show/$row->id") }}"
                                                    class="btn btn-primary btn-sm">تفاصيل اكثر</td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
    </section>


@endsection
