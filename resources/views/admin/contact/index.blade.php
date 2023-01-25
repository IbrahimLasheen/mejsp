@extends('admin.layouts.master')
@section('title', 'الرسائل')
@section('content')

    <div class="links-bar my-4 ">
        <h4>الرسائل</h4>
    </div><!-- End Bar Links -->

    <div class="result"></div>
    <div id="contacts">
        <div class="row justify-content-center">

            <div class="col-xl-7">
                <div class="box-white p-0">
                    @foreach ($contact as $row)
                        <div class=" senders">
                            <a href="{{ admin_url('contact/show/' . $row->id) }}">

                                <div class="info mt-1">
                                    <h6>{{ $row->name }}</h6>
                                    <h6>{{ $row->email }}</h6>
                                </div>

                                @if ($row->status == 1)
                                    <div class=" badge badge-primary mt-2 float-left">غير مقروء</div>
                                @endif
                                <div class="clearfix"></div>
                                
                            </a>
                        </div>
                    @endforeach
                </div>
            </div><!-- Sender -->

        </div>
    </div>

@endsection
