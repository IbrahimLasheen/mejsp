@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')

    <div class="links-bar">
        <h4 class="">{{ $pageTitle }}</h4>
    </div><!-- End Bar Links -->


    @if (session()->has('statusMsg'))
        <div class="alert  box-success alert-dismissible fade show" role="alert">
            {{ session()->get('statusMsg') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <section id="journals">
        <div class="row">

            @forelse ($journals as $row)
                <div class="col-lg-4 mb-4">
                    <div class="box-white p-1">
                        
                        @if (checkFile('assets/uploads/journals/' . $row->cover))
                            <div style="background-image: url({{ asset('assets/uploads/journals/' . $row->cover) }})"
                                class="cover"></div>
                        @else
                            <div style="background-image: url({{ asset('assets/images/notfound.png') }});"
                                class="cover"></div>
                        @endif


                        <div class="logo">
                            @if (checkFile('assets/uploads/journals/' . $row->logo))
                                <img src="{{ asset('assets/uploads/journals/' . $row->logo) }}">
                            @else
                                <img src="{{ asset('assets/images/404-icon.png') }}">
                            @endif
                        </div><!-- logo -->
                        <h6 class=" text-center">{{ $row->name }}</h6>

                        <!-- Start Actions -->
                        <div class="btn-group article-dropdown action-dropdown">
                            <button class="dropdown-toggle " type="button" id="triggerId" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right text-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="{{ adminUrl("journals/edit/$row->id") }}">تعديل</a>
                                <div class="dropdown-divider"></div>
                                <form class="delete" action="{{ adminUrl('journals/destroy') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ Crypt::encryptString($row->id) }}" required>
                                    <button type="submit" class="dropdown-item bg-transparent text-right">حذف</button>
                                </form>
                            </div>
                        </div>
                        <!-- End Actions -->


                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="box-white py-5 text-center">
                        <h4 class=" mb-4 text-center">لا توجد مجلات للعرض !</h4>
                        <a href="{{ adminUrl('journals/create') }}" class="mt-3  btn-main btn-sm">اضف الان</a>
                    </div>
                </div>
            @endforelse




        </div>
    </section>




@endsection
