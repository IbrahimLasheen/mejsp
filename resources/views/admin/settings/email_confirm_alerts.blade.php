@extends('admin.layouts.master')
@section('title', 'الاعدادات')
@section('css')

<link rel="stylesheet" type="text/css" href="{{asset('assets/simditor/simditor.css')}}" />
<style>
    label{display: block}
    .simditor-body ul,.simditor-body ol{margin: auto 2% !important}
</style>
@endsection
@section('content')

    <div class="links-bar my-4 ">
        <h4>إعدادات التنبيهات عند تأكيد البريد الالكتروني</h4>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div class="setting">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="row">


                    <div class="col-12">
                        <div class="box-white">
                            <h5 class=" mb-3">قائمة التنبيهات</h5>
                            <form action="{{ admin_url('settings/email_confirmation_alerts') }} " method="POST">
                                @csrf
                                
                                    <div class="form-group">
          
                                        <textarea name="confirm_email_alerts" class="form-control "  id="summernote" cols="30" rows="3">@if ($setting != null) {{ $setting->confirm_email_alerts}} @endif</textarea>
                                        @error("confirm_email_alerts")
                                            <div class=" alert alert-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                <button type="submit" class="btn-main">حفظ</button>
                            </form>
                        </div><!-- box-white -->
                    </div><!-- col-->


                </div><!-- Row -->
            </div><!-- Grid 1 -->



        </div>
    </div>


@endsection
@section('js')
    @if (session()->has('success'))
        <script>
            toastr.options.timeOut = 2000;
            toastr.options.progressBar = true;
            toastr.success("{{ session()->get('success') }}");
        </script>
    @endif
    <script type="text/javascript" src="{{asset('assets/simditor/module.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/simditor/hotkeys.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/simditor/hotkeys.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/simditor/simditor.js')}}"></script>
     <script>
        $(document).ready(function() {
            var editor = new Simditor({
            textarea: $('#summernote')
            //optional options
            });
        });
    </script>
@endsection
