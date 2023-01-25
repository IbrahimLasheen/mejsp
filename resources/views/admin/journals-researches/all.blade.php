@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')


    <h4 class=" float-right mt-3">
        {{ $pageTitle }}</h4>
    <a href="{{ adminUrl('researches/create') }}" class=" btn-main btn-sm float-left mt-2">اضافة بحث</a>
    <div class="clearfix"></div>
    <div class="result"></div><!-- Result Box -->


    <section id="journals-researches" class="mb-5 mt-3">
        <div class="row justify-content-center">

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



            <div class="col-lg-4 mb-4">
                <div class="box-white px-0">
                    <h5 class="px-3 float-right">حدد بحثك</h5>
                    <a href="{{ adminUrl('researches') }}" class="ml-3 border btn btn-light btn-sm float-left pl-0 mb-0"><i
                            class="fa-solid fa-arrow-rotate-right"></i></a>
                    <div class="clearfix"></div>
                    <hr>
                    <form class="px-3" action="" method="GET">
                        <div class="form-group">
                            <label>عنوان البحث</label>
                            <input type="text" name="title"
                                value="@isset($_GET['title']) {{ trim($_GET['title']) }} @endisset"
                                class="form-control">
                        </div>


                        <div class="form-group">
                            <label>اختر المجلة</label>
                            <select id="select-journal" name="journal" class="form-control">
                                <option selected></option>
                                @foreach ($journals as $jour)
                                    <option @if (isset($_GET['journal']) && $jour->id == $_GET['journal']) {{ 'selected' }} @endif
                                        value="{{ $jour->id }}">{{ $jour->name }}</option>
                                @endforeach
                            </select>
                        </div><!-- journal -->

                        <div class="form-group">
                            <label>اختر الاصدار</label>
                            <select id="select-version" name="version" class="form-control">
                                <option selected></option>
                                @foreach ($versions as $ver)
                                    <option @if (isset($_GET['version']) && $_GET['version'] == $ver->id) {{ 'selected' }} @endif
                                        value="{{ $ver->id }}">
                                        @if ($ver->old_version != null)
                                            {{ $ver->old_version }}
                                        @else
                                            الإصدار
                                            {{ $ver->version }} : {{ $ver->year }}
                                            {{ $ver->month }}
                                            {{ $ver->day }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div><!-- version -->


                        <button type="submit" class="btn-main">بحث</button>
                    </form>
                </div>
            </div>


            @if (count($researches) > 0)
                <div class="col-lg-8">
                    <div class="row">
                        @foreach ($researches as $row)
                            <div class="col-12 mb-4">
                                <div class="box-white pl-4"  @if(strlen($row->title) == strlen(utf8_decode($row->title))) style="text-align:end" @endif>
                                    <a href="" class=" title " @if(strlen($row->title) == strlen(utf8_decode($row->title))) style="text-align:end;direction:ltr;margin-left: 2%;" @endif>{{ $row->title }}</a>
                                    <div class="mb-2 mt-3" @if(strlen($row->author_name) == strlen(utf8_decode($row->author_name))) style="text-align:left ;direction:ltr" @endif><i class="fa-solid fa-user"></i>{{ $row->author_name }}
                                    </div>
                                    <div class="mb-2"><i
                                            class="fa-solid fa-book-open "></i>{{ $row->journal->name }}
                                    </div>
                                    <div class="mb-2"><i class="fa-solid fa-code-fork"></i>
                                        @if ($row->version->old_version != null)
                                            {{ $row->version->old_version }}
                                        @else
                                            الإصدار
                                            {{ $row->version->version }} : {{ $row->version->year }}
                                            {{ $row->version->month }}
                                            {{ $row->version->day }}
                                        @endif
                                    </div>
                                    <div class="mb-2"><i class="fa-solid fa-money-bill"></i>
                                        @if ($row->price == null)
                                            {{ 'مجاني' }}
                                        @else
                                            {{ "$" . $row->price }}
                                        @endif
                                    </div>
                                    <div><i class="fa-solid fa-file-pdf"></i>
                                        {{-- checkFile('assets/uploads/journals-researches/' . $row->file) --}}
                                        @if ($row->file && checkFile('assets/uploads/journals-researches/' . $row->file))
                                            <a target="__blank"
                                                href="{{ asset('assets/uploads/journals-researches/' . $row->file) }}"
                                                class="text-dark">عرض البحث</a>
                                        @else
                                            <small class=" font-weight-bold text-danger">لا يوجد ملف !</small>
                                        @endif
                                    </div>

                                    <div class="dropdown open ">
                                        <button class="dropdown-toggle " type="button" id="triggerId" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu text-right" aria-labelledby="triggerId">
                                            <a class="dropdown-item"
                                                href="{{ adminUrl('researches/edit/' . $row->id) }}">تعديل</a>

                                            <div class="dropdown-divider"></div>

                                            <form class="dropdown-item delete d-inline-block"
                                                action="{{ adminUrl('researches/destroy') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $row->id }}" required>
                                                <button type="submit" class="d-block w-100 text-right">حذف</button>
                                            </form>

                                        </div>
                                    </div><!-- Controls -->
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12 mb-4">
                            {{ $researches->links() }}
                        </div>

                    </div>
                </div>
            @else
                <div class="col-lg-8">
                    <div class="box-white py-5">
                        <h5 class=" text-center">لم يتم العثور علي ابحاث !</h5>
                    </div>
                </div>
            @endif
        </div>
    </section>




@endsection
