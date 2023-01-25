@extends('admin.layouts.master')
@section('title', 'الملف الشخصي')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('admins') }}">المشرفين</a>
        <a>تعديل المشرف</a>
    </div><!-- End Bar Links -->

    <div class="result"></div>


    <div class="row mt-4 justify-content-center">
        <div class="col-lg-5 col-md-8">
            <div class="box-white">

                <form class="form" id="form-edit-profile" action="{{ admin_url('update/profile') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group text-center">
                        <label for="input-image"><img class="view-image file-image"
                                src="{{ getAuth("admin",'image') == null ? asset('admin-assets/images/default-profile-image.png') : asset("admin-assets/uploads/admins/".getAuth("admin",'image')) }}"></label>
                        <br>
                        <label for="input-image" class=" btn btn-outline-dark btn-sm">عدل صورتك</label>
                        <input type="file" name="image" id="input-image" accept="image/*" class="form-control d-none" />
                        @error('image')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- image -->

                    <div class="form-group">
                        <label class="required">اسم المشرف</label>
                        <input type="text" name="name" class="form-control" value="{{ getAuth("admin",'name') }}" />
                        @error('name')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- name -->


                    <div class="form-group">
                        <label class="required">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ getAuth("admin",'email') }}" />
                        @error('email')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- email -->


                    <div class="form-group">
                        <label>كلمة السر</label>
                        <input type="password" name="password" class="form-control" />
                        <small>اذا كنت لا ترغب في تعديل كلمة السر اترك الحقل فارغ</small>
                        @error('password')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- password -->

                    <button type="submit" id="btn-edit-profile" class="btn-main">تحديث البيانات</button>

                </form>

            </div>
        </div>
    </div><!-- Row -->

@endsection
