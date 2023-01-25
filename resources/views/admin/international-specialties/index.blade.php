@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')

    <div class="links-bar">
        <h4>{{ $pageTitle }}</h4>
    </div><!-- End Bar Links -->

    <section>
        <div class="row justify-content-center">

            <div class="col-12">
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
                    <form action="{{ $formUrl }}" method="POST">


                        <div class="form-group">
                            <label class="required">النشر الدولى</label>
                            <select name="type" class=" form-control">
                                <option disabled selected></option>
                                @foreach ($types as $ty)
                                    <option @if (!empty($row) && $row->type->id == $ty->id) {{ 'selected' }} @endif
                                        value="{{ $ty->id }}">{{ $ty->type }}</option>
                                @endforeach
                            </select>
                            
                            @error('type')
                                <div class=" alert-error">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">اذا كان لا يتوفر نوع النشر الدولي المطلوب يمكنك اضافة نوع جديد من
                                <a href="{{ adminUrl('international-publishing/types-of-publication') }}">هنا</a></small>
                        </div>

                        <div class="form-group">
                            <label class="required">التخصص</label>
                            <input type="text" name="specialty" class="form-control"
                                value="@empty(!$row) {{ $row->specialty }} @endempty">
                            @error('specialty')
                                <div class=" alert-error">{{ $message }}</div>
                            @enderror
                            <input type="hidden" name="id"
                                value="@empty(!$row) {{ $row->id }} @endempty" />

                            <small class="text-muted">نوع النشر الدولي يستخدم في تنظيم التخصصات والمجلات الخاص فقط
                                بالنشر الدولي</small>
                        </div>

                        @csrf
                        <button type="submit" class=" btn-main">{{ $btnText }}</button>
                    </form>
                </div>
            </div>




            <div class="col-lg-8">
                <div class="box-white table-responsive">
                    <table class="table table-striped table-inverse table-bordered text-center mb-0">
                        <thead class="thead-inverse">
                            <tr>
                                <th>التخصص</th>
                                <th>نوع النشر الدولى</th>
                                <th>التعديل</th>
                                <th>الحذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($specialties as $sp)
                                <tr>
                                    <td>{{ $sp->specialty }}</td>
                                    <td>{{ $sp->type->type }}</td>

                                    <td>
                                        <a href="?id={{ $sp->id }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                    <td>
                                        <form class="delete"
                                            action="{{ adminUrl('international-publishing/specialties/destroy') }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $sp->id }}" />
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
