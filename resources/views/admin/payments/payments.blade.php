@extends('admin.layouts.master')
@section('title', 'المدفوعات')
@section('content')

    <div class="links-bar">
        <h4>المدفوعات</h4>
    </div><!-- End Bar Links -->

    <section id="home-dashboard">
        <div class="row">

            <div class="col-12">
                @if (count($payments) > 0)
                    <div class="box-white table-responsive">
                        <table class="table table-striped table-inverse table-bordered mb-0 text-center">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>الرقم التعريفي للمعاملة</th>
                                    <th>سعر الفاتورة</th>
                                    <th>الحالة</th>
                                    <th>تاريخ المعاملة</th>
                                    <th>فاتورة لمؤتمر</th>
                                    <th>فاتورة لنشر دولي</th>
                                    <th>فاتورة لشراء بحث</th>
                                    <th>فاتورة رقم</th>
                                    <th>دفع بواسطة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $row)
                                    <tr>
                                        <td>{{ $row->payment_id }}</td>
                                        <td>${{ $row->amount }}</td>
                                        <td>
                                            @if ($row->status == 'APPROVED')
                                                <span class=" text-success">مدفوع</span>
                                            @else
                                                <span class=" text-danger">ألغيت</span>
                                            @endif
                                        </td>
                                        <td>{{ parseTime($row->created_at) }}</td>
                                        <td>
                                            @if ($row->conf != null)
                                                <a href="{{ adminUrl('conference/show/' . $row->conf->id) }}"
                                                    target="_blank">عرض الطلب</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($row->intr != null)
                                                <a href="{{ adminUrl('international-publishing/orders/show/' . $row->intr->id) }}"
                                                    target="_blank">عرض الطلب</a>
                                            @else
                                                -
                                            @endif
                                        </td>


                                        <td>
                                            @if ($row->research != null)
                                                <a href="{{ url('researches/' . $row->research->slug) }}"
                                                    target="_blank">عرض البحث</a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            @if ($row->invoice != null)
                                               #{{ $row->invoice->id }}
                                            @else
                                                -
                                            @endif
                                        </td>



                                        <td>
                                            @if (empty($row->user))
                                                {{ $row->payer_email }}
                                            @else
                                                <a
                                                    href="{{ adminUrl('users/show/' . $row->user->id) }}">{{ $row->user->email }}</a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                @else
                    <div class="box-white py-5">
                        <h3 class=" text-center mb-0">لا توجد مدفوعات</h3>
                    </div>
                @endif
            </div>

            <div class="col-12 mt-3 mb-5">
                {{ $payments->links() }}
            </div>


        </div>
    </section>


@endsection
