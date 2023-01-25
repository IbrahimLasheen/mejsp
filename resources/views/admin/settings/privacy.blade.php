@extends('admin.layouts.master')
@section('title', 'سياسة الخصوصية')
@section('content')

    <div class="links-bar my-4 ">
        <h4>سياسة الخصوصية</h4>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div class="privacy">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="box-white">

                    <form action="@if ($row != null) {{ admin_url('privacy/update') }} @else {{ admin_url('privacy/create') }} @endif" method="POST" enctype="multipart/form-data">
                        @error('content')
                            <div class=" alert alert-danger">{{ $message }}</div>
                        @enderror
                        <textarea name="content" id="privacy" cols="30" rows="10">
                            @if ($row != null)
                                {{ $row->content }}
                            @endif
                        </textarea>
                        @csrf
                        <button type="submit" class="mb-0 mt-3 btn-main">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor-5.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#privacy'))
            .catch(error => {
                console.error(error);
            });
    </script>
    @if (session()->has('success'))
        <script>
            toastr.options.timeOut = 2000;
            toastr.options.progressBar = true;
            toastr.success("{{ session()->get('success') }}");
        </script>
    @endif

@endsection
