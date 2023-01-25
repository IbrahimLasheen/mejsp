@extends('admin.layouts.master')
@section('title', 'اضافة فاتورة')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('invoices') }}">الفواتير</a>
        <a href="{{ admin_url('invoices/create') }}">اضافة فاتورة جديدة</a>
    </div><!-- End Bar Links -->

    <div class="result"></div>
    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-8">
            <div class="box-white">

                <form class="form" action="{{ adminUrl('invoices/store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf


                    <div class="form-group">
                        <label class="required">البريد الالكتروني للعميل</label>
                        <input type="email" name="email" class="form-control" autofocus required />
                    </div><!-- email -->

                    <div class="form-group">
                        <input type="checkbox" name="send_mail" id="send_mail" checked />
                        <label for="send_mail" class="mr-2">ارسال الفاتورة عبر البريد</label>
                    </div><!-- send_mail -->


                    <div class="row" id="items-row">

                        <div class="col-12">
                            <div class="row">

                                <div class="col-xl-7 col-lg-7 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" name="service_name[]" class="form-control"
                                            placeholder="اسم الخدمة" required />
                                    </div>
                                </div><!-- service_name -->


                                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-4 col-8">
                                    <div class="form-group">
                                        <input type="number" step="any" name="price[]" class="form-control"
                                            placeholder="سعر الفاتورة ( بالدولار )" required />
                                    </div>
                                </div><!-- price -->

                            </div><!-- Row -->
                        </div><!-- Item 1-->


                        
                    </div><!-- End Row Item -->



                    <button type="button" id="btn-add-item" class="btn btn-secondary btn-sm"><i
                            class="fa-solid fa-plus ml-1"></i>اضافة بند</button><!-- Add -->


                    <hr>
                    <button type="submit" class="btn-main btn-block">اضافة الفاتورة</button>

                </form><!-- End Form -->
            </div>
        </div><!-- End Col -->
    </div>

@endsection
