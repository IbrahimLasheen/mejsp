@extends('admin.layouts.master')
@section('title', 'الشهادات')
@section('content')

    <div class="links-bar my-4 ">
        <h4 class=" float-right">الشهادات</h4>
        <!-- Button trigger modal -->
        <button type="button" class="btn-main float-left mb-0 btn-sm" data-toggle="modal" data-target="#model-add-category">
            اضافة شهادة
        </button>
        <div class="clearfix"></div>
    </div><!-- End Bar Links -->

    <div id="all-articles" class="row justify-content-center">
        <div class="col-lg-7">
            <div class="box-white table-responsive">
                <table class="table table-striped table-inverse mb-0 table-bordered  text-center">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>اسم الفئة</th>
                            <th>السعر</th>
                            <th>التعديل</th>
                            <th>الحذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $row)
                        
                            <tr class="category-tr">
                                <td class="c_id">{{ $row->id }}</td>
                                <td class="c_name">{{ $row->name }}</td>
                                <td>
                                    $<span class="c_price">{{ $row->price }}</span>
                                </td>
                                <td>
                                    <button data-without_research="@if ($row->without_research == 1){{ "1" }}@else{{ "0" }}@endif" type="button" class="btn btn-outline-primary btn-sm edit-category" data-toggle="modal" data-target="#model-edit-category">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                </td><!-- Edit -->

                                <td>
                                    <form class="form-delete-category delete" action="{{ adminUrl("conference/category/destroy") }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $row->id }}">
                                        <button type="submit" data-toggle="tooltip" title="حذف"
                                            class="btn btn-outline-danger btn-sm toast-title btn-delete-category"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td><!-- Delete -->

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn-main mb-5 mt-3 btn-sm" data-toggle="modal" data-target="#model-add-category">
                اضافة شهادة
            </button>
        </div><!-- End Col -->

    </div>

    <!-- Modals -->
    <div class="modal fade" id="model-add-category" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-add-catrgory" action="{{ adminUrl('conference/category/store') }}" method="POST" autocomplete="off">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"> اضافة شهادة جديدة</h5>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="result"></div>

                        <div class="form-group">
                            <label class="required">اسم فئة المؤتمر</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>

                        <div class="form-group">
                            <label class="required">السعر ( بالدولار )</label>
                            <input type="number" name="price" class="form-control" required />
                        </div>

                        <div class="form-group mb-1">
                            <input type="checkbox" name="without_research" id="without_research" />
                            <label class="required mr-1" for="without_research">يلزم تقديم بحث ؟</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-main btn-block">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="model-edit-category" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-edit-catrgory" class="ajax" action="{{ adminUrl('conference/category/update') }}" method="POST" autocomplete="off">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">تعديل الشهادة</h5>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="result"></div>
                        <div class="form-group">
                            <label>اسم الفئة</label>
                            <input type="text" name="name" id="name" class="form-control" required />
                            <input type="hidden" value="" id="id" name="id">
                        </div>

                        <div class="form-group">
                            <label class="required">السعر ( بالدولار )</label>
                            <input type="number" id="price" name="price" class="form-control" required />
                        </div>
                        
                        <div class="form-group mb-1">
                            <input type="checkbox" name="without_research" id="update_without_research"  />
                            <label class="required mr-1" for="update_without_research">يلزم تقديم بحث ؟</label>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-main btn-block">تحديث</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
