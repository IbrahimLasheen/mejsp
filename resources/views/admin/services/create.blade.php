@extends('admin.layouts.master')
@section('title', 'اضافة خدمة')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('services') }}">الخدمات</a>
        <a href="{{ admin_url('services/create') }}">اضافة خدمة</a>
    </div><!-- End Bar Links -->

    <div class="row justify-content-center">

        <div class="col-lg-4">
            <div class="result"></div>
            <div class="box-white">
                <form id="form-add-service" class="form" action="{{ adminUrl('services/store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="required">عنوان الخدمة</label>
                        <input type="text" name="name" class="form-control" required />
                        <small id="helpId" class="text-muted">مثل ( تصحيح المقالات , تدقيق لغوي , التحليل الإحصائي , و...  )</small>
                    </div><!-- End -->


                    <div class="form-group">
                        <label class="">الرابط</label>
                        <input type="text" name="link" class="form-control" value=""  />
                    </div><!-- End -->

                    <div class="form-group">
                        <label>أيقونة الخدمة</label>
                        <input type="text" name="icon" class="form-control" />
                        <small id="helpId" class="text-muted"> قم بأستخدام الايقوان من الموقع التالي <a class="mr-1 font-weight-bold" target="__blank" href="https://fontawesome.com/search?m=free&s=solid%2Cbrands">Font Awesome</a>  , ابحث عن الايقونة ثم ثم بنسخها </small>
                    </div><!-- End -->
                    <div class="form-group">
                        <input type="checkbox" name="show_in_chat" class=""  />
                        <label>الآظهار في صفحة المحادثة</label>
                    </div><!-- End -->
                    
                    

                    <button type="submit" class="btn-main btn-block">اضافة</button>

                </form><!-- End Form -->
            </div>
        </div><!-- End Col -->
    </div>

@endsection
