@extends('admin.layouts.master')
@section('title', 'الفواتير')
@section('content')

    <div class="links-bar">
        <h4>الفواتير</h4>
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
                            <th>البريد الالكتروني</th>
                            <th>اجمالي السعر</th>
                            <th>حالة الدفع</th>
                            <th>تحديد كمدفوعة</th>
                            <th>تعديل</th>
                            <th>فتح الرابط</th>
                            <th>حالة الفاتورة</th>
                            <th>الحذف</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($invoices as $row)
                            <tr>
                                <td>#{{ $row->id }}</td>
                                <td>{{ $row->email }}</td>
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

                                <td>
                                    @if ($row->payment_response > 0)
                                        <span class=" text-success">مدفوعة</span>
                                    @else
                                        <small>غير مدفوعة</small>
                                    @endif
                                </td>
                                
                                <td>
                                    @if ($row->payment_response == 0)
                                    <a class="btn btn-sm btn-info pb-0"
                                        href="{{ adminUrl('invoices/mark_as_paid/' . $row->id)}}" >
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->payment_response == 0)
                                    <a href="{{ adminUrl('invoices/edit/' . $row->id) }}">تعديل</a>
                                        
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->payment_response == 0)
                                        <a class="btn btn-sm btn-success pb-0"
                                            href="{{ url('invoice/' . Crypt::encryptString($row->id)) }}" target="_blank">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->payment_response == 0)
                                        @if (time() > $row->ending)
                                            <form class=" d-inline-block" action="{{ adminUrl('invoices/active') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $row->id }}" required>
                                                <button type="submit" class="btn btn-outline-secondary btn-sm pb-0"><i
                                                        class="fa-solid fa-repeat ml-1"></i>إعادة التنشيط</button>
                                            </form>
                                        @else
                                            <span>نشطة</span>
                                        @endif
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td>
                                    <form class="delete d-inline-block" action="{{ adminUrl('invoices/destroy') }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $row->id }}" required>
                                        <button type="submit" class="btn btn-outline-danger btn-sm pb-0"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class=" mb-5 d-none">
                <a href="{{ adminUrl('invoices/create') }}" class="btn-main">اضافة فاتورة</a>
            </div>
        </div>

    </div>

@endsection
