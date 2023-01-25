@extends('admin.layouts.master')
@section('title', 'الكاتبون')
@section('content')

    <div class="links-bar">
        <h4> <a
                href="{{ admin_url('hire/order/' . Request::segment(4) . '/' . 'user/' . Request::segment(6)) }}">الكاتبون</a>
        </h4>
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
        <div class="col-xl-4">

            <div class="box-white mb-4">
                <h6>بحث بواسطة اسم الكاتب</h6>
                <form action="{{ admin_url('hire/order/' . Request::segment(4) . '/' . 'user/' . Request::segment(6)) }}"
                    method="GET">
                    <input type="text" name="search" class="form-control form-control-sm"
                        value='@isset($_GET['search']) {{ trim($_GET['search']) }} @endisset' required />

                    <button type="submit" class="btn btn-primary  mt-2">بحث</button>
                </form>
            </div>

            <div class="box-white mb-4">
                <h6>بحث بواسطة التخصص</h6>
                <form action="{{ admin_url('hire/order/' . Request::segment(4) . '/' . 'user/' . Request::segment(6)) }}"
                    method="GET">


                    <select class=" form-control" name="specialty">
                        <option selected disabled></option>
                        @foreach ($specialtys as $row)
                            <option @if (isset($_GET['specialty']) && $row->id == $_GET['specialty']) selected @endif value="{{ $row->id }}">
                                {{ $row->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary mt-2">بحث</button>

                </form>

            </div><!-- box -->

        </div>

        @if (count($freelancers) > 0)

            <div class="col-xl-8">
                <div class="box-white table-responsive mb-4">
                    <table class="table table-striped text-center table-inverse table-bordered  mb-0 table-with-avatar">
                        <thead class="thead-inverse">
                            <tr>
                                <th>الصورة</th>
                                <th>الرقم التعريفي</th>
                                <th>الاسم</th>
                                <th>البريد الالكتروني</th>
                                <th>التوظيق</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($freelancers as $row)
                                <tr>
                                    <td>
                                        @if ($row->image == null)
                                            <img src="{{ asset('assets/images/defualt-avatar.png') }}">
                                        @else
                                            @if (checkFile('assets/uploads/freelancer/' . $row->image))
                                                <img class="img-fluid"
                                                    src="{{ asset('assets/uploads/freelancer/' . $row->image) }}">
                                            @else
                                                <img src="{{ asset('assets/images/defualt-avatar.png') }}">
                                            @endif
                                        @endif
                                    </td>

                                    <td>{{ $row->id }}</td>
                                    <td>
                                        {{ $row->name }}
                                        @if ($row->email_verification > 0)
                                            <span class="toast-title text-success" data-toggle="tooltip"
                                                data-placement="top" title="البريد موثق">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </span><!-- Email Veric.... -->
                                        @endif
                                    </td>
                                    <td>{{ $row->email }}</td>
                                    <td>
                                        <a href="{{ adminUrl('project/create/order/' . Request::segment(4) . '/' . 'user/' . Request::segment(6) . '/' . 'freelancer/' . $row->id) }}"
                                            class="btn btn-primary btn-sm btn-block mt-2">وظف</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="col-xl-8">
                <div class="box-white py-5 text-center">
                    <h4 class=" mb-4 text-center">لا يوجد كاتبون !</h4>
                </div>
            </div>
        @endif
    </div>

@endsection
