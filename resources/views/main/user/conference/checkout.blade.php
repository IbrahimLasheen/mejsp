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

                    <div id="checkout-box" class="row">



                        <div class="col-lg-8">
                            <div class="box-white px-0">
                                <h6 class=" px-3">تفاصيل الطلب</h6>
                                <hr>

                                <div class="px-3 mb-3">
                                    <span class=" float-right text-secondary">نوع الشهادة</span>
                                    <span class=" float-left">{{ $row->confCategory->name }}</span>
                                    <div class="clearfix"></div>
                                </div>
                                <!---->

                                <div class="px-3 mb-3">
                                    <span class=" float-right text-secondary">سعر المؤتمر</span>
                                    <span class=" float-left">${{ $row->confCategory->price }}</span>
                                    <div class="clearfix"></div>
                                </div>
                                <!---->

                                <input type="hidden" id="price" value="{{ tax($row->confCategory->price) }}" />


                                <div class="px-3 mb-3">
                                    <span class=" float-right text-secondary">عنوان البحث</span>
                                    <span class=" float-left">{{ $row->research_title }}</span>
                                    <div class="clearfix"></div>
                                </div>
                                <!---->


                                <div class="px-3 mb-3">
                                    <span class=" float-right text-secondary">حالة الدفع</span>
                                    <span class=" float-left">
                                        @if ($row->payment_response > 0)
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

                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="box-white px-0 pb-0">



                                <div class="px-3 mb-3">
                                    <span class=" float-right">سعر النشر</span>
                                    <span class=" float-left">${{ $row->confCategory->price }}</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="px-3 mb-3">
                                    <span class=" float-right">الضريبة</span>
                                    <span class=" float-left">%5</span>
                                    <div class="clearfix"></div>
                                </div>


                                <div class="px-3 mb-3">
                                    <span class=" float-right">اجمالي التكلفة</span>
                                    <span class=" float-left text-success">${{ tax($row->confCategory->price) }}</span>
                                    <div class="clearfix"></div>
                                </div>


                                <hr>
                                <div id="smart-button-container" class="px-3">
                                    <div style="text-align: center;">
                                        <div id="paypal-button-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!---->
                </div>
            </div>

        </div>

    </section>
@endsection
@section('js')
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.client_id') }}&enable-funding=venmo&currency={{ config('paypal.currency') }}"
        data-sdk-integration-source="button-factory"></script>
    <script src="{{ asset('assets/js/paypal.js') }}"></script>
@endsection
