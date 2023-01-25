@extends('main.layouts.master')
@section('title', $pageTitle)
@section('content')

    <section id="section" class="py-5">
        <div class="container">
            <div class="row">

                <div class="col-12 mb-4">
                    <h5 class="page-name">{{ $pageTitle }}</h5><!-- Page Name -->
                </div>

                <!-- Include Aside -->
                @include('main.user.aside')



                <div class="col-lg-9">

                    <div class="row">

                        @if (getAuth('user', 'email_verified_at') == null)
                            <div class="col-12">
                                <div class="box-white py-5 text-center">
                                    <h5 class=" text-center mb-3">قبل ارسال الطلبات يجب تاكيد بريدك الالكتروني</h5>
                                    <form class="d-inline-block" action="{{ userUrl('email-verification') }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn-main">تأكيد حسابي</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="col-12 mb-3">
                                <h5 class=" float-right">تعديل الطلب</h5>
                                <a href="{{ userUrl('international-publishing') }}" class="btn-main float-left">طلبات
                                    النشر
                                    الدولى</a>
                            </div>

                            <div id="conferences-details" class="col-lg-3">
                                <div class="box-white px-0 py-3">
                                    <h6 class="mb-0 px-3">التفاصيل</h6>
                                    <hr>
                                    <div class="px-3">
                                        <span class=" float-right text-secondary">ثمن النشر</span>
                                        <span class=" float-left text-success font-weight-bold">$<span
                                                class="price">{{ $row->journal->price }}</span></span>
                                        <div class="clearfix"></div>
                                    </div><!-- Order Details -->
                                </div>
                            </div>

                            <div class="col-lg-9 col-m d-8">

                                <div class="box-white p-3">

                                    <div class="result"></div><!-- Result Box-->

                                    @if (session()->has('successMsg'))
                                        <div class=" alert alert-success text-center">{{ session()->get('successMsg') }}
                                        </div>
                                    @endif

                                    <form class="form" id="form-edit-international-publishing"
                                        action="{{ userUrl('international-publishing/update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf


                                        <div class="form-group">
                                            <label class="required">النشر الدولى</label>
                                            <select name="type" id="select-type" class=" form-control" required>
                                                @foreach ($types as $ty)
                                                    <option @selected($spec->type_id == $ty->id) value="{{ $ty->id }}">
                                                        {{ $ty->type }}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- type -->

                                        <input type="hidden" name="id" value="{{ $row->id }}">

                                        
                                        <div class="form-group">
                                            <label class="required">التخصص</label>
                                            <select name="specialty" id="select-specialty" class=" form-control" required>
                                                @foreach ($specialty as $sp)
                                                    <option @selected($sp->id == $spec->id) value="{{ $sp->id }}">
                                                        {{ $sp->specialty }}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- specialty -->


                                        <div class="form-group">
                                            <label class="required">المجلة</label>
                                            <select name="journal" id="select-journal" class=" form-control" required>
                                                @foreach ($journals as $jour)
                                                    <option @selected($jour->id  == $row->journal_id) value="{{ $jour->id }}">{{ $jour->name }}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- journal -->
                                        

                                        <div class="form-group">
                                            <label class="">إعادة تحميل ملف البحث</label>
                                            <input type="file" name="file" class="form-control" accept=".docx,.doc"
                                                 />
                                            <small class="text-muted text-left d-block">انواع الملفات (doc/docx) فقط هي التي
                                                يتم
                                                قبولها</small>
                                        </div><!-- file -->

                                        <div class="form-group">
                                            <label>ملاحظات</label>
                                            <textarea name="desc" class=" form-control" cols="30" rows="7">{{ $row->desc }}</textarea>
                                        </div>

                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn-main">تأكيد ومتابعه</button>
                                        </div>



                                    </form>


                                </div>
                            </div><!-- End Content -->
                        @endif

                    </div>

                </div>






            </div>
        </div>
    </section>
@endsection
