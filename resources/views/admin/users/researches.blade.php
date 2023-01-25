@extends('admin.layouts.master')
@section('title', 'ابحاث المستخدمين')
@section('content')

    <div class="links-bar my-4 ">
        <h4>ابحاث المستخدمين</h4>
    
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div id="freelancers">
        <div class="row">

            @if (count($rows) == 0)
                <div class="col-12">
                    <div class="box-white py-5">
                        <h5 class="mb-0 text-center">لا يوجد !</h5>
                    </div>
                </div>
            @else
                <div class="col-12 mb-4">
                    <div class="box-white table-responsive">
                        <table class="table table-striped table-inverse table-bordered mb-0 text-center table-with-avatar">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>عنوان البحث</th>
                                    <th>ملخص البحث</th>
                                    <th>نوع البحث</th>
                                    <th>المجلة</th>
                                    <th>بواسطة</th>
                                    <th>تاريخ الطلب</th>
                                    <th>الملف</th>
                                    <th>الحذف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $row)
                                    <tr>
                                        <td>{{ $row->title }}</td>
                                        <td>{{ $row->abstract }}</td>
                                        <td>
                                            @if ($row->type > 0)
                                                {{ 'مقيد الوصول' }}
                                            @else
                                                {{ 'مفتوح المصدر' }}
                                            @endif
                                        </td>
                                        <td>{{ $row->journal ? $row->journal->name : 'تم حذف المجله' }}</td>

                                        <td>
                                            <a
                                                href="{{ adminUrl('users/show/' . $row->user->id) }}">{{ $row->user->email }}</a>
                                        </td>


                                        <td>{{ parseTime($row->created_at) }}</td>


                                        <td>
                                            @if (file_exists(public_path("assets/uploads/users-researches/$row->file")))
                                                <a class="btn btn-light border btn-sm"
                                                    href="{{ asset("assets/uploads/users-researches/$row->file") }}"
                                                    download>
                                                    تحميل الملف
                                                </a>
                                            @else
                                                {{ 'لا يوجد !' }}
                                            @endif
                                        </td>

                                        <td>
                                            <form class="d-inline-block delete" action="{{ adminUrl('users/researches/destroy') }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" value="{{ $row->id }}" name="id">
                                                <button type="submit" class="btn btn-outline-danger btn-sm"> <i
                                                        class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>
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
