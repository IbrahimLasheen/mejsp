@extends('admin.layouts.master')
@section('title', 'طلب نشر دولي')
@section('content')

    <div class="links-bar my-4 ">
        <a href="{{ adminUrl('international-publishing/orders') }}">طلب نشر دولي</a>
        <a href="">عرض تفاصيل الطلب</a>
    </div><!-- End Bar Links -->


    @if (session()->has('success'))
        <div class="alert  box-success alert-dismissible fade show mb-3" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="result"></div>

    <div id="freelancers">
        <div class="row  justify-content-center">

            <div class="col-lg-5 mb-4">
                <div class="row">

                    <div class="col-12 mb-3">
                        <h5 class="mb-3">تفاصيل الطلب</h5>
                        @php
                            $data = [
                                'journal_name' => $intr->journal->name,
                                'journal_price' => $intr->journal->price,
                                'payment_response' => $intr->payment_response,
                                'created_at' => $intr->created_at,
                                'file' => $intr->file,
                                'desc' => $intr->desc,
                                'show_desc' => true,
                                'id' => $intr->id,
                            ];
                        @endphp
                        <x-inter-orders :details="$data" />
                    </div><!-- User Orders -->


                    <div class="col-12 mb-3">
                        <h5 class="mb-3">تفاصيل الدفع</h5>
                        @if ($intr->payment_response > 0)
                            @php
                                $all = [
                                    'status' => $pay->status,
                                    'amount' => $pay->amount,
                                    'currency' => $pay->currency,
                                    'source' => $pay->source,
                                    'payment_id' => $pay->payment_id,
                                    'created_at' => $pay->created_at,
                                ];
                            @endphp
                            <x-payment :details="$all" />
                        @else
                            <div class="box-white">
                                <h5 class=" text-secondary text-center mb-0 py-4">لم يتم الدفع !</h5>
                            </div>
                        @endif

                    </div><!-- User Orders -->



                    <div class="col-12 mb-3">
                        <h5 class="mb-3 float-right">صاحب الطلب</h5>
                        <a href="{{ adminUrl('users/show/' . $intr->user->id) }}"
                            class=" float-left text-primary"><small>الملف الشخصي <i
                                    class="fa-solid fa-arrow-left"></i></small>
                        </a>
                        <div class="clearfix"></div>

                        <div class="box-white mb-3">

                            <div class="mb-3">
                                <span class="float-right text-secondary">الاسم</span>
                                <span class="float-left">{{ $intr->user->name }}</span>
                                <div class="clearfix"></div>
                            </div><!-- name -->

                            <div class="mb-3">
                                <span class="float-right text-secondary">البريد الالكتروني</span>
                                <span class="float-left">{{ $intr->user->email }}</span>
                                <div class="clearfix"></div>
                            </div><!-- email -->

                            <div class="">
                                <span class="float-right text-secondary">رقم الهاتف</span>
                                <span class="float-left"
                                    style="direction: ltr">{{ $intr->user->country_code . ' ' . $intr->user->phone }}</span>
                                <div class="clearfix"></div>
                            </div><!-- email -->


                        </div>
                    </div><!-- User Orders -->

                </div><!-- Row -->
            </div><!-- Grid 2 -->


        </div><!-- row -->
    </div><!-- user -->




@endsection
