@extends('admin.layouts.master')
@section('title', 'اضافة جامعة')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('universities') }}">الجامعات</a>
        <a href="{{ admin_url('university/create') }}">اضافة جامعة</a>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div id="all-team" class="row justify-content-center">

        <div class="col-lg-4">
            <div class="box-white">
                <form class="form" action="{{ adminUrl('university/store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf


                    <div class="form-group">
                        <label class=" required">الصورة</label>
                        <input type="file" name="image" accept="image/*" class="form-control" required />
                    </div><!-- image -->

                    <div class="form-group">
                        <label class="required">اسم الجامعة</label>
                        <input type="text" name="name" class="form-control" required />
                    </div><!-- name -->

                    <div class="form-group">
                        <label class="required">الجامعة تابعة ؟</label>
                        <select name="country" class="form-control" required>
                            <option selected disabled>اختر دولة</option>
                            @foreach ($countries as $co)
                                <option value="{{ $co->id }}">{{ $co->name }}</option>
                            @endforeach
                        </select>
                    </div><!-- name -->




                    <button type="submit" class="btn-main btn-block">اضافة</button>

                </form><!-- End Form -->
            </div>
        </div><!-- End Col -->
    </div>

@endsection
