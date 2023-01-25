@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')

    <div class="links-bar">
        <h4>{{ $pageTitle }}</h4>
    </div><!-- End Bar Links -->

    <section>
        <div class="row justify-content-center">

            <div class="col-12">
                <div class="result"></div>
                @if (session()->has('success'))
                    <div class="alert  box-success alert-dismissible fade show" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert  box-error alert-dismissible fade show" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

            </div><!-- Result --->



            <div class="col-lg-4">
                <div class="box-white">
                    <form id="form-add-international-publishing-journals" class="form"
                        action="{{ $formUrl }}" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="required">النشر الدولى</label>
                            <select name="type" id="select-type" class=" form-control" required>
                                <option disabled selected></option>
                                @foreach ($types as $ty)
                                    <option @if (!empty($row) && $row->specialty->type_id == $ty->id) {{ 'selected' }} @endif
                                        value="{{ $ty->id }}">{{ $ty->type }}</option>
                                @endforeach
                            </select>
                        </div><!-- type -->


                        <div class="form-group">
                            <label class="required">التخصص</label>
                            <select name="specialty" id="select-specialty" class=" form-control" required>
                                @isset($_GET['id'])
                                    @foreach ($specialties as $sp)
                                        <option @if (!empty($row) && $row->specialty_id == $sp->id) {{ 'selected' }} @endif
                                            value="{{ $sp->id }}">{{ $sp->specialty }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div><!-- specialty -->





                        <div class="form-group">
                            <label class=" required">المجلة</label>
                            <input type="text" name="name" class="form-control"
                                value="@empty(!$row) {{ $row->name }} @endempty" required>


                        </div><!-- name -->

                        <input type="hidden" name="id"
                            value="@empty(!$row) {{ $row->id }} @endempty">


                        <div class="form-group">
                            <label class=" required">رسوم النشر</label>
                            <input type="number" step="any" name="price" class="form-control"
                                @empty(!$row) {{ 'value=' . $row->price }} @endempty required>
                        </div><!-- price -->




                        <div class="form-group">
                            <label>شعار المجلة</label>
                            <input type="file" accept="image/*" name="logo" class="form-control">
                        </div><!-- logo -->


                        @csrf
                        <button type="submit" class=" btn-main">{{ $btnText }}</button>

                    </form>
                </div>
            </div>




            <div class="col-lg-8">
                <div class="box-white table-responsive">
                    <table class="table table-striped table-inverse table-bordered text-center mb-0 table-with-avatar">
                        <thead class="thead-inverse">
                            <tr>
                                <th>شعار المجلة</th>
                                <th>المجلة</th>
                                <th>رسوم النشر</th>
                                <th>التعديل</th>
                                <th>الحذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($journals as $jour)
                                <tr>
                                    <td>
                                        @if (!empty($jour->logo))
                                            @if (file_exists(public_path("assets/uploads/international-journals/$jour->logo")))
                                                <img class="rounded"
                                                    src="{{ asset("assets/uploads/international-journals/$jour->logo") }}">
                                            @else
                                                <small>لا يوجد</small>
                                            @endif
                                        @else
                                            <small>لا يوجد</small>
                                        @endif
                                    </td>
                                    <td>{{ $jour->name }}</td>
                                    <td>${{ $jour->price }}</td>
                                    <td>
                                        <a href="?id={{ $jour->id }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                    <td>
                                        <form class="delete"
                                            action="{{ adminUrl('international-publishing/journals/destroy') }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $jour->id }}" />
                                            <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
    </section>


@endsection
