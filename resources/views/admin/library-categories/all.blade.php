@extends('admin.layouts.master')
@section('title', 'فئات المكتبة')
@section('content')

    <div class="links-bar">
        <h4>فئات المكتبة</h4>
    </div><!-- End Bar Links -->

    <div id="all-articles" class="row justify-content-center ">
        <div class="col-12">
            @if (session()->has('deleteMessage'))
                <div class="alert  box-success alert-dismissible fade show" role="alert">
                    {{ session()->get('deleteMessage') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        @if (count($libraryCategories) > 0)

            <div class="col-xl-12">
                <div class="box-white table-responsive mb-4">
                    <table class="table table-striped text-center table-inverse table-bordered  mb-0 table-with-avatar">
                        <thead class="thead-inverse">
                            <tr>
                                <th>الصورة</th>
                                <th>العنوان</th>
                                <th>الوصف</th>
                                <th>التعديل</th>
                                <th>الحذف</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($libraryCategories as $row)
                                <tr>
                                    <td><img src="{{ asset("assets/uploads/library-categories/$row->image") }}"></td>
                                    <td>{{ $row->title }}</td>
                                    <td>
                                        @if ($row->desc == null)
                                            لا يوجد
                                        @else
                                            {{ $row->desc }}
                                        @endif
                                    </td>
                                    <td><a href="{{ adminUrl("library/category/edit/$row->id") }}"
                                            class=" btn btn-outline-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                    <td>
                                        <form class="delete" action="{{ adminUrl('library/category/destroy') }}" method="POST">
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
                <a href="{{ adminUrl('library/category/create') }}" class=" btn-main btn-sm">اضافة فئة للمكتبة</a>
            </div>

        @else
            <div class="col-12">
                <div class="box-white py-5 text-center">
                    <h4 class=" mb-4 text-center">لا يوجد فئات للعرض !</h4>
                    <a href="{{ adminUrl('library/category/create') }}" class="mt-3  btn-main btn-sm">اضف الان</a>
                </div>
            </div>
        @endif
    </div>

@endsection
