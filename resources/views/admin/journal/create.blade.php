@extends('admin.layouts.master')
@section('title', 'اضافة مجلة')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('journals') }}">المجلات</a>
        <a href="{{ admin_url('journal/create') }}">اضافة مجلة</a>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div id="all-team" class="row justify-content-center">

        <div class="col-lg-4">
            <div class="box-white">
                <form class="form" action="{{ adminUrl('journal/store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class=" required">الصورة</label>
                        <input type="file" name="image" accept="image/*" class="form-control" required />
                    </div><!-- image -->

                    <div class="form-group">
                        <label class=" required">اسم المجلة</label>
                        <input type="text" name="name" class="form-control" required />
                    </div><!-- name -->

                    <div class="form-group">
                        <label class=" required">رابط المجلة</label>
                        <input type="url" name="link" class="form-control" required />
                    </div><!-- link -->

                    <button type="submit" class=" btn-main btn-block">اضافة</button>

                </form><!-- End Form -->
            </div>
        </div><!-- End Col -->
    </div>

@endsection
