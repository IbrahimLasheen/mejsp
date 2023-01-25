@extends('admin.layouts.master')
@section('title', 'تعديل فاتورة')
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('invoices') }}">الفواتير</a>
        <a>تعديل فاتورة</a>
    </div><!-- End Bar Links -->

    <div class="result"></div>
    <div class="row justify-content-center">

        <div class="col-xl-7 col-lg-8">
            <input type="hidden" id="prefix" name="prefix" value="{{ adminPrefix() }}">
            <div class="box-white">

                <form class="form" action="{{ adminUrl('invoices/updateJournal') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $row->id }}">

                   <div class="form-group">
                        <label class="required" for="journals">المجله</label>
                        <input type="text" value="{{ $row->journal->name }}" class="form-control" disabled>
                        <input type="text" value="{{ $row->journal->id }}" name="journal_id" class="d-none">
                    </div>
                     <div class="form-group">
                        <label class="required" for="default_page_count">عدد الصفحات الافتراضي</label>
                        <input type="number" value="{{ $row->default_page_count }}" class="form-control" name="default_page_count" id="default_page_count">
                    </div>
                    <div class="form-group">
                        <label class="required" for="extra_page_price">سعر الصفحة الاضافية</label>
                        <input type="number" value="{{ $row->extra_page_price }}" class="form-control" name="extra_page_price" id="extra_page_price">
                    </div>

                    <h5 class="my-4">بنود الفاتورة</h5>
                    <div class="row" id="items-row">
                        @php
                            $prices = 0;
                        @endphp
                        @foreach ($row->items as $item)
                            
                            @php
                                $prices += $item->price;
                            @endphp
                            <div class="col-12 item">
                                <div class="row">
                                    <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                    @if ($loop->index == 0)
                                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" name="service_name[]" class="form-control"
                                                    placeholder="اسم الخدمة" value="{{ $item->service_name }}" required />
                                            </div>
                                        </div><!-- service_name -->

                                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-4 col-8">
                                            <div class="form-group">
                                                <input type="number" step="any" name="price[]" value="{{ $prices }}"
                                                    class="form-control" placeholder="سعر الفاتورة ( بالدولار )"
                                                    required />
                                            </div>
                                        </div><!-- price -->
                                        
                                    @else

                                        <div class="col-xl-7 col-lg-7 col-md-6 col-sm-6 col-12">
                                            <div class="form-group">
                                                <input type="text" name="service_name[]" class="form-control"
                                                    placeholder="اسم الخدمة" value="{{ $item->service_name }}" required />
                                            </div>
                                        </div><!-- service_name -->

                                        <div class="col-xl-4 col-lg-3 col-md-4 col-sm-4 col-8">
                                            <div class="form-group">
                                                <input type="number" step="any" name="price[]" value="{{ $item->price }}"
                                                    class="form-control" placeholder="سعر الفاتورة ( بالدولار )"
                                                    required />
                                            </div>
                                        </div><!-- price -->

                                     

                                        <div class="col-xl-1 col-lg-2  col-sm-2 col-4  pr-md-0 mb-3">
                                            <button data-id="{{ $item->id }}" type="button"
                                                class="btn-sm btn btn-outline-danger mt-1 btn-block text-center btn-remove-item"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        </div><!-- button -->


                                    @endif
                                </div><!-- Row -->
                            </div><!-- Item 1-->

                            <div class="col-12">
                            </div>
                        @endforeach


                    </div><!-- End Row Item -->



                    <button type="button" id="btn-add-item" class="btn btn-secondary btn-sm"><i
                            class="fa-solid fa-plus ml-1"></i>اضافة بند</button><!-- Add -->


                    <hr>
                    <button type="submit" class="btn-main btn-block">تحديث الفاتورة</button>

                </form><!-- End Form -->
            </div>
        </div><!-- End Col -->
    </div>

@endsection
