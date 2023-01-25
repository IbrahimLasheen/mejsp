@extends('admin.layouts.master')
@section('title', 'المستخدمين')
@section('content')

    <div class="links-bar my-4 ">
        <h4>المستخدمين</h4>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div id="freelancers">
        <div class="row">

            <div class="col-12 mb-3">
                <div class="box-white">
                    <form action="{{ admin_url('users') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-10">
                                <input type="email" name="search" class="form-control form-control-sm"
                                    placeholder="ابحث بواسطة البريد الالكتروني"
                                    value='@isset($_GET['search']) {{ $_GET['search'] }} @endisset' />
                            </div>

                            <div class=" col-lg-2 mt-2 mt-lg-0">
                                <a href="{{ admin_url('users') }}" class="btn btn-light btn-block border">إعادة تعيين</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (count($users) == 0)
                <div class="col-12">
                    <div class="box-white py-5">
                        <h5 class="mb-0 text-center">لا يوجد مستخدمين !</h5>
                    </div>
                </div>
            @else
                <div class="col-12 mb-4">
                    <div class="box-white table-responsive">
                        <table class="table table-striped table-inverse table-bordered mb-0 text-center table-with-avatar">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>الاسم</th>
                                    <th>البريد الالكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <th>المؤهل</th>
                                    <th>تفاصيل اكثر</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $row)
                                    <tr>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}
                                            @if ($row->email_verified_at != null)
                                                <span class="toast-title text-success" data-toggle="tooltip"
                                                    data-placement="top" title="تم تأكيد البريد">

                                                    <span class="text-success"><i
                                                            class="fa-solid fa-circle-check"></i></span>
                                                </span><!-- Email Veric.... -->
                                            @endif
                                        </td>
                                        <td style="direction: ltr">{{ $row->country_code . ' ' . $row->phone }}</td>
                                        <td>
                                            @if ($row->qualification == null)
                                                <small class=" text-secondary"> {{ 'لا يوجد' }}</small>
                                            @else
                                                {{ $row->qualification }}
                                            @endif
                                        </td>
                                        <td><a href="{{ adminUrl('users/show/' . $row->id) }}"
                                                class="btn btn-primary btn-sm">ملف المستخدم</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div><!-- row -->
    </div><!-- freelancers -->




@endsection
