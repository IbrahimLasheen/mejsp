@extends('admin.layouts.master')
@section('title', 'الفريق')
@section('content')

    <div class="links-bar">
        <h4>الفريق</h4>
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
        @if (count($team) > 0)

            <div class="col-xl-10">
                <div class="box-white table-responsive mb-4">
                    <table class="table table-striped text-center table-inverse table-bordered  mb-0 table-with-avatar">
                        <thead class="thead-inverse">
                            <tr>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>عنوان وظيفي</th>
                                <th>النوع</th>
                                <th>التعديل</th>
                                <th>الحذف</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($team as $row)
                                <tr>
                                    <td><img src="{{ asset("assets/uploads/team/$row->image") }}"></td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->job }}</td>
                                    <td>
                                        @if ($row->type == 'expert')
                                            {{ 'خبير' }}
                                        @else
                                            {{ 'محرر' }}
                                        @endif
                                    </td>
                                    <td><a href="{{ adminUrl("team/edit/$row->id") }}"
                                            class=" btn btn-outline-primary btn-sm"><i class="fa-solid fa-user-pen"></i></a>
                                    </td>
                                    <td>
                                        <form class="delete" action="{{ adminUrl('team/destroy') }}"
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
                <a href="{{ adminUrl('team/create') }}" class=" btn-main btn-sm">اضافة عضو</a>
            </div>
        @else
            <div class="col-12">
                <div class="box-white py-5 text-center">
                    <h4 class=" mb-4 text-center">لا يوجد اعضاء للعرض !</h4>
                    <a href="{{ adminUrl('team/create') }}" class="mt-3  btn-main btn-sm">اضف الان</a>
                </div>
            </div>
        @endif
    </div>

@endsection
