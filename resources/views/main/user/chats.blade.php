{{ $removeSpinner = '' }}
@extends('main.layouts.master')
@section('title', 'المحادثات')
@section('content')
    <section id="section" class="py-5">
        <div class="container-fluid">
            <div class="row">

                <!-- Include Aside -->
                @include('main.user.aside')

                @if (count($chats) > 0)

                    <div class="col-lg-9 col-md-8">
                        <h5 class="page-name">المحادثات</h5><!-- Page Name -->
                        <div class="row">

                            <div class="col-12">
                                @foreach ($chats as $row)
                                    <div class="box-white px-0 mb-2">



                                        <a
                                            @if ($row->status > 0) href="{{ userUrl('messages/' . $row->freelancer->id) }}" @endif>
                                            <div class="sender-details px-3">
                                                @if ($row->freelancer->image == null)
                                                    <img class="small-image rounded-circle"
                                                        src="{{ asset('assets/images/defualt-avatar.png') }}">
                                                @else
                                                    @if (checkFile('assets/uploads/freelancer/' . $row->freelancer->image))
                                                        <img class="small-image rounded-circle" class="img-fluid"
                                                            src="{{ asset('assets/uploads/freelancer/' . $row->freelancer->image) }}">
                                                    @else
                                                        <img class="small-image rounded-circle"
                                                            src="{{ asset('assets/images/defualt-avatar.png') }}">
                                                    @endif
                                                @endif

                                                <span class="mr-2">{{ $row->freelancer->name }}</span>
                                                @if ($row->status == 0)
                                                    <span class="text-danger"> - تم غلق المحادثة من قبل الإدارة</span>
                                                @endif

                                            </div><!-- Sender Details -->
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                        </div><!-- Row -->
                    </div><!-- End Content -->
                @else
                    <div class="col-lg-9">
                        <div class="box-white text-center py-5">
                            <h5>لا توجد محادثات حتى الان !</h5>
                            <small>سوف يتم فتح اول محادثة عند بدء اول مشروع لك</small>
                        </div>
                    </div>
                @endif
            </div>
            
        </div>
    </section>
@endsection
