@extends('admin.layouts.master')
@section('title', 'تعديل ملف')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('library') }}">ملفات المكتبة</a>
        <a>تعديل ملف</a>
    </div><!-- End Bar Links -->

    <div class="row">

        <div class="col-12">
            <div class="result"></div>
            <form id="form-edit-library" action="{{ adminUrl('library/update') }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row justify-content-center">


                    <div class="col-lg-5">
                        <div class="box-white">


                            <div class="form-group">
                                <label class="required">الملف</label>
                                <input type="file" name="file" accept="application/pdf,.docx,.xlsx" class="form-control">
                                <small class=" text-muted">pdf,word,excel</small>
                            </div><!-- file -->

                            <input type="hidden" name="id" value="{{ $row->id }}">

                            <div class="form-group">
                                <label class="required">الفئة</label>
                                <select name="category" class=" form-control" required>
                                    @foreach ($categories as $cat)
                                        <option @if ($cat->id == $row->id) selected @endif value="{{ $cat->id }}">{{ $cat->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="required">عنوان الفئة</label>
                                <textarea name="title" cols="30" rows="4" class="form-control" required>{{ $row->title }}</textarea>
                            </div><!-- title -->


                            <button type="submit" class=" btn-main">اضافة</button>

                        </div>
                    </div>

                </div><!-- End Row -->
            </form><!-- End Form -->
        </div><!-- End Col -->
    </div>

@endsection
