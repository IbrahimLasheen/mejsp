@extends('admin.layouts.master')
@section('title', 'تعديل مقالة')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}" />
@endsection
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('articles') }}">المقالات</a>
        <a>تعديل مقالة</a>
    </div><!-- End Bar Links -->

    <div id="all-articles" class="row">
        
        <div class="col-12">
            <div class="result"></div>
            <form id="form-edit-article" action="{{ adminUrl('article/update') }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                <input type="hidden" name="id" value="{{ $row->id }}">
                <div class="row">

                  
                    <div class="col-lg-9">
                        <div class="box-white">

                            <div class="form-group">
                                <label>الصورة</label>
                                <input type="file" name="image" accept="image/*" class="form-control">
                            </div><!-- image -->

                            
                            <div class="form-group">
                                <label class="required">عنوان المقالة</label>
                                <input type="text" name="title" class="form-control" value="{{ $row->title }}" required>
                            </div><!-- image -->
                            
                            <div class="form-group my-4">
                                <input type="checkbox" name="show_in_chat" class="ml-2" @if($row->show_in_chat) checked @endif >
                                <label class="">إظهار المقالة في صفحة المحادثة</label>
                            </div><!-- image -->

                            
                            <div class="form-group">
                                <label class=" required">محتوي المقالة</label>
                                <textarea name="content" cols="30" rows="10" class="form-control editor" required>{{ $row->content }}</textarea>
                            </div><!-- content -->

                            <button type="submit" class=" btn-main">تحديث المقالة</button>

                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="box-white px-0">

                            <h5 class="px-3">اعدادات الSEO للمقالة</h5>
                            <hr>
                            <div class="px-3">

                                <div class="form-group">
                                    <input type="text" name="slug" class="form-control" placeholder="رابط المقالة" value="{{ unSlug($row->slug) }}" required>
                                </div><!-- slug -->

                                <div class="form-group mb-0">
                                    <textarea name="meta_desc" name="meta_desc" class="form-control" cols="30"
                                        rows="5" placeholder="وصف المقالة">{{ $row->meta_desc }}</textarea>
                                    <small class=" text-muted">وصف صغير ودقيق للمقالة</small>
                                </div><!-- meta_desc -->


                            </div>

                        </div>
                    </div><!-- END SEO BOX -->


                </div><!-- End Row -->
            </form><!-- End Form -->
        </div><!-- End Col -->
    </div>

@endsection
@section('js')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection
