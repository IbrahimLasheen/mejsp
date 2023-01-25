@extends('admin.layouts.master')
@section('title', 'الاعتمادات الدولية')
@section('content')

    <div class="links-bar my-4 ">
        <h4>الاعتمادات الدولية</h4>
    </div><!-- End Bar Links -->

    @if (session()->has('success'))
        <div class="alert  box-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <div id="international-credits" class="row justify-content-center">

        <div class="col-lg-4">
            <div class="box-white ">
                <form class="form " action="{{ adminUrl('international/store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required">الصورة</label>
                        <input type="file" name="image" accept="image/*" class="form-control" required />
                    </div>

                    <div class="form-group">
                        <label class="required">اختر المجلة</label>
                        <select name="journal" id="" class="form-control">
                            <option disabled selected></option>
                            @foreach ($journals as $jour)
                                <option value="{{ $jour->id }}">{{ $jour->name }}</option>
                            @endforeach
                        </select>
                    </div>



                    <button type="submit" class="btn-main">اضافة</button>


                </form>
            </div>
        </div>
        <div class="col-lg-8">
            @if (count($rows) > 0)
                <div class="box-white table-responsive">
                    <table class="table table-striped table-inverse mb-0 table-bordered  text-center table-with-avatar">
                        <thead class="thead-inverse">
                            <tr>
                                <th>الصورة</th>
                                <th>المجلة</th>
                                <th>الحذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr class="category-tr">
                                    <td>
                                        @if (checkFile('assets/uploads/international-credits/' . $row->image))
                                            <img
                                                src="{{ asset('assets/uploads/international-credits/' . $row->image) }}" />
                                        @else
                                            <img src="{{ asset('assets/images/notfound.png') }}" />
                                        @endif

                                    </td>
                                    <td>{{ $row->journal->name }}</td>
                                    <td>
                                        <form class="form-delete-category delete"
                                            action="{{ adminUrl('international/destroy') }}" method="POST">
                                            @csrf
                                            @method("DELETE")
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
            @else
                <div class="box-white py-5">
                    <h4 class="mb-0 text-center">لا توجد بيانات !</h4>
                </div>
            @endif
        </div><!-- End Col -->

    </div>




@endsection
