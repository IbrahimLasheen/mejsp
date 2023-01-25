@extends('admin.layouts.master')
@section('title', 'التخصصات')
@section('content')



    <div class=" mt-4 mb-3 ">
        <h4 class=" float-right">التخصصات</h4>
        <a href="{{ adminUrl('freelancers') }}" class=" float-left btn btn-primary btn-sm">الكاتبون</a>
        <div class="clearfix"></div>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div id="">
        <div class="row justify-content-center">

            @if (session()->has('success'))
                <div class="col-12">
                    <div class="alert box-success alert-dismissible fade show" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            <!-- success message Added --->


            <div class="col-lg-4">
                <div class="box-white">
                    <form action="{{ adminUrl('freelancers/specialty/store') }}" method="POST">

                        <div class="form-group">
                            <label>اسم التخصص</label>
                            <input type="text" name="name" class="form-control" required>
                            @error('name')
                                <div class="alert-error">{{ $message }}</div>
                            @enderror
                        </div>
                        @csrf
                        <button type="submit" class=" btn-main">اضافة</button>

                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="box-white table-responsive">
                    <table class="table table-striped table-with-avatar table-inverse text-center table-bordered mb-0">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>التحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>
                                        <form action="{{ adminUrl('freelancers/specialty/delete') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $row->id }}" required>
                                            <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                                    class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div><!-- row -->
    </div><!-- freelancers -->

    
@endsection
