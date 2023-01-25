@extends('admin.layouts.master')
@section('title', 'تعديل فئة')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('library/categories') }}">فئات المكتبة</a>
        <a>تعديل فئة</a>
    </div><!-- End Bar Links -->

    <div class="row">

        <div class="col-12">
            <div class="result"></div>
            <form id="form-edit-library-category" action="{{ adminUrl('library/category/update') }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row justify-content-center">


                    <div class="col-lg-5">
                        <div class="box-white">

                            <div class="form-group">
                                <label class="required">الصورة</label>
                                <input type="file" name="image" accept="image/*" class="form-control">
                            </div><!-- image -->


                            <div class="form-group">
                                <label class="required">عنوان الفئة</label>
                                <input type="text" name="title" class="form-control" value="{{ $row->title }}" required >
                            </div><!-- title -->

                            <input type="hidden" name="id" value="{{ $row->id }}">

                            <div class="form-group">
                                <label>تفاصيل الفئة</label>
                                <textarea name="desc" cols="30" rows="4" class="form-control">{{ $row->desc }}</textarea>
                            </div><!-- desc -->

                            <button type="submit" class=" btn-main">تحديث</button>

                        </div>
                    </div>

                </div><!-- End Row -->
            </form><!-- End Form -->
        </div><!-- End Col -->
    </div>

@endsection
