@extends('admin.layouts.master')
@section('title', 'عرض مشروع')
@section('content')


    <div class="links-bar">
        <a href="{{ admin_url('projects') }}">المشاريع</a>
        <a>عرض مشروع</a>
    </div><!-- End Bar Links -->


    @if (session()->has('success'))
        <div class="alert  box-success alert-dismissible fade show mb-3" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <div class="result mb-3"></div>
    <section>
        <div class="row justify-content-center">


            <div class="col-lg-5 mb-4">
                <div class="row">

                    <div class="col-12">
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
                                    <a
                                        href="{{ adminUrl('freelancer/show/' . $row->freelancer->id) }}">{{ $row->freelancer->name }}</a>
                                </span>
                                <div class="clearfix"></div>
                            </div>

                            <div class=" px-3 mb-3">
                                <span class="float-right text-secondary">العميل</span>
                                <span class="float-left text-secondary">
                                    <a href="{{ adminUrl('users/show/' . $row->user->id) }}">{{ $row->user->name }}</a>
                                </span>
                                <div class="clearfix"></div>
                            </div>


                            <div class=" px-3 mb-3">
                                <span class="float-right text-secondary">تكلفة المشروع</span>
                                <span class="float-left">${{ $row->price }}</span>
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

                            <div class=" px-3">
                                <span class="float-right text-secondary">موعد التسليم</span>
                                <span class="float-left">{{ date('Y-m-d', $row->duration_date) }}</span>
                                <div class="clearfix"></div>
                            </div>
                            <hr>
                            <h6 class="px-3 font-weight-bold">تفاصيل من الادارة</h6>

                            <div class=" px-3">
                                <span class="text-secondary">
                                    @if ($row->details == null)
                                        لا يوجد
                                    @else
                                        {{ $row->details }}
                                    @endif
                                </span>
                            </div>

                        </div>
                    </div>

                    <div id="box-edit-project" class="col-12 mt-4">

                        <div class="box-white px-0">
                            <form action="{{ adminUrl('project/update') }}" method="POST"
                                class="px-3 form" enctype="multipart/form-data">

                                <div class="">
                                    <input type="hidden" name="id"
                                        value="{{ Crypt::encryptString($row->id) }}">
                                    @csrf
                                </div><!-- ID -->

                                <div class="form-group">
                                    <label class="required">سعر المشروع ( بالدولار )</label>
                                    <input type="number" step="any" name="price" class="form-control" value="{{ $row->price  }}" required>
                                    <small class="text-muted">هذا السعر الذي سوف يتقاضاة الموظف بعد اكمال
                                        المشروع</small>
                                </div>

                                <div class="form-group">
                                    <label class="required">مدة المشروع ( باليوم )</label>
                                    <input type="number" name="duration" class="form-control">
                                    <small class="text-muted">هذه المدة التي سوف يتم فيها تسليم المشروع</small>
                                </div>

                                <div class="form-group">
                                    <label>ملاحظات ( اختياري )</label>
                                    <textarea name="details" cols="30" rows="8" class="form-control">{{ $row->details }}</textarea>
                                </div>

                                <button type="submit" class="btn-main btn-block">تحديث المشروع</button>

                            </form>
                        </div>

                    </div>


                    <div class="col-12 my-4">
                        <div class="box-white">
                            <h6 class="mb-3 font-weight-bold">التحكم</h6>
                            <div class="row">

                                @if ($row->order->status == 0)
                                    <div class="col">
                                        <form action="{{ adminUrl('project/status') }}" method="POST">
                                            <input type="hidden" value="{{ $row->id }}" name="id">
                                            @if ($row->status > 0)
                                                @csrf
                                                <button type="submit" class="btn btn-outline-warning btn-block">اغلاق
                                                    المشروع</button>
                                            @else
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-block">فتح
                                                    المشروع</button>
                                            @endif

                                        </form>
                                    </div>
                                @endif
                                <div class="col">
                                    <form class="delete" action="{{ adminUrl('project/destroy') }}"
                                        method="post">
                                        @method("DELETE")
                                        <input type="hidden" value="{{ $row->id }}" name="id">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-block">حذف المشروع</button>
                                    </form>
                                </div>

                                <div class="col">
                                    <button id="btn-open-edit-project-box" type="button" class="btn btn-outline-primary btn-block">تعديل المشروع</button>
                                </div>

                            </div>
                        </div>
                    </div>

                  


                </div>
            </div><!-- Grid 1 -->

            <div class="col-md-7">
                <div class="box-white px-0">
                    <h5 class="px-3">المحادثة بين الطرفين</h5>
                    <hr>
                    <div id="messageBox" class="px-3">
                        @foreach ($messages as $msg)
                            <div class="">
                                @if ($msg->send_by == 'user')
                                    <div class="bg-light d-inline-block border p-2 rounded float-right my-2">
                                        {{ $msg->message }}
                                        <form class="delete d-inline-block"
                                            action="{{ adminUrl('project/destroy/message') }}" method="POST"
                                            enctype="multipart/form-data">
                                            <input type="hidden" value="{{ $msg->id }}" name="id">
                                            <small><button type="submit" class="text-danger"> - حذف
                                                    الرسالة</button></small>
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </div>
                                    <div class="clearfix"></div>
                                @else
                                    <div class="bg-light d-inline-block border p-2 rounded float-left my-2">
                                        {{ $msg->message }}
                                        <form class="delete d-inline-block"
                                            action="{{ adminUrl('project/destroy/message') }}" method="POST"
                                            enctype="multipart/form-data">
                                            <input type="hidden" value="{{ $msg->id }}" name="id">
                                            <small><button type="submit" class="text-danger"> - حذف
                                                    الرسالة</button></small>
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </div>
                                    <div class="clearfix"></div>
                                @endif
                                @foreach ($msg->atte as $att)
                                    <a download href="{{ asset('assets/uploads/messages/' . $att->attechment) }}">
                                        <div class=" badge badge-primary ">
                                            {{ $att->attechment }}
                                            <form class="delete d-inline-block"
                                                action="{{ adminUrl('project/destroy/message/file') }}" method="POST"
                                                enctype="multipart/form-data">
                                                <input type="hidden" value="{{ $att->id }}" name="id">
                                                <small><button type="submit" class="text-white"> - حذف
                                                        الملف</button></small>
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        </div><br>
                                    </a>
                                @endforeach

                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="px-3">
                        <div class="row text-secondary">
                            <div class="col text-center"><small>العميل</small></div>
                            <div class="col-1">-</div>
                            <div class="col text-center"><small>المستقل</small></div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection
@section('js')
    <script>
        $("#messageBox").scrollTop($("#messageBox")[0].scrollHeight); // Scroll Message To Last Message In Chat
    </script>
@endsection
