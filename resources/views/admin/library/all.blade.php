@extends('admin.layouts.master')
@section('title', 'فئات المكتبة')
@section('content')

    <div class="links-bar">
        <h4>ملفات المكتبة</h4>
    </div><!-- End Bar Links -->

    <div id="all-articles" class="row justify-content-center ">
        <div class="col-12">
            @if (session()->has('deleteMessage'))
                <div class="alert box-success alert-dismissible fade show" role="alert">
                    {{ session()->get('deleteMessage') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        @if (count($library) > 0)

            <div class="col-12 my-3">
                <a href="{{ adminUrl('library/categories') }}" class=" btn-sm btn-main">الفئات</a>
                <a href="{{ adminUrl('library/create') }}" class=" btn-sm btn-main">اضافة ملف <i
                        class="fa-solid fa-plus"></i></a>
            </div>
            <div class="col-xl-12">
                <div class="box-white table-responsive mb-4">
                    <table class="table table-striped text-center table-inverse table-bordered  mb-0">
                        <thead class="thead-inverse">
                            <tr>
                                <th class=" text-right">العنوان</th>
                                <th>اضيف</th>
                                <th>عرض</th>
                                <th>تحميل</th>
                                <th>التعديل</th>
                                <th>الحذف</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($library as $row)
                                <tr>
                                    <td class=" text-right">{{ $row->title }}</td>
                                    <td>{{ $row->created_at->diffforhumans() }}</td>
                                    <td><a class="btn btn-warning btn-sm"
                                            href="{{ asset('assets/uploads/library/' . $row->file) }}" target="blank"><i
                                                class="fa-regular fa-eye"></i></a></td>
                                    <td>
                                        @if (!empty($row->file) && file_exists(public_path('assets/uploads/library/' . $row->file)))
                                            <a class="btn btn-success btn-sm" download
                                                href="{{ asset('assets/uploads/library/' . $row->file) }}">
                                                <i class="fa-solid fa-download"></i></a>
                                        @else
                                            <strong class=" text-danger">لا يوجد ملف</strong>
                                        @endif

                                    </td>
                                    <td><a href="{{ adminUrl("library/edit/$row->id") }}"
                                            class=" btn btn-outline-primary btn-sm"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                    <td>
                                        <form class="delete" action="{{ adminUrl('library/destroy') }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $row->id }}" required>
                                            <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                    class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>


            </div>

            <div class="col-12">
                <div class=" float-left"> {{ $library->links() }}</div>
                <a href="{{ adminUrl('library/create') }}" class=" btn-main btn-sm float-right">اضافة ملف جديد</a>
                <div class="clearfix"></div>
            </div>
        @else
            <div class="col-12">
                <div class="box-white py-5 text-center">
                    <h4 class=" mb-4 text-center">لا يوجد ملفات للعرض !</h4>
                    <a href="{{ adminUrl('library/create') }}" class="mt-3  btn-main btn-sm">اضف الان</a>
                </div>
            </div>
        @endif
    </div>

@endsection
