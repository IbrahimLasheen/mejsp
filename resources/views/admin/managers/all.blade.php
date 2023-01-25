@extends('admin.layouts.master')
@section('title', 'المشرفين')
@section('content')

    <div class="links-bar my-4 ">
        <h4>المشرفين</h4>
    </div><!-- End Bar Links -->


    <div id="all-admins" class="row">
        <div class="col-12">
            <div class="box-white table-responsive">
                <table class="table table-striped table-inverse table-bordered mb-0 text-center">
                    <thead class="thead-inverse">
                        <tr>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الوظيفة</th>
                            <th>اضيف منذ</th>
                            @if (Auth::guard('admin')->user()->role == 'administrator')
                                <th>التعديل</th>
                                <th>الحذف</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $row)
                            <tr>
                                <td>
                                    <img title="{{ $row->name }}" alt="{{ $row->name }} Profile Image"
                                        src="{{ $row->image == null? asset('admin-assets/images/default-profile-image.png'): asset("admin-assets/uploads/admins/$row->image") }}" />
                                </td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>
                                    @if ($row->role == 'administrator')
                                        {{ 'مشرف' }}
                                    @elseif ($row->role == 'blogger')
                                        {{ 'مدون' }}
                                    @else
                                        {{ 'غير معروف' }}
                                    @endif
                                </td>
                                <td>
                                    {{ $row->created_at->diffForHumans() }}
                                </td>

                                @if (Auth::guard('admin')->user()->role == 'administrator')
                                    <td>
                                        <a href="{{ admin_url("edit/admin/$row->id") }}"
                                            class="btn btn-outline-primary btn-sm" title="تعديل"><i
                                                class="far fa-edit"></i></a>
                                    </td>

                                    <td>
                                        <a  href="{{ admin_url("delete/admin/$row->id") }}"
                                            class="btn btn-outline-danger btn-sm confirm-delete " title="حذف"><i
                                                class="far fa-trash-alt"></i></a>
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (getAuth('admin', 'role') == 'administrator')
                <a href="{{ admin_url('create/admin') }}" class=" float-left btn-main btn-sm mt-3"> <i
                        class="fas fa-plus"></i> اضافة مشرف جديد</a>
            @endif
        </div>
    </div>

@endsection
