@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}" />
@endsection
@section('content')

    <div class="links-bar">
        <h5 class="">{{ $pageTitle }}</h5>
    </div><!-- End Bar Links -->

    <div class="result"></div><!-- Result Box -->


    <section id="journals-create">
        <form id="form-add-journal" class="form" action="{{ adminUrl('journals/store') }}" method="POST"
            enctype="multipart/form-data">
            <div class="row">

                <div class="col-lg-9">
                    <div class="row">

                        <div class="col-12 mb-4">
                            <div class="box-white px-0">

                                <h5 class="px-3 font-weight-bold">بيانات المجلة</h5><!-- Box Name -->
                                <hr><!-- HR -->

                                <div class="px-3">

                                    <div class="form-group">
                                        <label class="required">شعار المجلة</label>
                                        <input type="file" name="logo" class=" form-control" required />
                                    </div><!-- logo -->



                                    <div class="form-group">
                                        <label class="required">غلاف المجلة</label>
                                        <input type="file" name="cover" class=" form-control" required />
                                    </div><!-- cover -->


                                    <div class="form-group">
                                        <label class="required">الرؤية واهداف المجلة</label>
                                        <textarea name="brief_desc" cols="30" rows="4" class="form-control" required></textarea>
                                        <small class=" text-muted">قم بكتابة وصف سريع وملخص عن الاهداف الاساسية والرؤية
                                            للمجلة</small>
                                    </div><!-- brief_desc -->

                                </div>

                                <hr>

                                <div class="px-3">
                                    <div class="form-group">
                                        <label>تعليمات المراجعين</label>
                                        <textarea name="reviewers_instructions" cols="30" rows="4" class="form-control editor"></textarea>
                                    </div>
                                </div><!-- reviewers_instructions -->

                                <div class="px-3">
                                    <div class="form-group">
                                        <label>تعليمات المؤلفين</label>
                                        <textarea name="authors_instructions" cols="30" rows="4" class="form-control editor"></textarea>
                                    </div>
                                </div><!-- authors_instructions   -->

                                <div class="px-3">
                                    <div class="form-group">
                                        <label>اخلاقيات النشر</label>
                                        <textarea name="ethics" cols="30" rows="4" class="form-control editor"></textarea>
                                    </div>
                                </div><!-- ethics  -->


                                <div class="px-3">
                                    <div class="form-group">
                                        <label>رسوم التحكيم والنشر</label>
                                        <textarea name="publication_pricing" cols="30" rows="4" class="form-control editor"></textarea>
                                    </div>
                                </div><!-- publication_pricing  -->


                            </div><!-- Box White -->
                        </div><!-- SEO Settings -->

                    </div>
                </div><!-- Grid 2 -->

                <div class="col-lg-3">
                    <div class="row">

                        <div class="col-12 mb-4">
                            <div class="box-white px-0">

                                <h5 class="px-3 font-weight-bold">اعدادات ال SEO</h5><!-- Box Name -->
                                <hr><!-- HR -->
                                <div class="px-3">

                                    <div class="form-group">
                                        <label class="required">اسم المجلة</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div><!-- name -->

                                    <div class="form-group mb-0">
                                        <label class="required">وصف المجلة</label>
                                        <textarea name="meta_desc" cols="30" rows="5" class="form-control"></textarea>
                                        <small class=" text-muted">وصف صغير ودقيق للمجلة</small>
                                    </div><!-- meta_desc -->

                                </div><!-- SEO Inputs -->

                            </div><!-- Box White -->
                        </div><!-- SEO Settings -->

                        <div class="col-12 mb-3">
                            <div class="box-white px-0">

                                <h5 class="px-3 font-weight-bold">معلومات اساسية</h5><!-- Box Name -->
                                <hr><!-- HR -->
                                <div class="px-3">

                                    <div class="form-group">
                                        <label>عامل التأثير ( Impact Factor )</label>
                                        <input type="text" name="impact" class="form-control">
                                    </div><!-- impact   -->

                                    <div class="form-group">
                                        <label>الترقيم الدولي المجلة ( ISSN )</label>
                                        <input type="text" name="issn" class="form-control">
                                    </div><!-- issn -->

                                    {{-- <div class="form-group mb-0">
                                        <label>الاصدار القادم للمجلة</label>
                                        <input type="text" name="next_version" class="form-control">
                                    </div><!-- next_version --> --}}
                                    <label>الاصدار القادم للمجلة</label>

                                    <div class="row">

                                        <div class="col-4 pl-1">
                                            <div class="form-group">
                                                <label class="required">السنه</label>
                                                <select name="year" class="form-control" id="years" value={{old('years')}}>
                                                    <option disabled selected></option>
                                                    @for ($year = date('Y'); $year < date('Y') + 5; $year++)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                        </div><!-- year -->

                                        @php 
                                        $months = ["يناير", "فبراير", "مارس",
                                         "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", 
                                         "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];
 
                                         @endphp
                                        <div class="col-4 px-1">
                                            <div class="form-group">
                                                <label class="required">الشهر</label>
                                                <select name="month" class="form-control" id="month" value={{old('month')}}>
                                                    <option disabled selected></option>
                                                    @foreach ($months as $month)
                                                        <option  value="{{ $month }}">{{ $month }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div><!-- month -->


                                        <div class="col-4 pr-1">
                                            <div class="form-group">
                                                <label class="required">اليوم</label>
                                                <input type="number" name="day" min="1" max="31" class="form-control" required value={{old('day')}}/>
                                            </div>
                                        </div><!-- day -->

                                    </div>

                                </div><!-- End Inputs -->

                            </div><!-- Box White -->
                        </div><!-- Basic information -->


                        <div class="col-12 mb-3">
                            <div class="box-white px-0">

                                <h5 class="px-3 font-weight-bold">معلومات الاتصال</h5><!-- Box Name -->
                                <hr><!-- HR -->
                                <div class="px-3">


                                    <div dir="ltr" class="row">


                                        <div class="col-4 pr-1">
                                            <div class="form-group">
                                                <label dir="rtl" class="required">الكود</label>
                                                <input type="number" step="any" name="country_code"
                                                    class="form-control text-left" required>
                                            </div><!-- country_code -->
                                        </div>

                                        <div class="col-8 pl-1">
                                            <div class="form-group">
                                                <label dir="rtl" class="required">رقم الهاتف</label>
                                                <input type="number" name="phone" class="form-control text-left " required>
                                            </div><!-- phone   -->
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <label class="required">البريد الالكتروني</label>
                                        <input type="email" name="email" class="form-control" required />
                                    </div><!-- email -->

                                    <div class="form-group mb-0">
                                        <label class="required">العنوان</label>
                                        <input type="address" name="address" class="form-control" required />
                                    </div><!-- address -->



                                </div><!-- End Inputs -->

                            </div><!-- Box White -->
                        </div><!-- Basic information -->

                    </div>
                </div><!-- Grid 1 -->

                <div class="col-12 mt-5">
                    <div class="buttons-box">
                        <button type="submit" class=" btn-main px-5">اضافة</button>
                    </div>
                </div>

            </div>
        </form>
    </section>




@endsection
@section('js')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection
