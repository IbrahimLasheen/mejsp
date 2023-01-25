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
                            <label class="required">نوع النشر الدولى</label>
                            <input type="text" name="type" class="form-control"
                                value="@empty(!$row) {{ $row->type }} @endempty">
                            @error('type')
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




            <div class="col-lg-4">
                <div class="box-white table-responsive">
                    <table class="table table-striped table-inverse table-bordered text-center mb-0">
                        <thead class="thead-inverse">
                            <tr>
                                <th>نوع النشر الدولى</th>
                                <th>التعديل</th>
                                <th>الحذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($types as $ty)
                                <tr>
                                    <td>{{ $ty->type }}</td>
                                    <td>
                                        <a href="?id={{ $ty->id }}" class="btn btn-primary btn-sm"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                    <td>
                                        <form class="delete"
                                            action="{{ adminUrl('international-publishing/types/destroy') }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $ty->id }}" />
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
