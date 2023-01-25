@extends('admin.layouts.master')
@section('title', 'الرسائل')
@section('content')

    <div class="links-bar my-4 ">
        <h4>الرسائل</h4>
    </div><!-- End Bar Links -->

    <div class="result"></div>
    <div id="messages">
        <div class="row justify-content-center">

            <div class="col-xl-7">
                <div class="box-white p-0">
                    @foreach ($helps as $row)
                        <div class=" senders">
                            <a href="{{ admin_url('message/show/' . $row->id) }}">

                                <div class="image">
                                    @if ($row->doctor->image == null)
                                        <img
                                            src="{{ asset('assets/images/defualt-doctor-' . $row->doctor->gender . '.png') }}">
                                    @else
                                        @if (checkFile('assets/uploads/doctors/' . $row->doctor->image))
                                            <img class="img-fluid"
                                                src="{{ asset('assets/uploads/doctors/' . $row->doctor->image) }}">
                                        @else
                                            <img
                                                src="{{ asset('assets/images/defualt-doctor-' . $row->doctor->gender . '.png') }}">
                                        @endif
                                    @endif

                                </div><!-- img -->

                                <div class="info mt-1">
                                    <h6>{{ $row->doctor->f_name . ' ' . $row->doctor->l_name }}</h6>
                                    <h6>{{ $row->doctor->email }}</h6>
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
