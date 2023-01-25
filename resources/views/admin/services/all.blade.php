@extends('admin.layouts.master')
@section('title', 'الخدمات')
@section('content')

    <div class="links-bar">
        <h4>الخدمات</h4>
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
                            <th>#</th>
                            <th>عنوان الخدمة</th>
                            <th>الرابط</th>
                            <th>الايقونة</th>
                            <th>في صفحة المحادثة</th>
                            <th>التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->name }}</td>
                                <td>
                                    <a href="{{$row->link}}"><i class="fa fa-link "></i></a>
                                </td>
                                <td>
                                    @if ($row->icon == null)
                                        <small class=" text-muted"> {{ 'لا يوجد' }}</small>
                                    @else
                                        {!! $row->icon !!}
                                    @endif
                                </td>
                                <td>
                                    @if (!$row->show_in_chat)
                                        <small class="text-danger font-weight-bold">غير مفعلة</small>
                                    @else
                                    <small class="text-success font-weight-bold"> مفعلة</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ adminUrl("services/edit/$row->id") }}"
                                        class="btn btn-primary btn btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>

                                    <form class="delete d-inline-block" action="{{ adminUrl('services/destroy') }}"
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
                <a href="{{ adminUrl('services/create') }}" class="btn-main">اضافة خدمة جديدة</a>
            </div>
        </div>

    </div>

@endsection
