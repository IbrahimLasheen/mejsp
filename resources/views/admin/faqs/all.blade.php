@extends('admin.layouts.master')
@section('title', 'الأسئلة الشائعة')
@section('content')

    <div class="links-bar">
        <h4>الأسئلة الشائعة</h4>
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

        <div class="col-lg-6">
            <div class="box-white table-responsive mb-4">
                <table class="table table-striped table-inverse  table-with-avatar mb-0 table-bordered text-center">
                    <thead class="thead-inverse">
                        <tr>
                            <th>عنوان السؤال</th>
                            <th>التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faqs as $row)
                            <tr>
                                <td>{{ $row->title }}</td>
                                <td>
                                    <a href="{{ adminUrl("faqs/edit/$row->id") }}"
                                        class="btn btn-primary btn btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>

                                    <form class="delete d-inline-block" action="{{ adminUrl('faqs/destroy') }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $row->id }}" required>
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class=" mb-5">
                <a href="{{ adminUrl('faqs/create') }}" class="btn-main">اضافة سؤال جديد</a>
            </div>
        </div>

    </div>

@endsection
