{{ $removeSpinner = '' }}
@extends('main.layouts.master')
@section('title', 'الرسائل')
@section('content')
    <section id="section" class="py-5">
        <div class="container-fluid">
            <div class="row">

                <!-- Include Aside -->
                @include('main.user.aside')


                <div class="col-lg-9 col-md-8">
                    
                    <h5 class="page-name">الرسائل</h5><!-- Page Name -->
                    <div class="row">

                        <div id="all-chats" class="col-lg-4 col-sm-6 mb-4">

                            <div class="box-white px-0">
                                <h6 class="px-3 font-weight-bold">تفاصيل المشروع</h6>
                                <hr>


                                <div class=" px-3 mb-3">
                                    <span class="float-right text-secondary">حالة المشروع</span>

                                    @if ($row->order->status > 0)
                                        <span class="float-left badge badge-success">مكتمل</span>
                                    @else
                                        <span class="float-left badge badge-warning">غير مكتمل</span>
                                    @endif

                                    <div class="clearfix"></div>
                                </div>

                                <div class=" px-3 mb-3">
                                    <span class="float-right text-secondary">منفذ الخدمة</span>
                                    <span class="float-left text-secondary">
                                        {{ $row->freelancer->name }}
                                    </span>
                                    <div class="clearfix"></div>
                                </div>


                                <div class=" px-3 mb-3">
                                    <span class="float-right text-secondary">مدة التسليم</span>
                                    <span class="float-left">{{ $row->duration }} يوم</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class=" px-3 mb-3">
                                    <span class="float-right text-secondary">بدء العمل</span>
                                    <span class="float-left">{{ parseTime($row->created_at) }}</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class=" px-3 mb-3">
                                    <span class="float-right text-secondary">موعد التسليم</span>
                                    <span class="float-left">{{ date('Y-m-d', $row->duration_date) }}</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class=" px-3">
                                    <a href="{{ userUrl('my-orders#order-') . $row->order->id }}"
                                        class="btn btn-outline-dark btn-sm btn-block">تفاصيل الطلب</a>
                                </div>

                            </div>

                            @if ($row->order->status == 0)
                                <div class="box-white mt-4">
                                    <form id="form-accept-project" action="{{ userUrl('project/accept') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id"
                                            value="{{ Crypt::encryptString($row->order->id) }}">
                                        <button type="submit" class="btn btn-success btn-block btn-sm">قبول المشروع</button>
                                    </form>
                                </div>
                            @endif

                        </div><!-- All Chats -->


                        <div id="show-message" class="col-lg-8 col-sm-6">
                            @if ($row->order->status > 0)
                            <div class="alert alert-success text-center font-weight-bold">تم استلام هذا المشروع</div>
                            @endif
                            <div class="box-white px-0">

                                <div class="sender-details px-3">


                                    @if ($recipient->image == null)
                                        <img class="small-image rounded-circle" src="{{ asset('assets/images/defualt-avatar.png') }}">
                                    @else
                                        @if (checkFile('assets/uploads/freelancer/' . $recipient->image))
                                            <img class="small-image rounded-circle" class="img-fluid"
                                                src="{{ asset('assets/uploads/freelancer/' . $recipient->image) }}">
                                        @else
                                            <img class="small-image rounded-circle"
                                                src="{{ asset('assets/images/defualt-avatar.png') }}">
                                        @endif
                                    @endif

                                    <span>{{ $recipient->name }}</span>
                                </div><!-- Sender Details -->
                                <hr>


                                <div class="messages px-3">

                                </div><!-- Chat Messages -->
                                <hr>


                                <div class="new-message px-3">
                                    <div class="result mb-3"></div>
                                    <form id="form-send-message" class="form-send-message"
                                        action="{{ userUrl('message/store') }}" method="POST"
                                        enctype="multipart/form-data" autocomplete="off">
                                        @csrf


                                        <button type="submit" id="btn-send" class="btn-send-message">
                                            <div class="icon"><i class="fas fa-paper-plane"></i>
                                            </div>
                                        </button><!-- Button Send -->

                                        <button type="button" class="btn-files text-secondary">
                                            <i class="fas fa-paperclip"></i>
                                        </button><!-- Button Open files -->
                                        <input type="hidden" name="id" value="{{ $recipient->id }}"
                                            class="form-control input-message">

                                        <input type="text" id="input-message" name="message"
                                            class="form-control input-message" />
                                        <!-- Message Input -->

                                        <!-- Start input Files -->
                                        <input type="file" id="file" accept=".docx.,pdf,.zip,.rar,.jpeg,.jpg,.png,.webp"
                                            multiple name="attechment[]" class="input-file mt-3 form-control ">

                                        @error('attechment')
                                            {{ $message }}
                                        @enderror
                                        <!-- End input Files -->


                                        <div class="msg-result"></div>
                                        <div class="clearfix"></div>

                                    </form><!-- End For Send Message -->
                                </div><!-- Box Send Message -->


                            </div><!-- Box-Style -->
                        </div><!-- Show Message -->

                    </div><!-- Row -->
                </div><!-- End Content -->

            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{ asset('assets/js/messages.js') }}"></script>
    @if (session()->has('success'))
        <script>
            toastr.options.timeOut = 2000;
            toastr.options.progressBar = true;
            toastr.success("{{ session()->get('success') }}");
        </script>
    @endif
@endsection
