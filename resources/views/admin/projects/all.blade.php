@extends('admin.layouts.master')
@section('title', 'عرض مشروع')
@section('content')


    <div class="links-bar">
        <a>المشاريع</a>
    </div><!-- End Bar Links -->



    <div class="result mb-3"></div>
    <section>
        <div class="row justify-content-center">

            @if (count($rows) > 0)
                
           
            <div class="col-12">
                <div class="box-white table-responsive">
                    <table class="table table-striped table-inverse mb-0 table-bordered text-center">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>منفذ الخدمة</th>
                                <th>العميل</th>
                                <th>تكلفة المشروع</th>
                                <th>مدة التسليم</th>
                                <th>بدء العمل</th>
                                <th>موعد التسليم</th>
                                <th>حالة المشروع</th>
                                <th>المشروع</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($rows as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>
                                        <a
                                            href="{{ adminUrl('freelancer/show/' . $row->freelancer->id) }}">{{ $row->freelancer->name }}</a>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ adminUrl('users/show/' . $row->user->id) }}">{{ $row->user->name }}</a>
                                    </td>
                                    <td>${{ $row->price }}</td>
                                    <td>{{ $row->duration }} يوم</td>
                                    <td>{{ parseTime($row->created_at) }}</td>
                                    <td>{{ date('Y-m-d', $row->duration_date) }}</td>
                                    <td>

                                        @if ($row->order->status > 0)
                                            <span class="badge badge-success">مكتمل</span>
                                        @else
                                            <span class="badge badge-warning">غير مكتمل</span>
                                        @endif
                                    </td>
                                    <td><a class=" btn btn-primary btn-sm" href="{{ adminUrl('project/show/' . $row->id) }}">تفاصيل اكثر</a></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            @else
                <div class="col-12">
                    <div class="box-white py-5">
                        <h3 class=" text-center">لا يوجد مشاريع حتا الان</h3>
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection
