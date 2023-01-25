@extends('admin.layouts.master')
@section('title', 'اخبار الجامعات')
@section('content')

    <div class="links-bar">
        <h4>اخبار الجامعات</h4>
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
        @if (count($news) > 0)

            <div class="col-12 my-4">
                <a href="{{ adminUrl('universities') }}" class=" btn-sm btn-main">الجامعات</a>
                <a href="{{ adminUrl('university/news/create') }}" class=" btn-sm btn-main">اضافة اخبار <i
                        class="fa-solid fa-plus"></i></a>
            </div>
            <div class="col-xl-12">
                <div class="box-white table-responsive mb-4">
                    <table class="table table-striped text-center table-inverse table-bordered  mb-0">
                        <thead class="thead-inverse">
                            <tr>
                                <th class=" text-right">العنوان</th>
                                <th>جامعة</th>
                                <th>معاينة</th>
                                <th>التعديل</th>
                                <th>الحذف</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($news as $row)
                                <tr>
                                    <td class=" text-right">{{ $row->title }}</td>
                                    <td>{{ $row->getUniversity->name }}</td>
                                    <td><a href="" class="btn btn-success btn-sm"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></td>
                                    <td><a href="{{ adminUrl("university/news/edit/$row->id") }}"
                                            class=" btn btn-outline-primary btn-sm"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                    <td>
                                        <form class="delete" action="{{ adminUrl('university/news/destroy') }}"
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
                <div class=" float-left"> {{ $news->links() }}</div>
                <a href="{{ adminUrl('university/news/create') }}" class=" btn-main btn-sm float-right">اضافة اخبار</a>
                <div class="clearfix"></div>
             </div>
        @else
            <div class="col-12">
                <div class="box-white py-5 text-center">
                    <h4 class=" mb-4 text-center">لا يوجد ملفات للعرض !</h4>
                    <a href="{{ adminUrl('university/news/create') }}" class="mt-3  btn-main btn-sm">اضف الان</a>
                </div>
            </div>
        @endif
    </div>

@endsection
