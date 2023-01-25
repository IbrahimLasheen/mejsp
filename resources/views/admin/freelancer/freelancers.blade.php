@extends('admin.layouts.master')
@section('title', 'الكاتبون')
@section('content')

    <div class=" mt-4 mb-3 ">
        <h4 class=" float-right "><a class="text-dark" href="{{ adminUrl('freelancers') }}">الكاتبون</a></h4>
        <a href="{{ adminUrl('freelancers/specialty') }}" class=" float-left btn-main btn-sm">التخصصات</a>
        <div class="clearfix"></div>
    </div><!-- End Bar Links -->


    <div class="result"></div>

    <div id="freelancers">
        <div class="row">

            <div class="col-12">

                @if (session()->has('statusMsg'))
                    <div class="alert  box-success alert-dismissible fade show" role="alert">
                        {{ session()->get('statusMsg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="box-white p-2 mb-4">
                    <div class="row">


                        <div class="col-md-6 col-12">
                            <form action="{{ admin_url('freelancers') }}" method="GET">
                                <input type="text" name="search" class="form-control form-control-sm"
                                    placeholder="ابحث بواسطة اسم الكاتب" value='@php
                                        if (isset($_GET['search'])) {
                                            echo trim($_GET['search']);
                                        }
                                    @endphp' />
                            </form>
                        </div><!-- seach -->

                        <div class="col-md-6">
                            <form action="{{ admin_url('freelancers') }}" method="GET">
                                <div class="row">

                                    <div class="col-md-9 col-12">

                                        <select class=" form-control" name="specialty">
                                            <option selected disabled>ابحث بواسطة التخصص</option>
                                            @foreach ($specialtys as $row)
                                                <option @if (isset($_GET['specialty']) && $row->id == $_GET['specialty']) selected @endif
                                                    value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>


                                    </div><!-- seach -->

                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary btn-block">بحث بالتخصص</button>
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div><!-- row -->

                </div><!-- box -->

            </div><!-- Search Bar -->

            @if (count($freelancers) == 0)
                <div class="col-12">
                    <div class="box-white py-5">
                        <h5 class="mb-0 text-center">لا يوجد بيانات !</h5>
                    </div>
                </div>
            @else
                @foreach ($freelancers as $row)
                    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                        <div class="box-white">

                            <div class="image">


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

                            </div><!-- image -->

                            <div class="controls">
                                <a href="{{ adminUrl('freelancer/show/' . $row->id) }}"><i
                                        class="fas fa-external-link-alt"></i></a>
                            </div><!-- Controls -->


                            <div class="send-message toast-title" data-id="{{ $row->id }}" data-toggle="tooltip"
                                data-placement="top" title="ارسال رسالة">
                                <button type="button" data-toggle="modal" data-target="#send-message-modal"><i
                                        class="far fa-envelope"></i></button>
                            </div><!-- Send Message -->


                            <!-- Status -->
                            @if ($row->status == 1)
                                <span class="status badge font-weight-lighter badge-success pb-0 toast-title"
                                    data-toggle="tooltip" data-placement="top" title="حالة الحساب">نشط </span>
                            @else
                                <span class="status badge font-weight-lighter badge-warning pb-0 toast-title"
                                    data-toggle="tooltip" data-placement="top" title="حالة الحساب">غير نشط </span>
                            @endif
                            <!-- Status -->

                            <span class="wallet badge font-weight-lighter badge-dark pb-0 toast-title" data-toggle="tooltip"
                                data-placement="top" title="رصيد الحساب">${{ $row->balance }}
                            </span><!-- Wallet -->


                            <div class="info">
                                <a href="#">
                                    <h6 class="mt-2 text-primary"><a
                                            href="{{ adminUrl('freelancer/show/' . $row->id) }}">{{ $row->name }}</a>
                                        @if ($row->email_verification > 0)
                                            <span class="toast-title text-success" data-toggle="tooltip"
                                                data-placement="top" title="البريد موثق">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </span><!-- Email Veric.... -->
                                        @endif
                                    </h6>
                                </a>
                                <h6 class=" text-secondary mb-0">{{ $row->email }}</h6>
                            </div><!-- info -->

                        </div>
                    </div>
                @endforeach
            @endif

        </div><!-- row -->
    </div><!-- freelancers -->


    <!-- Modal Messages -->
    <div class="modal fade" id="send-message-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">رسالة جديدة</h5>
                </div>
                <div class="modal-body">
                    <div class="result"></div>
                    <form class="form" action="{{ admin_url('freelancer/send-message') }}" method="POST">
                        @csrf
                        <input type="hidden" id="recipient-id" name="recipient_id">
                        <div class="form-group">
                            <textarea class="form-control" name="message" cols="8" rows="8" autofocus placeholder="الرسالة" required></textarea>
                        </div>

                        <button type="submit" id="btn-send-message" class="btn btn-primary">أرسل رسالة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
