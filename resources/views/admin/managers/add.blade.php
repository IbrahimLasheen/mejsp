@extends('admin.layouts.master')
@section('title', 'جميع الدكاترة')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url("admins") }}">المشرفين</a>
        <a href="{{ admin_url("create/admin") }}">اضافة مشرف جديد</a>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    
    <div class="row mt-4 justify-content-center">
        <div class="col-lg-5 col-md-8">
            <div class="box-white">
              
                <form class="form" id="form-add-admin" action="{{ route('addNewAdmin') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group text-center">
                        <label for="input-image"><img class="view-image file-image"
                                src="{{ asset('admin-assets/images/default-profile-image.png') }}"></label>
                        <br>
                        <label for="input-image" class=" btn btn-outline-dark btn-sm">ارفع صورتك</label>
                        <input type="file" name="image" id="input-image" accept="image/*" class="form-control d-none" />
                        @error('image')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- image -->

                    <div class="form-group">
                        <label class="required">اسم المشرف</label>
                        <input type="text" name="name" class="form-control" />
                        @error('name')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- name -->


                    <div class="form-group">
                        <label class="required">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" />
                        @error('email')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- email -->


                    <div class="form-group">
                        <label class=" required">الوظيفة</label>
                        <select name="role" class=" form-control">
                            <option selected disabled>اختار الوظيفة</option>
                            <option value="administrator">مشرف</option>
                            <option value="blogger">مدون</option>
                        </select>
                        @error('role')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- role -->

                    <div class="form-group">
                        <label class=" required">كلمة السر</label>
                        <input type="password" name="password" class="form-control" />
                        @error('password')
                            <div class=" alert-error "> {{ $message }}</div>
                        @enderror
                    </div><!-- password -->

              



                    <button type="submit" id="btn-add-admin" class="btn-main">اضافة المشرف</button>

                </form>
                
            </div>
        </div>
    </div><!-- Row -->

@endsection
