{{ $removeSpinner = '' }}
@extends('main.layouts.master')
@section('title', 'الاشعارات')
@section('content')
    <section id="section" class="py-5">
        <div class="container-fluid">
            <div class="row">

                <!-- Include Aside -->
                @include('main.user.aside')


                @if (count($notifications) > 0)
                    <div class="col-lg-9 col-md-8">
                        <h5 class="page-name">الاشعارات</h5><!-- Page Name -->
                        <div class="row">
                            <div class="col-12">
                                <div class="row">

                                    @foreach ($notifications as $row)
                                        <div class="col-xl-12 mb-4">
                                            <div class="box-white py-3 dir-left text-right">

                                                <div class="text-dark">
                                                    {{ $row->message }}
                                                </div>
                                                <div class=" text-muted">
                                                    <small class="">فريق عمل إدارة اكاديمية بحث</small>
                                                    -
                                                    <small>
                                                        {{ parseTime($row->created_at) }}
                                                    </small>
                                                </div>


                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div><!-- End Row -->
                    </div><!-- End Content -->
                @else
                    <div class="col-lg-9">
                        <div class="box-white text-center py-5">
                            <h5>لا توجد اشعارات حتى الان !</h5>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
@endsection
