@extends('admin.layouts.master')
@section('title', 'اضافة صور جديدة')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('media-library') }}">مكتبة الوسائط</a>
        <a href="{{ admin_url('media-library/create') }}">اضافة صور جديدة</a>
    </div><!-- End Bar Links -->

   
    <div id="all-team" class="row justify-content-center mb-3">

        <div class="col-lg-12">
            <div class="box-white">
                <form id="form-add-media-library"  action="{{ adminUrl('media-library/store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class=" required">الصور</label>
                        <input type="file" name="image[]" multiple class="form-control" required />
                    </div><!-- image -->

                    <button type="submit" class=" btn-main btn-block">اضافة</button>


                </form><!-- End Form -->
            </div>
        </div><!-- End Col -->
    </div>

    <div class="result"></div>

@endsection
