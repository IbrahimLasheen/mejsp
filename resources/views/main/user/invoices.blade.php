@extends('main.layouts.master')
@section('title', 'فواتيري')
@section('content')
    <section id="section" class="py-5">
        <div class="container-fluid">
            <div class="row">

                <!-- Include Aside -->
                @include('main.user.aside')

                <div class="col-lg-9 col-md-8">
                    <div class="col-lg-12 mb-4">
                         @if(count($invoices))
                         @foreach ($invoices as $row)
                         <div class="box-white px-0 mb-3">
                             <div class="row m-0 px-3 mb-3">
                                 <div class="col-4 p-0 " style="line-height: 2">
                                     <h6 class="m-0">رقم الفاتورة</h6>
                                 </div>
                                 <div class="col-8  pl-2  font-weight-bold">
                                     {{$row->id}}
                                 </div>
                             </div>
                             <div class="row m-0 px-3 mb-3">
                                 <div class="col-4 p-0 " style="line-height: 2">
                                     <h6 class="m-0">اجمالي السعر</h6>
                                 </div>
                                 <div class="col-8  pl-2  font-weight-bold">
                                   @php
                                   $prices = 0;
                                   @endphp
                                   @foreach ($row->items as $item)
                                        @php
                                        $prices += $item->price;
                                        @endphp

                                        @if ($loop->last)
                                        {{ "$" . $prices }}
                                        @endif
                                   @endforeach
                                 </div>
                                 
                             </div>
                             <div class="row m-0 px-3 mb-3">
                              <div class="col-4 p-0 " style="line-height: 2">
                                  <h6 class="m-0">حالة الدفع</h6>
                              </div>
                              <div class="col-8  pl-2  font-weight-bold">
                                   @if ($row->payment_response > 0)
                                   <span class=" text-success">مدفوعة</span>
                                   @else
                                        <small>غير مدفوعة</small>
                                   @endif
                              </div>
                            </div>
                            <div class="row m-0 px-3 mb-3">
                              <div class="col-4 p-0 " style="line-height: 2">
                                  <h6 class="m-0">نسخ الرابط</h6>
                              </div>
                              <div class="col-8  pl-2  font-weight-bold">
                                   @if ($row->payment_response == 0)
                                   <a class="btn btn-sm btn-success pb-0"
                                       href="{{ url('invoice/' . Crypt::encryptString($row->id)) }}" target="_blank">
                                       <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                   </a>
                                   @else
                                        <span>-</span>
                                   @endif
                              </div>
                            </div>
                            <div class="row m-0 px-3 mb-3">
                              <div class="col-4 p-0 " style="line-height: 2">
                                  <h6 class="m-0">حالة الفاتورة</h6>
                              </div>
                              <div class="col-8  pl-2  font-weight-bold">
                                   @if ($row->payment_response == 0)
                                   @if (time() > $row->ending)
                                       <span>غير نشطة</span>
                                   @else
                                       <span>نشطة</span>
                                   @endif
                                   @else
                                        <span>-</span>
                                   @endif
                              </div>
                            </div>
                             <!---->


                         </div>
                         @endforeach
                         @else 
                         <div class="box-white py-5">
                              <h5 class=" text-center">لا توجد فواتير</h5>
                          </div>
                         @endif
                     </div>
                </div>
            </div>
        </div>
    </section>
@endsection