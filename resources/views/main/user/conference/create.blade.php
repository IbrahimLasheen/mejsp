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

                        @if (getAuth('user', 'email_verified_at') == null)
                            <div class="col-12">
                                <div class="box-white py-5 text-center">
                                    <h5 class=" text-center mb-3">قبل ارسال الطلبات يجب تاكيد بريدك الالكتروني</h5>
                                    <form class="d-inline-block" action="{{ userUrl('email-verification') }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn-main">تأكيد حسابي</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="col-12 mb-3">
                                <h5 class=" float-right">طلب جديد</h5>
                                <a href="{{ userUrl('conference') }}" class="btn-main float-left">طلباتي</a>
                            </div>


                            <div id="conferences-details" class="col-lg-3">
                                <div class="box-white px-0 py-3">
                                    <h6 class="mb-0 px-3">تفاصيل الحجز</h6>
                                    <hr>
                                    <div class="px-3">
                                        <span class=" float-right text-secondary">ثمن الحجز</span>
                                        <span class=" float-left text-success font-weight-bold">$<span
                                                class="price">0</span></span>
                                        <div class="clearfix"></div>
                                    </div><!-- Order Details -->
                                </div>
                            </div>

                            <div class="col-lg-9 col-m d-8">

                                <div class="box-white p-3">

                                    <div class="result"></div><!-- Result Box-->

                                    @if (session()->has('successMsg'))
                                        <div class=" alert alert-success text-center">{{ session()->get('successMsg') }}
                                        </div>
                                    @endif

                                    <form class="form" id="form-create-conference"
                                        action="{{ userUrl('conference/store') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label class="required">إختر نوع الشهادة</label>
                                            <select id="select-type-of-conferences" class="form-control" name="category"
                                                required>
                                                <option disabled selected></option>
                                                @foreach ($conferenceCategories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="alert-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="research-box">
                                           
                                        </div>


                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn-main">طلب الشهادة</button>
                                        </div>

                                    </form>
                                </div>
                            </div><!-- End Content -->

                        @endif
                    </div>



                </div>






            </div>
        </div>
    </section>
@endsection
