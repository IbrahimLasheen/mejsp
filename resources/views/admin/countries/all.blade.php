@extends('admin.layouts.master')
@section('title', 'الدول')
@section('content')

    <div class="links-bar my-4 ">
        <h4 class=" float-right">الدول</h4>
        <!-- Button trigger modal -->
        <button type="button" class="btn-main float-left mb-0 btn-sm" data-toggle="modal" data-target="#model-add-category">
            دولة جديدة
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
                            <th>اسم الدولة</th>
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
                                    <button type="button" class="btn btn-outline-primary btn-sm edit-category" data-toggle="modal" data-target="#model-edit-category">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                </td><!-- Edit -->

                                <td>
                                    <form class="delete" action="{{ adminUrl("countrie/destroy") }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $row->id }}">
                                        <button type="submit" data-toggle="tooltip" title="حذف"
                                            class="btn btn-outline-danger btn-sm toast-title "><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </td><!-- Delete -->

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn-main mb-5 mt-3 btn-sm" data-toggle="modal" data-target="#model-add-category">
                دولة جديدة
            </button>
        </div><!-- End Col -->

    </div>



    <!-- Modals -->
    <div class="modal fade" id="model-add-category" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-add-catrgory" action="{{ adminUrl('countrie/store') }}" method="POST" autocomplete="off">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">اضافة دولة جديدة</h5>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="result"></div>
                        <div class="form-group">
                            <label>اسم الدولة</label>
                            <input type="text" name="name" class="form-control" required />
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
            <form id="form-edit-catrgory" action="{{ adminUrl('countrie/update') }}" method="POST" autocomplete="off">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">تعديل دولة</h5>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="result"></div>
                        <div class="form-group">
                            <label>اسم الدولة</label>
                            <input type="text" name="name" id="name" class="form-control" required />
                            <input type="hidden" value="" id="id" name="id">
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
