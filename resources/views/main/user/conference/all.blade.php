@extends('main.layouts.master')
@section('title', $pageTitle)
@section('content')

    <section id="section" class="py-5">
        <div class="container">
            <div class="row">

                <div class="col-12 mb-4">
                    <h5 class="page-name">{{ $pageTitle }}</h5><!-- Page Name -->
                </div>

                <!-- Include Aside -->
                @include('main.user.aside')


                <div class="col-lg-9">



                    <div class="row">
                        <div class="col-12 mb-3">
                            <h5 class=" float-right">طلباتي</h5>
                            <a href="{{ userUrl('conference/create') }}" class="btn-main float-left">طلب جديد</a>
                        </div>


                        @if (count($conferences) > 0)

                            @foreach ($conferences as $row)
                                <div class="col-lg-12 mb-4">
                                    <div class="box-white px-0">
                                        <h6 class=" px-3 float-right mt-1">تفاصيل الطلب</h6>
                                        <div class="controls float-left pl-3">
                                            @if ($row->payment_response == 0)
                                                <a href="{{ userUrl('conference/edit/' . $row->id) }}"
                                                    class="btn btn-outline-primary btn-sm"><i
                                                        class="fa-solid fa-pen"></i></a>
                                            @endif

                                            <form class="delete float-left" action="{{ userUrl('conference/destroy') }}"
                                                method="POST">
                                                <input type="hidden" value="{{ $row->id }}" name="id">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class=" btn btn-outline-danger btn-sm mr-2">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>

                                        <div class="px-3 mb-3">
                                            <span class=" float-right text-secondary">نوع الشهادة</span>
                                            <span class=" float-left">{{ $row->confCategory->name }}</span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <!---->

                                        <div class="px-3 mb-3">
                                            <span class=" float-right text-secondary">عنوان البحث</span>
                                            <span class=" float-left">{{ $row->research_title }}</span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <!---->


                                        <div class="px-3 mb-3">
                                            <span class=" float-right text-secondary">سعر المؤتمر</span>
                                            <span class=" float-left">${{ $row->confCategory->price }}</span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <!---->

                                        <div class="px-3 mb-3">
                                            <span class=" float-right text-secondary">حالة الدفع</span>
                                            <span class=" float-left">
                                                @if ($row->payment_response > 0)
                                                    <span class=" text-success"><i
                                                            class="fa-solid fa-circle-check"></i></span>
                                                    {{ 'مدفوع' }}
                                                @else
                                                    {{ 'غير مدفوع' }}
                                                @endif
                                            </span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <!---->


                                        <div class="px-3">
                                            <span class=" float-right text-secondary">تاريخ الحجز</span>
                                            <span class=" float-left">{{ parseTime($row->created_at) }}</span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <!---->
                                        @if ($row->payment_response == 0)
                                            <div class="px-3 mt-3">
                                                <a href="{{ userUrl('conference/checkout/' . $row->id) }}"
                                                    class=" btn btn-success btn-block ">ادفع الان</a>
                                            </div>
                                        @endif

                                        <!---->

                                    </div>
                                </div><!-- End Content -->
                            @endforeach
                        @else
                            <div class="col-lg-12 mb-4">
                                <div class="box-white py-5">
                                    <h5 class=" text-center">لا توجد طلبات</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </section>
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection
