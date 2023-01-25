@extends('admin.layouts.master')
@section('title', 'بيانات المستخدم')
@section('content')

    <div class="links-bar my-4 ">
        <h4>بيانات المستخدم</h4>

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


    <div class="row">

        <div class="col-12 mb-4">
            <div class="row">

                <div class="col-12">
                    <div class="box-white table-responsive">

                        <table class="table table-striped table-inverse table-bordered text-center mb-0">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الالكتروني</th>
                                    <th>رقم الهاتف</th>
                                    <th>المؤهل</th>
                                    <th>تأكيد البريد </th>
                                    <th>انضم منذ</th>
                                    <th>التحكم</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td style="direction: ltr">{{ $row->country_code . ' ' . $row->phone }}</td>
                                    <td>{{ $row->qualification }}</td>
                                    <td>
                                        @if ($row->email_verified_at != null)
                                            <span class="toast-title text-success" data-toggle="tooltip"
                                                data-placement="top" title="تم التحقق من البريد">
                                                <i class="fa-solid fa-circle-check"></i>
                                                <span class="text-dark">البريد موثق</span>
                                            </span><!-- Email Veric.... -->
                                        @else
                                            <span class="toast-title text-danger" data-toggle="tooltip" data-placement="top"
                                                title=" لم يتم التحقق من البريد">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                                <span class="text-dark">غير موثق</span>
                                            </span><!-- Email Veric.... -->
                                        @endif
                                    </td>
                                    <td>{{ parseTime($row->created_at) }}</td>
                                    <td>

                                        <form class="d-inline-block" action="{{ adminUrl('users/status') }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $row->id }}" name="id">
                                            @if ($row->status == 1)
                                                <button type="submit" class="btn btn-warning btn-sm">حظر
                                                    الحساب</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">تفعيل
                                                    الحساب</button>
                                            @endif
                                        </form><!-- Form Active And UnActive -->

                                        <form class="d-inline-block delete" action="{{ adminUrl('users/delete') }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" value="{{ $row->id }}" name="id">
                                            <button type="submit" class="btn btn-outline-danger btn-sm"> <i
                                                    class="fa-solid fa-trash-can"></i> حذف</button>
                                        </form>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div><!-- User Info -->


            </div>
        </div><!-- Grid 1 -->



        <div class="col-lg-12 mb-4">
            <div class="row">

                <div class="col-12">
                    <h6 class="mb-3">الابحاث المقدمة</h6>
                    <div class="box-white table-responsive">
                        <table class="table table-striped table-inverse mb-0 table-bordered text-center">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>عنوان البحث</th>
                                    <th>نوع البحث</th>
                                    <th>المجلة</th>
                                    <th>ارسل منذ</th>
                                    <th>التفاصيل</th>
                                    <th>الملف</th>
                                    <th>الحذف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($researches as $re)
                                    <tr>
                                        <td>{{ $re->title }}</td>
                                        <td>
                                            @if ($re->type > 0)
                                                {{ 'مقيد الوصول' }}
                                            @else
                                                {{ 'مفتوح المصدر' }}
                                            @endif
                                        </td>
                                        <td>{{ $re->journal->name }}</td>
                                        <td>{{ parseTime($re->created_at) }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#modelId">
                                                تفاصيل اكثر
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modelId" tabindex="-1" role="dialog"
                                                aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                {{ Str::limit($re->title, 45) }} </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ $re->abstract }}</p>
                                                            <h6 class=" text-dark font-weight-bold">الكلمات المفتاحية
                                                            </h6>
                                                            {{ $re->keywords }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">اغلاق</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </td>
                                        <td>
                                            @if (file_exists(public_path("assets/uploads/users-researches/$re->file")))
                                                <a class="btn btn-light border btn-sm"
                                                    href="{{ asset("assets/uploads/users-researches/$re->file") }}"
                                                    download>
                                                    تحميل الملف
                                                </a>
                                            @else
                                                {{ 'لا يوجد !' }}
                                            @endif

                                        </td>

                                        <td>
                                            <form class="d-inline-block delete" action="{{ adminUrl('users/researches/destroy') }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" value="{{ $re->id }}" name="id">
                                                <button type="submit" class="btn btn-outline-danger btn-sm"> <i
                                                        class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class=" mt-3">
                            {{ $researches->links() }}
                        </div>

                    </div>

                </div><!-- User Orders -->

            </div><!-- Row -->
        </div><!-- Grid 3 -->



        <div class="col-lg-4 mb-4">
            <h6 class="mb-3">طلبات حضور المؤتمرات</h6>
            <div class="row">
                <div class="col-12">
                    @forelse ($conferences as $conf)
                        @php
                            $data = [
                                'name' => $conf->confCategory->name,
                                'price' => $conf->confCategory->price,
                                'research_title' => $conf->research_title,
                                'payment_response' => $conf->payment_response,
                                'created_at' => $conf->created_at,
                            ];
                        @endphp
                        <x-order :details="$data" />
                    @empty
                        <div class="box-white">
                            <h5 class=" text-center mb-0 text-secondary">لا توجد طلبات !</h5>
                        </div>
                    @endforelse
                </div><!-- User Orders -->
            </div><!-- Row -->
        </div><!-- Grid 2 -->


        <div class="col-lg-4 mb-4">
            <h6 class="mb-3">النشر الدولي</h6>
            <div class="row">
                <div class="col-12">
                    @forelse ($InternationalPublicationOrders as $intr)
                        @php
                            $data = [
                                'journal_name' => $intr->journal->name,
                                'journal_price' => $intr->journal->price,
                                'payment_response' => $intr->payment_response,
                                'created_at' => $intr->created_at,
                                'file' => $intr->file,
                                'desc' => $intr->desc,
                                'id' => $intr->id,
                            ];
                        @endphp
                        <x-inter-orders :details="$data" />
                    @empty
                        <div class="box-white">
                            <h5 class=" text-center mb-0 text-secondary">لا توجد طلبات !</h5>
                        </div>
                    @endforelse
                </div><!-- User Orders -->
            </div><!-- Row -->
        </div><!-- Grid 2 -->


        <div class="col-lg-4 mb-4">
            <div class="row">

                <div class="col-12">
                    <h6 class="mb-3">المدفوعات</h6>

                    @forelse ($payments as $pay)
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

                    @empty
                        <div class="box-white">
                            <h5 class=" text-center mb-0 text-secondary">لا توجد مدفوعات !</h5>
                        </div>
                    @endforelse

                </div><!-- User Orders -->

            </div><!-- Row -->
        </div><!-- Grid 2 -->



    </div><!-- row -->





@endsection
