{{ $getSpinner = '' }}
@extends('admin.layouts.master')
@section('title', 'مكتبة الوسائط')
@section('content')

    <div class="my-3">
        <h4 class=" float-right">مكتبة الوسائط</h4>
        <a href="{{ adminUrl('media-library/create') }}" class=" float-left btn btn-primary">اضافة صور</a>
        <div class="clearfix"></div>
    </div>

    <section id="media">
        <div class="row">

            <div class="col-12">
                @if (session()->has('deleteMessage'))
                    <div class="alert  box-success alert-dismissible fade show" role="alert">
                        {{ session()->get('deleteMessage') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>


            @foreach ($media as $row)
                <div class="col-xl-2 col-lg-4 col-md-4 col-6 mb-4">

                    <input type="text" id="imgName{{ $loop->index }}" class="inputImgName"
                        value="{{ asset('assets/uploads/media-library/' . $row->image) }}">

                    <div data-clipboard-target="#imgName{{ $loop->index }}" class="images box-white p-1">
                        <img class=" cover img-fluid lazy"
                            data-src="{{ asset('assets/uploads/media-library/' . $row->image) }}">
                    </div>
                    <form class="delete" method="POST" action="{{ adminUrl('media-library/destroy') }}"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{ $row->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete"><i class="fa-solid fa-trash-can"></i></button>
                    </form>



                </div>
            @endforeach

            <div class="col-12">
                {{ $media->onEachSide(5)->links() }}
            </div>

        </div>
    </section>

@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
@endsection
