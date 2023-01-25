@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')

    <div class="links-bar">
        <h4>{{ $pageTitle }}</h4>
    </div><!-- End Bar Links -->

    <div id="all-conferences" class="row">
        <div class="result"></div>
        @if (count($conferences) > 0)
            <div class="col-12">
                <div class="box-white table-responsive">
                    <table class="table table-striped table-inverse mb-0 table-bordered text-center">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>نوع الشهادة</th>
                                <th>عنوان البحث</th>
                                <th>طلب بواسطة</th>
                                <th>حالة الدفع</th>
                                <th>الشهادة</th>
                                <th>تفاصيل اكثر</th>
                                <th>الحذف</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($conferences as $row)
                                <tr>

                                    <td>{{ $row->id }}</td>
                                    <td>

                                        {{ $row->confCategory->name }}

                                    </td>

                                    <td>
                                        @if ($row->research_title == null)
                                            <small class="text-muted">{{ 'لا يوجد' }}</small>
                                        @else
                                            {{ $row->research_title }}
                                        @endif
                                    </td>

                                    <td><a
                                            href="{{ adminUrl('users/show/' . $row->user->id) }}">{{ $row->user->email }}</a>
                                    </td>

                                    <td>
                                        @if ($row->payment_response > 0)
                                            <span class=" text-success">مدفوع</span>
                                        @else
                                            <small class=" text-secondary"> غير مدفوع</small>
                                        @endif
                                    </td>

                                    <td>
                                        <form class="form"
                                            action="{{ adminUrl('conference/send/certificate') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ Crypt::encryptString($row->id) }}">
                                            <input type="hidden" name="email"
                                                value="{{ Crypt::encryptString($row->user->email) }}">
                                            <button type="submit" class="btn btn-light border btn-sm">ارسل الشهادة</button>
                                        </form>
                                    </td>


                                    <td>
                                        <a href="{{ adminUrl('conference/show/' . $row->id) }}"
                                            class="btn btn-sm btn-primary">التفاصيل</a>
                                    </td>
                                    <td>
                                        <form class="d-inline-block delete" action="{{ adminUrl('conference/destroy') }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" value="{{ $row->id }}" name="id">
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
        @else
            <div class="col-12">
                <div class="box-white py-5 text-center">
                    <h4 class=" mb-0 text-center">لا توجد طلبات !</h4>

                </div>
            </div>
        @endif

    </div>

@endsection
