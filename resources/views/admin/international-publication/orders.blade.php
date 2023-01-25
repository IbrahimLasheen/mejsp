@extends('admin.layouts.master')
@section('title', 'طلبات النشر الدولي')
@section('content')

    <div class="links-bar my-4 ">
        <h4>طلبات النشر الدولي</h4>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div>
        <div class="row">

            @if (count($rows) == 0)
                <div class="col-12">
                    <div class="box-white py-5">
                        <h5 class="mb-0 text-center">لا يوجد !</h5>
                    </div>
                </div>
            @else
                <div class="col-12 mb-4">
                    <div class="box-white table-responsive">
                        <table class="table table-striped table-inverse table-bordered mb-0 text-center table-with-avatar">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>النشر الدولى</th>
                                    <th>ثمن النشر</th>
                                    <th>حالة الدفع</th>
                                    <th>تاريخ الحجز</th>
                                    <th>طلب بواسطة</th>
                                    <th>تفاصيل اكثر</th>
                                    <th>الحذف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $intr)
                                    <tr>
                                        <td>{{ $intr->journal->name }}</td>
                                        <td>${{ $intr->journal->price }}</td>
                                        <td>
                                            @if ($intr->payment_response > 0)
                                                <span class="text-success"> مدفوع </span>
                                            @else
                                                <span class="">غير مدفوع</span>
                                            @endif
                                        </td>
                                        <td>{{ parseTime($intr->created_at) }}</td>

                                        <td><a href="{{ adminUrl('users/show/' . $intr->user?->id) }}"
                                                class="">{{ $intr->user?->email }}</a></td>

                                        <td>
                                            <a href="{{ adminUrl('international-publishing/orders/show/' . $intr->id) }}"
                                                class="btn btn-primary btn-sm">التفاصيل</a>
                                        </td>

                                        <td>
                                            <form class="d-inline-block delete" action="{{ adminUrl('international-publishing/destroy') }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" value="{{ $intr->id }}" name="id">
                                                <button type="submit" class="btn btn-outline-danger btn-sm"> <i
                                                        class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div><!-- row -->
    </div><!-- freelancers -->




@endsection
