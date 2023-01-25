@extends('admin.layouts.master')
@section('title', 'فواتير المجلات')
@section('content')

    <div class="links-bar">
        <h4>فواتير المجلات</h4>
    </div><!-- End Bar Links -->

    @if (session()->has('successMessage'))
        <div class="alert box-success alert-dismissible fade show" role="alert">
            {{ session()->get('successMessage') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div id="all-articles" class="row justify-content-center">

        <div class="col-lg-12">
            <div class="box-white table-responsive mb-4">
                <table class="table table-striped table-inverse  table-with-avatar mb-0 table-bordered text-center">
                    <thead class="thead-inverse">
                        <tr>
                            <th>رقم الفاتورة</th>
                             <th>المجله</th>
                            <th>اجمالي السعر</th>
                            <th>عدد الصفحات الافتراضية</th>
                            <th>سعر الصفحة الاضافية </th>
                            <th>تعديل</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($invoices as $row)
                            <tr>
                                <td>#{{ $row->id }}</td>
                                <td>{{ $row->journal->name }}</td>
                                <td>
                                    @php
                                        $prices = 0;
                                    @endphp
                                    @foreach ($row->items as $item)
                                        @php
                                            $prices += $item->price;
                                        @endphp

                                        @if ($loop->last)
                                            {{ "$" . $prices }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $row->default_page_count }}</td>
                                <td>{{ $row->extra_page_price }}</td>
                                <td>
                                    <a href="{{ adminUrl('invoices/edit-journal/' . $row->id) }}">تعديل</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class=" mb-5 d-none">
                <a href="{{ adminUrl('invoices/create-journals') }}" class="btn-main">اضافة فاتورة</a>
            </div>
        </div>

    </div>

@endsection
