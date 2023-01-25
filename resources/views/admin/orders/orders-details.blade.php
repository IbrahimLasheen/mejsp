@extends('admin.layouts.master')
@section('title', 'تفاصيل الطلبات')
@section('content')

    <div class="links-bar my-4 ">
        <h4>تفاصيل الطلبات</h4>
    </div><!-- End Bar Links -->

    <section id="orders-details">
        <div class="row justify-content-center">

            <div class="col-12">
                @if (session()->has('deleteMessage'))
                    <div class="alert box-success alert-dismissible fade show" role="alert">
                        {{ session()->get('deleteMessage') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="result-pages"></div>

            </div>
            <!--- Results All --->



            <div class="col-xl-4 col-lg-6 mb-4">
                <div class="row">


                    <div class="col-12 mb-4">
                        <div class="bg-white rounded border py-3">

                            <div class="px-3">
                                <span class="float-right mt-1">المستوى الأكاديمي</span>
                                <button type="button" class="float-left btn btn-outline-primary btn-sm" data-toggle="modal"
                                    data-target="#model-academic-level">جديد</button>
                                <div class="clearfix"></div>

                                <!-- Modal Academic Level Add New -->
                                <div class="modal fade" id="model-academic-level" tabindex="-1" role="dialog"
                                    aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">المستوى الأكاديمي</h5>
                                            </div>

                                            <form class="form"
                                                action="{{ adminUrl('orders-details/academic-level/store') }}"
                                                method="POST">
                                                <div class="modal-body">
                                                    <div class="result"></div>
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="required">نوع المستوي</label>
                                                        <input type="text" name="name" class="form-control" required>
                                                        <small class="text-muted">المستوي الاكاديمي ( الدراسي ) مثل
                                                            دكتوراه ,
                                                            كليات...</small>
                                                    </div><!-- name -->

                                                    <div class="form-group">
                                                        <label class="required">السعر للمستوي <b>( USD )</b></label>
                                                        <input type="number" step="any" name="price" class="form-control"
                                                            required>
                                                        <small class="text-muted">يختلف سعر كل مستوي عن الاخر قم باضافة
                                                            سعر لكل
                                                            مستوي</small>
                                                    </div><!-- price -->

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn-main btn-block">اضافة</button>
                                                </div>

                                            </form><!-- Form  -->
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Academic Level Add New-->

                            </div><!-- Box Name -->

                            <hr><!-- Line -->

                            <div class="px-3 table-responsive">
                                <table class="table table-striped table-inverse table-bordered text-center mb-0">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>الاسم</th>
                                            <th>السعر</th>
                                            <th>التعديل</th>
                                            <th>الحذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($academic as $acad)
                                            <tr>
                                                <td class="d-none academic-id">{{ $acad->id }}</td>
                                                <td class="academic-name">{{ $acad->name }}</td>
                                                <td>$<span class="academic-price">{{ $acad->price }}</span></td>
                                                <td>
                                                    <button type="button"
                                                        class="academic-btn btn btn-outline-primary btn-sm"
                                                        data-toggle="modal" data-target="#model-edit-academic-level"><i
                                                            class="fa-solid fa-pen-to-square"></i></button>
                                                </td>
                                                <td>
                                                    <form class="delete"
                                                        action="{{ adminUrl('orders-details/academic-level/destroy') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value="{{ $acad->id }}" required>
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                                class="fa-solid fa-trash-can"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div><!-- Box White -->
                    </div><!-- order_academic_level -->


                    <div class="col-12 mb-4">
                        <div class="bg-white rounded border py-3">

                            <div class="px-3">
                                <span class="float-right mt-1">الخدمات</span>
                                <button type="button" class="float-left btn btn-outline-primary btn-sm" data-toggle="modal"
                                    data-target="#model-services">جديد</button>
                                <div class="clearfix"></div>

                                <!-- Modal Add New -->
                                <div class="modal fade" id="model-services" tabindex="-1" role="dialog"
                                    aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">المستوى الأكاديمي</h5>
                                            </div>

                                            <form class="form"
                                                action="{{ adminUrl('orders-details/services/store') }}" method="POST">
                                                <div class="modal-body">
                                                    <div class="result"></div>
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="required">نوع الخدمة</label>
                                                        <input type="text" name="name" class="form-control" required>
                                                        <small class="text-muted">نوع الخدمة مثل كتاب , تعديل
                                                            ابحاث...</small>
                                                    </div><!-- name -->

                                                    <div class="form-group">
                                                        <label class="required">السعر الخدمة <b>( USD )</b></label>
                                                        <input type="number" step="any" name="price" class="form-control"
                                                            required>
                                                        <small class="text-muted">يختلف سعر كل خدمة عن الاخري قم باضافة
                                                            سعر لكل
                                                            خدمة</small>
                                                    </div><!-- price -->

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn-main btn-block">اضافة</button>
                                                </div>

                                            </form><!-- Form  -->
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Academic Level Add New-->

                            </div><!-- Box Name -->

                            <hr><!-- Line -->

                            <div class="px-3 table-responsive">
                                <table class="table table-striped table-inverse table-bordered text-center mb-0">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>الاسم</th>
                                            <th>السعر</th>
                                            <th>التعديل</th>
                                            <th>الحذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $serv)
                                            <tr>
                                                <td class="d-none services-id">{{ $serv->id }}</td>
                                                <td class="services-name">{{ $serv->name }}</td>
                                                <td>$<span class="services-price">{{ $serv->price }}</span></td>
                                                <td>
                                                    <button type="button"
                                                        class="services-btn btn btn-outline-primary btn-sm"
                                                        data-toggle="modal" data-target="#model-edit-services"><i
                                                            class="fa-solid fa-pen-to-square"></i></button>
                                                </td>
                                                <td>
                                                    <form class="delete"
                                                        action="{{ adminUrl('orders-details/services/destroy') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value="{{ $serv->id }}"
                                                            required>
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                                class="fa-solid fa-trash-can"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div><!-- Box White -->
                    </div><!-- services -->


                </div><!-- row -->
            </div><!-- Grid 1 -->



            <div class="col-xl-4 col-lg-6">
                <div class="row">

                    <div class="col-12 mb-4">
                        <div class="bg-white rounded border py-3">

                            <div class="px-3">
                                <span class="float-right mt-1">اسلوب كتابة المراجع</span>
                                <button type="button" class="float-left btn btn-outline-primary btn-sm" data-toggle="modal"
                                    data-target="#model-paper-format">جديد</button>
                                <div class="clearfix"></div>

                                <!-- Modal Academic Level Add New -->
                                <div class="modal fade" id="model-paper-format" tabindex="-1" role="dialog"
                                    aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"> انواع تنسيق الورق</h5>
                                            </div>

                                            <form class="form"
                                                action="{{ adminUrl('orders-details/paper-format/store') }}"
                                                method="POST">
                                                <div class="modal-body">
                                                    <div class="result"></div>
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="required">نوع التنسيق</label>
                                                        <input type="text" name="name" class="form-control" required>
                                                        <small class="text-muted">انواع تنسيق للبحث</small>
                                                    </div><!-- name -->
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn-main btn-block">اضافة</button>
                                                </div>

                                            </form><!-- Form  -->

                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Academic Level Add New-->

                            </div><!-- Box Name -->

                            <hr><!-- Line -->

                            <div class="px-3 table-responsive">
                                <table class="table table-striped table-inverse table-bordered text-center mb-0">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>الاسم</th>
                                            <th>التعديل</th>
                                            <th>الحذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($papers as $paper)
                                            <tr>
                                                <td class="d-none paper-format-id">{{ $paper->id }}</td>
                                                <td class="paper-format-name">{{ $paper->name }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="papper-format-btn btn btn-outline-primary btn-sm"
                                                        data-toggle="modal" data-target="#model-edit-paper-format"><i
                                                            class="fa-solid fa-pen-to-square"></i></button>
                                                </td>
                                                <td>
                                                    <form class="delete"
                                                        action="{{ adminUrl('orders-details/paper-format/destroy') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value="{{ $paper->id }}"
                                                            required>
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                                class="fa-solid fa-trash-can"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div><!-- Box White -->
                    </div><!-- paper-format -->

                    <div class="col-12">
                        <div class="bg-white rounded border py-3">

                            <div class="px-3">
                                <span class="float-right mt-1">نوع الورق</span>
                                <button type="button" class="float-left btn btn-outline-primary btn-sm" data-toggle="modal"
                                    data-target="#model-paper-type">جديد</button>
                                <div class="clearfix"></div>

                                <!-- Modal Academic Level Add New -->
                                <div class="modal fade" id="model-paper-type" tabindex="-1" role="dialog"
                                    aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"> انواع الورق</h5>
                                            </div>

                                            <form class="form"
                                                action="{{ adminUrl('orders-details/paper-type/store') }}" method="POST">
                                                <div class="modal-body">
                                                    <div class="result"></div>
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="required">نوع الورق</label>
                                                        <input type="text" name="name" class="form-control" required>
                                                        <small class="text-muted">انواع الورق للبحث</small>
                                                    </div><!-- name -->
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn-main btn-block">اضافة</button>
                                                </div>

                                            </form><!-- Form  -->

                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Academic Level Add New-->

                            </div><!-- Box Name -->

                            <hr><!-- Line -->

                            <div class="px-3 table-responsive">
                                <table class="table table-striped table-inverse table-bordered text-center mb-0">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>الاسم</th>
                                            <th>التعديل</th>
                                            <th>الحذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($papersType as $paper)
                                            <tr>
                                                <td class="d-none paper-type-id">{{ $paper->id }}</td>
                                                <td class="paper-type-name">{{ $paper->name }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="papper-type-btn btn btn-outline-primary btn-sm"
                                                        data-toggle="modal" data-target="#model-edit-paper-type"><i
                                                            class="fa-solid fa-pen-to-square"></i></button>
                                                </td>
                                                <td>
                                                    <form class="delete"
                                                        action="{{ adminUrl('orders-details/paper-type/destroy') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value="{{ $paper->id }}"
                                                            required>
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                                class="fa-solid fa-trash-can"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div><!-- Box White -->
                    </div><!-- paper-type -->


                </div><!-- row -->
            </div><!-- Grid 2 -->


            <div class="col-xl-4 col-lg-6">
                <div class="row">

                    <div class="col-12 mb-4">
                        <div class="bg-white rounded border py-3">

                            <div class="px-3">
                                <span class="float-right mt-1">نظام الصفحات</span>
                                <div class="clearfix"></div>
                            </div><!-- Box Name -->

                            <hr><!-- Line -->


                            <div class="px-3 table-responsive">
                                <form id="form-add-order-pages" class=""
                                    action="@if (!empty($pages)) {{ adminUrl('orders-details/pages/update') }}@else{{ adminUrl('orders-details/pages/store') }} @endif"
                                    method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="required">الحد الاقصي للصفحات</label>
                                                <input type="text" name="page_limit" class="form-control" required
                                                    value="@if (!empty($pages)) {{ trim($pages->page_limit) }} @endif" />
                                            </div><!-- page_limit -->
                                        </div>

                                        <input type="hidden" name="id" required
                                            value="@if (!empty($pages)) {{ trim($pages->id) }} @endif" />


                                        <div class="col">
                                            <div class="form-group">
                                                <label class="required">سعر الصفحة ( USD )</label>
                                                <input type="text" step="any" name="price" class="form-control" required
                                                    value="@if (!empty($pages)) {{ trim(explode('.', $pages->price)[0]) }} @endif">
                                            </div><!-- page_limit -->
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-main">
                                        @if (!empty($pages))
                                            {{ 'تحديث' }}@else{{ 'اضافة' }}
                                        @endif
                                    </button>


                                </form><!-- Form  -->

                            </div>


                        </div><!-- Box White -->
                    </div><!-- pages -->


                    <div class="col-12 mb-4">
                        <div class="bg-white rounded border py-3">

                            <div class="px-3">
                                <span class="float-right mt-1">نظام المراجع</span>
                                <div class="clearfix"></div>
                            </div><!-- Box Name -->

                            <hr><!-- Line -->


                            <div class="px-3 table-responsive">
                                <form  class="form"
                                    action="@if (!empty($reviewers)) {{ adminUrl('orders-details/reviewer/update') }}@else{{ adminUrl('orders-details/reviewer/store') }} @endif"
                                    method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label class="required">الحد الاقصي للمراجع</label>
                                                <input type="text" name="page_limit" class="form-control" required
                                                    value="@if (!empty($reviewers)) {{ trim($reviewers->page_limit) }} @endif" />
                                            </div><!-- page_limit -->
                                        </div>

                                        <input type="hidden" name="id" required
                                            value="@if (!empty($reviewers)) {{ trim($reviewers->id) }} @endif" />


                                        <div class="col">
                                            <div class="form-group">
                                                <label class="required">سعر المرجع ( USD )</label>
                                                <input type="text" step="any" name="price" class="form-control" required
                                                    value="@if (!empty($reviewers)) {{ trim(explode('.', $reviewers->price)[0]) }} @endif">
                                            </div><!-- page_limit -->
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-main">
                                        @if (!empty($reviewers))
                                            {{ 'تحديث' }}@else{{ 'اضافة' }}
                                        @endif
                                    </button>


                                </form><!-- Form  -->

                            </div>


                        </div><!-- Box White -->
                    </div><!-- pages -->



                    <div class="col-12 mb-4">
                        <div class="bg-white rounded border py-3">

                            <div class="px-3">
                                <span class="float-right mt-1">التخصصات</span>
                                <button type="button" class="float-left btn btn-outline-primary btn-sm" data-toggle="modal"
                                    data-target="#model-subjects">جديد</button>
                                <div class="clearfix"></div>

                                <!-- Modal Academic Level Add New -->
                                <div class="modal fade" id="model-subjects" tabindex="-1" role="dialog"
                                    aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">التخصصات</h5>
                                            </div>

                                            <form class="form"
                                                action="{{ adminUrl('orders-details/subjects/store') }}" method="POST">
                                                <div class="modal-body">
                                                    <div class="result"></div>
                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="required">نوع التخصص</label>
                                                        <input type="text" name="name" class="form-control" required>
                                                        <small class="text-muted">نوع التخصص مثل فن , حضارة ,
                                                            فلسفة...</small>
                                                    </div><!-- name -->
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn-main btn-block">اضافة</button>
                                                </div>

                                            </form><!-- Form  -->

                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Academic Level Add New-->

                            </div><!-- Box Name -->

                            <hr><!-- Line -->

                            <div class="px-3 table-responsive">
                                <table class="table table-striped table-inverse table-bordered text-center mb-0">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>الاسم</th>
                                            <th>التعديل</th>
                                            <th>الحذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subjects as $sub)
                                            <tr>
                                                <td class="d-none subjects-id">{{ $sub->id }}</td>
                                                <td class="subjects-name">{{ $sub->name }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="subjects-btn btn btn-outline-primary btn-sm"
                                                        data-toggle="modal" data-target="#model-edit-subjects"><i
                                                            class="fa-solid fa-pen-to-square"></i></button>
                                                </td>
                                                <td>
                                                    <form class="delete"
                                                        action="{{ adminUrl('orders-details/subjects/destroy') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="id" value="{{ $sub->id }}"
                                                            required>
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                                class="fa-solid fa-trash-can"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div><!-- Box White -->
                    </div><!-- subjects -->


                </div><!-- row -->
            </div><!-- Grid 3 -->


        </div><!-- row -->
    </section><!-- section -->




    <!-- Modal subjects edit -->
    <div class=" modal fade" id="model-edit-subjects" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تعديل تخصص</h5>
                </div>
                <form id="form-edit-subjects" class="form"
                    action="{{ adminUrl('orders-details/subjects/update') }}" method="POST">
                    <div class="modal-body">
                        <div class="result"></div>
                        @csrf
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label class="required">التخصص</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <small class="text-muted">نوع التخصص مثل فن ,
                                حضارة ,
                                فلسفة...</small>
                        </div><!-- name -->

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn-main btn-block">تحديث</button>
                    </div>

                </form><!-- Form  -->
            </div>
        </div>
    </div>

    <!-- Modal services Edits -->
    <div class="modal fade" id="model-edit-services" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> تعديل انواع الورق</h5>
                </div>
                <form id="form-edit-services" class="form"
                    action="{{ adminUrl('orders-details/services/update') }}" method="POST">
                    <div class="modal-body">
                        <div class="result"></div>
                        @csrf
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label class="required">نوع الخدمة</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <small class="text-muted">نوع الخدمة مثل كتاب ,
                                تعديل
                                ابحاث...</small>
                        </div><!-- name -->

                        <div class="form-group">
                            <label class="required">السعر الخدمة <b>( USD
                                    )</b></label>
                            <input type="number" step="any" id="price" name="price" class="form-control" required>
                            <small class="text-muted">يختلف سعر كل خدمة عن
                                الاخري قم باضافة
                                سعر لكل
                                خدمة</small>
                        </div><!-- price -->

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn-main btn-block">تحديث</button>
                    </div>

                </form><!-- Form  -->
            </div>
        </div>
    </div>


    <!-- Modal Paper type Edits -->
    <div class="modal fade" id="model-edit-paper-type" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> تعديل انواع الورق</h5>
                </div>
                <form id="form-edit-paper-type" class="form"
                    action="{{ adminUrl('orders-details/paper-type/update') }}" method="POST">
                    <div class="modal-body">
                        <div class="result"></div>
                        @csrf
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label class="required">نوع التنسيق</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <small class="text-muted">انواع تنسيق للبحث</small>
                        </div><!-- name -->

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn-main btn-block">تحديث</button>
                    </div>

                </form><!-- Form  -->
            </div>
        </div>
    </div>


    <!-- Modal Academic Level Edits -->
    <div class="modal fade" id="model-edit-academic-level" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> تعديل مستوى اكاديمي</h5>
                </div>
                <form id="form-edit-academic-level" class="form"
                    action="{{ adminUrl('orders-details/academic-level/update') }}" method="POST">
                    <div class="modal-body">
                        <div class="result"></div>
                        @csrf
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label class="required">نوع المستوي</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <small class="text-muted">المستوي الاكاديمي (
                                الدراسي ) مثل دكتوراه ,
                                كليات...</small>
                        </div><!-- name -->

                        <div class="form-group">
                            <label class="required">السعر للمستوي <b>( USD
                                    )</b></label>
                            <input type="number" step="any" id="price" name="price" class="form-control">
                            <small class="text-muted">يختلف سعر كل مستوي عن
                                الاخر قم باضافة سعر لكل
                                مستوي</small>
                        </div><!-- price -->

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn-main btn-block">تحديث</button>
                    </div>

                </form><!-- Form  -->
            </div>
        </div>
    </div>

    <!-- Modal Paper Format Edits -->
    <div class="modal fade" id="model-edit-paper-format" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> تعديل اسلوب كتابة المراجع </h5>
                </div>
                <form id="form-edit-paper-format" class="form"
                    action="{{ adminUrl('orders-details/paper-format/update') }}" method="POST">
                    <div class="modal-body">
                        <div class="result"></div>
                        @csrf
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label class="required">نوع اسلوب كتابة المرجع</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div><!-- name -->

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn-main btn-block">تحديث</button>
                    </div>

                </form><!-- Form  -->
            </div>
        </div>
    </div>



@endsection
