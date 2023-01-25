@extends('admin.layouts.master')
@section('title', 'اضافة ملف للمكتبة')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('library') }}">ملفات المكتبة</a>
        <a href="{{ admin_url('library/create') }}">اضافة ملف جديد</a>
    </div><!-- End Bar Links -->

    <div class="row">

        <div class="col-12">
            <div class="result"></div>
            <form id="form-add-library" action="{{ adminUrl('library/store') }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row justify-content-center">


                    <div class="col-lg-5">
                        <div class="box-white">



                            <div class="form-group">
                                <label class="required">الملف</label>
                                <input type="file" name="file" accept="application/pdf,.docx,.xlsx" class="form-control"
                                    required>
                                <small class=" text-muted">pdf,word,excel</small>
                            </div><!-- file -->


                            <div class="form-group">
                                <label class="required">الفئة</label>
                                <select name="category" class=" form-control" required>
                                    <option disabled selected>--اختر الفئة</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="required">اللغة</label>
                                <select name="category" class=" form-control" required>
                                    <option value="en" selected>انجليزي</option>
                                    <option value="ar">عربي</option>

                                </select>
                            </div><!-- title -->


                            <div class="form-group">
                                <label class="required">عنوان الفئة</label>
                                <textarea name="title" cols="30" rows="6" class="form-control" required></textarea>
                            </div><!-- title -->


                            <button type="submit" class=" btn-main">اضافة</button>

                        </div>
                    </div>

                </div><!-- End Row -->
            </form><!-- End Form -->
        </div><!-- End Col -->
    </div>

@endsection
