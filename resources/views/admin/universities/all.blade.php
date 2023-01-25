@extends('admin.layouts.master')
@section('title', 'الجامعات')
@section('content')

    <div class="links-bar">
        <h4>الجامعات</h4>
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
        @if (count($universities) > 0)

            <div class="col-xl-7">
                <div class="box-white table-responsive mb-4">
                    <table class="table table-striped text-center table-inverse table-bordered  mb-0 table-with-avatar">
                        <thead class="thead-inverse">
                            <tr>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>التعديل</th>
                                <th>الحذف</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($universities as $row)
                                <tr>
                                    <td><img src="{{ asset("assets/uploads/thumbnails/universities/$row->image") }}"></td>
                                    <td>{{ $row->name }}</td>
                                    <td><a href="{{ adminUrl("university/edit/$row->id") }}"
                                            class=" btn btn-outline-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                    <td>
                                        <form class="delete" action="{{ adminUrl('university/destroy') }}" method="POST">
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
                <a href="{{ adminUrl('university/create') }}" class=" btn-main btn-sm">اضافة جامعة</a>
            </div>

        @else
            <div class="col-12">
                <div class="box-white py-5 text-center">
                    <h4 class=" mb-4 text-center">لا يوجد جامعات للعرض !</h4>
                    <a href="{{ adminUrl('university/create') }}" class="mt-3  btn-main btn-sm">اضف الان</a>
                </div>
            </div>
        @endif
    </div>

@endsection
