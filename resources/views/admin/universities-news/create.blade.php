@extends('admin.layouts.master')
@section('title', 'اضافة اخبار')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}" />
@endsection
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('university/news') }}">اخبار الجامعات</a>
        <a href="{{ admin_url('university/news/create') }}">اضافة اخبار</a>
    </div><!-- End Bar Links -->

    <div class="row">

        <div class="col-12">
            <div class="result"></div>
            <form class="form" action="{{ adminUrl('university/news/store') }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row justify-content-center">


                    <div class="col-xl-9 col-lg-12">
                        <div class="box-white">

                            <div class="form-group">
                                <label class="required">عنوان الخبر</label>
                                <input type="text" name="title" class="form-control" required />
                            </div><!-- title -->


                            <div class="form-group">
                                <label class="required">نبذة مختصرة</label>
                                <textarea name="abstract" cols="30" rows="4" class="form-control" required></textarea>
                            </div><!-- title -->


                            <div class="form-group">
                                <label class="required">الخبر خاص بجامعة ؟</label>
                                <select name="university" class=" form-control" required>
                                    <option disabled selected>--اختر الفئة</option>
                                    @foreach ($university as $uni)
                                        <option value="{{ $uni->id }}">{{ $uni->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label class="required">محتوي الخبر</label>
                                <textarea name="content" cols="30" rows="12" class="editor form-control" required></textarea>
                            </div><!-- content -->

                            <button type="submit" class=" btn-main">اضافة</button>

                        </div>
                    </div>

                </div><!-- End Row -->
            </form><!-- End Form -->
        </div><!-- End Col -->
    </div>

@endsection
@section('js')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection
