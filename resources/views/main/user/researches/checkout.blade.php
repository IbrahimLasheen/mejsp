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
                                    <span class=" float-right text-secondary">عنوان البحث</span>
                                    <span class=" float-left">{{ $row->title }}</span>
                                    <div class="clearfix"></div>
                                </div>
                                <!---->


                                <div class="px-3 mb-3">
                                    <span class=" float-right text-secondary">المجلة</span>
                                    <span class=" float-left">{{ $row->journal->name }}</span>
                                    <div class="clearfix"></div>
                                </div>
                                <!---->



                                <div class="px-3 mb-3">
                                    <span class=" float-right text-secondary">الاصدار</span>
                                    <span class=" float-left">
                                        @if ($row->version->old_version != null)
                                            {{ $row->version->old_version }}
                                        @else
                                            {{ 'الإصدار ' . $row->version->version . ': ' . $row->version->year . ' ' . $row->version->month . ' ' . $row->version->day }}
                                        @endif
                                    </span>
                                    <input type="hidden" id="price" value="{{ tax($row->price) }}" />
                                    <div class="clearfix"></div>
                                </div>
                                <!---->


                                <div class="px-3 mb-0">
                                    <span class=" float-right text-secondary">سعر البحث</span>
                                    <span class=" float-left">${{ $row->price }}</span>
                                    <div class="clearfix"></div>
                                </div>
                                <!---->

                            </div>

                        </div>


                        <div class="col-lg-4">
                            <div class="box-white px-0 pb-0">

                                <div class="px-3 mb-3">
                                    <span class=" float-right">سعر البحث</span>
                                    <span class=" float-left">${{ $row->price }}</span>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="px-3 mb-3">
                                    <span class=" float-right">الضريبة</span>
                                    <span class=" float-left">%5</span>
                                    <div class="clearfix"></div>
                                </div>


                                <div class="px-3 mb-3">
                                    <span class=" float-right">اجمالي التكلفة</span>
                                    <span class=" float-left text-success">${{ tax($row->price) }}</span>
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
