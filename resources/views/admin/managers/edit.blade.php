@extends('admin.layouts.master')
@section('title', 'تعديل مشرف')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('admins') }}">المشرفين</a>
        <a>تعديل المشرف</a>
    </div><!-- End Bar Links -->

    <div class="result"></div>


    <div class="row mt-4 justify-content-center">
        <div class="col-lg-5 col-md-8">
            <div class="box-white">

                <form class="form" id="form-edit-admin" action="{{ admin_url('update/admin/' . $row->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group text-center">
                        <label for="input-image"><img class="view-image file-image"
                                src="{{ $row->image == null? asset('admin-assets/images/default-profile-image.png'): asset("admin-assets/uploads/admins/$row->image") }}"></label>
                        <br>
                        <label for="input-image" class=" btn btn-outline-dark btn-sm">عدل صورتك</label>
                        <input type="file" name="image" id="input-image" accept="image/*" class="form-control d-none" />
                        @error('image')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- image -->

                    <div class="form-group">
                        <label class="required">اسم المشرف</label>
                        <input type="text" name="name" class="form-control" value="{{ $row->name }}" />
                        @error('name')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- name -->


                    <div class="form-group">
                        <label class="required">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ $row->email }}" />
                        @error('email')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                        <div class="">
                            <div class="">
                                <div class="">
                                    <div class="">
                                        <div class="">
                                            <input type="hidden" name="id" value="{{ Crypt::encryptString($row->id) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- email -->

                    <div class="form-group">
                        <label class=" required">الوظيفة</label>
                        <select name="role" class=" form-control">
                            <option selected disabled>اختار الوظيفة</option>
                            <option value="administrator" {{ $row->role == 'administrator' ? 'selected' : '' }}>مشرف</option>
                            <option value="blogger" {{ $row->role == 'blogger' ? 'selected' : '' }}>مدون</option>
                        </select>
                        @error('role')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- role -->

                    <div class="form-group">
                        <label>كلمة السر</label>
                        <input type="password" name="password" class="form-control" />
                        <small>اذا كنت لا ترغب في تعديل كلمة السر اترك الحقل فارغ</small>
                        @error('password')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- password -->



                    <button type="submit" id="btn-edit-admin" class="btn-main">تحديث البيانات</button>

                </form>

            </div>
        </div>
    </div><!-- Row -->

@endsection
