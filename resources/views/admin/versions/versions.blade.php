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

    <div class="result"></div>



    <section id="journals">
        <div class="row">

            <div class="col-lg-4 mb-4">
                <form class="form" action="{{ $formUrl }}" method="POST">
                    <div class="box-white">

                        @csrf

                        <div class="form-group">
                            <label class="required float-right mt-1">المجلة</label>
                            @if (isset($_GET['do']) && $_GET['do'] == 'edit')
                                <a href="{{ adminUrl('versions') }}" class="btn btn-light float-left btn-sm mb-3"> الخروج
                                    من
                                    التعديل <i class="fa-solid fa-reply"></i></a>
                            @endif
                            <div class="clearfix"></div>
                            <select name="journals" class="form-control">
                                <option disabled selected>اختر المجلة</option>
                                @foreach ($journals as $jour)
                                    <option @if (!empty($editRow) && $jour->id == $editRow->journal_id) {{ 'selected' }} @endif
                                        value="{{ $jour->id }}">{{ $jour->name }}</option>
                                @endforeach
                            </select>
                        </div><!-- journals -->


                        <input type="hidden" name="id"
                            value="@if ($editRow != null) {{ $editRow->id }} @endif">



                        <div class="form-group">
                            <label>رقم االإصدار</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text input-group-text-rtl ">الإصدار</div>
                                </div>
                                <input type="text" name="version" class="form-control form-control-rtl"
                                    placeholder="قم باضافة اسم الاصدار فقط مثل ( الاول )"
                                    value="@if ($editRow != null) @if ($editRow->version != null){{ $editRow->version }}@else{{ $editRow->old_version }} @endif @endif"
                                    required />
                            </div>
                        </div><!-- version -->

                        <div class="row">

                            <div class="col-4 pl-1">
                                <div class="form-group">
                                    <label class="required">السنه</label>
                                    <select name="year" class="form-control" id="years">
                                        <option disabled selected></option>
                                        @for ($year = date('Y'); $year < date('Y') + 5; $year++)
                                            <option
                                                @if ($editRow != null) @if ($editRow->year == $year){{ 'selected' }} @endif
                                                @endif value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>

                            </div><!-- year -->


                            <div class="col-4 px-1">
                                <div class="form-group">
                                    <label class="required">الشهر</label>
                                    <select name="month" class="form-control" id="month">
                                        <option disabled selected></option>
                                        @foreach ($months as $key => $month)
                                            <option
                                                @if ($editRow != null) @if ($editRow->month == $month){{ 'selected' }} @endif
                                                @endif value="{{$key + 1}}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- month -->


                            <div class="col-4 pr-1">
                                <div class="form-group">
                                    <label class="required">اليوم</label>
                                    <input type="number" name="day" class="form-control" required
                                        value="@if ($editRow != null){{$editRow->day}}@endif" />
                                </div>
                            </div><!-- day -->

                        </div>

                        <button type="submit" class=" btn-block {{ $buttonStyle }}"> {{ $buttonText }}</button>

                    </div>
                </form>
            </div>



            <div class="col-lg-8">
                <div class="row">


                    @if ($count_old_version > 0)
                        @if (count($versions) > 0)
                            <div class="col-12 mb-4">
                                <div class="alert alert-danger text-center shadow">هذه الاصدارات قديمة , يجب تعديلها لتتناسب
                                    مع
                                    النظام الجديد!</div>
                                <div class="box-white table-responsive border-danger">

                                    <table class="table table-striped table-inverse mb-0 table-bordered table-with-avatar">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>#</th>
                                                <th>رقم الإصدار</th>
                                                <th>المجلة</th>
                                                <th>التحكم</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($versions as $row)
                                                @if ($row->old_version != null)
                                                    <tr>
                                                        <td>{{ $row->id }}</td>
                                                        <td>{{ $row->old_version }}</td>
                                                        <td>{{ $row->journal->name }}</td>
                                                        <td class=" text-center">
                                                            <a href="?do=edit&type=old&id={{ $row->id }}"
                                                                class="btn btn-primary shadow btn btn-sm"><i
                                                                    class="fa-solid fa-pen-to-square"></i></a>

                                                                    <form class="delete d-inline-block"
                                                                    action="{{ adminUrl('versions/destroy') }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="id"
                                                                        value="{{ Crypt::encryptString($row->id) }}" required>
                                                                    <button type="submit"
                                                                        class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                                                </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        @endif
                        <!-- Old Versions -->
                    @endif

                    @if (count($versions) > 0)
                        <div class="col-12 mb-4">
                            <div class="box-white table-responsive">
                                <table class="table table-striped table-inverse mb-0 table-bordered">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>#</th>
                                            <th>رقم الإصدار</th>
                                            <th>المجلة</th>
                                            <th class=" text-center">التحكم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($versions as $row)
                                            @if ($row->old_version == null)
                                                <tr>
                                                    <td>{{ $row->id }}</td>
                                                    <td>الإصدار
                                                        {{ $row->version }} : {{ $row->day }}
                                                         @if(intval($row->month) != 0 ) {{$months_names[intval($row->month) - 1]}} @else  {{$row->month}} @endif
                                              
                                                        {{ $row->year }}
                                                    </td>
                                                    <td>{{ $row->journal->name }}</td>
                                                    <td class=" text-center">

                                                        <a href="?do=edit&id={{ $row->id }}"
                                                            class="btn btn-primary btn btn-sm"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>

                                                        <form class="delete d-inline-block"
                                                            action="{{ adminUrl('versions/destroy') }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="id"
                                                                value="{{ Crypt::encryptString($row->id) }}" required>
                                                            <button type="submit"
                                                                class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="box-white py-5 text-center">
                                <h4 class=" text-center">لا توجد اصدارات للعرض !</h4>
                            </div>
                        </div>
                    @endif
                    <!-- New Versions -->


                    <div class="col-12">
                        {{ $versions->links() }}
                    </div>


                </div>
            </div><!-- End Grid 2 -->


        </div>
    </section>




@endsection
