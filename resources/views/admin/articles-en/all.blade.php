@extends('admin.layouts.master')
@section('title', 'Articles')
@section('content')

    <div class="links-bar">
        <h4>Articles</h4>
    </div><!-- End Bar Links -->

    <div style="direction: ltr" id="all-articles" class="row">

        @if (count($articles) > 0)


            <div class="col-12">
                @if (session()->has('statusMsg'))
                    <div class="alert  box-success alert-dismissible fade show" role="alert">
                        {{ session()->get('statusMsg') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="box-white p-2 mb-4">
                    <div class="row">

                        <div class="col-md-6 col-3 ">
                            <div class="btn-group mt-1 toast-title float-left" data-toggle="tooltip" data-placement="top"
                                title="Search by article status">

                                <button class=" btn-main pb-1 dropdown-toggle" type="button" id="triggerId"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter"></i>
                                </button>

                                <div class="dropdown-menu text-left dropdown-menu-left" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="{{ admin_url('en/articles?status=active') }}">Active</a>
                                    <a class="dropdown-item" href="{{ admin_url('en/articles?status=in-active') }}">Inactive</a>
                                </div>
                            </div>
                        </div><!-- Filter Buttons -->

                        <div class="col-md-6 col-9">
                            <form action="{{ admin_url('en/articles') }}" method="GET">
                                <input type="text" name="search" class="form-control text-left form-control-sm"
                                    placeholder="Search by article name"
                                    value='@isset($_GET['search']) {{ $_GET['search'] }} @endisset' />
                            </form>
                        </div><!-- seach -->

                    </div><!-- row -->

                </div><!-- box -->
            </div><!-- Search Bar -->

            @foreach ($articles as $row)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <div  class="box-white p-2 article">

                        @if (file_exists(public_path("assets/uploads/thumbnails/articles-en/$row->image")))
                            <img class="rounded"
                                src="{{ asset("assets/uploads/thumbnails/articles-en/$row->image") }}">
                        @else
                            <img class="rounded" src="{{ asset('assets/images/article-defualt.jpg') }}">
                        @endif
                        <h5 class=" mt-2 mb-0 text-left">{{ Str::substr($row->title, 0, 75) }}...</h5>
                        <!-- Start Actions -->
                        <div class="btn-group article-dropdown">
                            <button class="dropdown-toggle " type="button" id="triggerId" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right text-left" aria-labelledby="triggerId">
                                <form action="{{ adminUrl('en/article/status') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ Crypt::encryptString($row->id) }}" required>
                                    <button type="submit" class="dropdown-item bg-transparent text-left">
                                        @if ($row->status == 1)
                                            Deactivate
                                        @else
                                            Activate
                                        @endif
                                    </button>
                                </form>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ adminUrl("en/article/edit/$row->id") }}">Edit</a>
                                <div class="dropdown-divider"></div>
                                <form class="delete" action="{{ adminUrl('en/article/destroy') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ Crypt::encryptString($row->id) }}" required>
                                    <button type="submit" class="dropdown-item bg-transparent text-left">Delete</button>
                                </form>
                            </div>
                        </div>
                        <!-- End Actions -->
                    </div>
                </div>
            @endforeach

            <div class="col-12">
                {{ $articles->onEachSide(5)->links() }}
            </div>
        @else
            <div class="col-12">
                <div class="box-white py-5 text-center">
                    <h4 class=" mb-4 text-center">There are no articles to display!</h4>
                    <a href="{{ adminUrl('en/article/create') }}" class="mt-3  btn-main btn-sm">Add New</a>
                </div>
            </div>
        @endif
    </div>

@endsection
