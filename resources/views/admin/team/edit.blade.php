@extends('admin.layouts.master')
@section('title', 'تعديل عضو')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('team') }}">الفريق</a>
        <a>تعديل عضو</a>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div id="all-team" class="row justify-content-center">



        <div class="col-lg-4">
            <div class="box-white">
                <form id="form-edit-team" class="form" action="{{ adminUrl('team/update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>الصورة</label>
                        <input type="file" name="image" accept="image/*" class="form-control">
                    </div><!-- image -->

                    <div class="form-group">
                        <label class=" required">الاسم</label>
                        <input type="text" name="name" class="form-control" value="{{ $row->name }}">
                    </div><!-- name -->


                    <div class="form-group">
                        <label class=" required">البلد</label>
                        <input type="text" name="country" class="form-control" value="{{ $row->country }}" required />
                    </div><!-- country -->

                    <input type="hidden" name="id" value="{{ $row->id }}">

                    <div class="form-group">
                        <label class=" required">عنوان وظيفي</label>
                        <input type="text" name="job" class="form-control" value="{{ $row->job }}">
                    </div><!-- job -->


                    <div class="form-group">
                        <label class=" required">المجلة</label>
                        <select name="journal" class="form-control">
                            @foreach ($journals as $jour)
                                <option @if ($row->journal_id == $jour->id) {{ 'selected' }} @endif value="{{ $jour->id }}">{{ $jour->name }}</option>
                            @endforeach
                        </select>
                    </div><!-- journal -->



                    <div class="form-group">
                        <label class=" required">النوع</label>
                        <select name="type" class="form-control">
                            <option disabled selected>اختر النوع</option>
                            <option @if ($row->type == 'editor') {{ 'selected' }} @endif value="editor">محرر
                            </option>
                            <option @if ($row->type == 'expert') {{ 'selected' }} @endif value="expert">خبير
                            </option>
                        </select>
                    </div><!-- job -->


                    <hr>
                    <h6>روابط التواصل الاجتماعي</h6>
                    <hr>

                    <div class=" text-left" dir="ltr">


                        <div class="form-group text-left">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control text-left" value="{{ $row->email }}" />
                        </div><!-- email -->



                        <div class="form-group text-left">
                            <label>Website</label>
                            <input type="url" name="website" class="form-control text-left" value="{{ $row->website }}"  />
                        </div><!-- website -->

                        <div class="form-group text-left">
                            <label>Linkedin</label>
                            <input type="url" name="linkedin" class="form-control text-left"
                                value="{{ $row->linkedin }}" />
                        </div><!-- linkedin -->


                    </div>


                    <button type="submit" class=" btn-main btn-block">تحديث</button>


                </form><!-- End Form -->
            </div>
        </div><!-- End Col -->
    </div>

@endsection
