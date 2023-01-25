@extends('main.layouts.master')
@section('title', $pageTitle)
@section('content')

<style>
    .status{
        padding:0 10px !important;
        font-size: 14px !important;
    }
</style>

    <section id="section" class="py-5">
        <div class="container">
            <div class="row">

                <div class="col-12 mb-4">
                    <h5 class="page-name">{{ $pageTitle }}</h5><!-- Page Name -->
                </div>

                <!-- Include Aside -->
                @include('main.user.aside')


                <div class="col-lg-9">



                    <div class="row">
                        <div class="col-12 mb-3">
                            <h5 class=" float-right"></h5>
                            <a href="{{ userUrl('researches') }}" class="btn-main float-left">بحث
                                جديد</a>
                        </div>

                        @if (count($researches) > 0)
                            @foreach ($researches as $row)
                            
                                @php 
                                    $value = \App\Models\Message::where(['u_show' => 0, 'research_id'=>$row->id ])->get();
                                    $value = $value->count();
                                @endphp
                                <div class="col-lg-12 mb-4">
                                    <div class="box-white px-0">
                                        <h6 class=" px-3 float-right mt-1">التفاصيل </h6>
                                        <div class="controls">
                                            @if ($row->status == 1)
                                                <a href="#" class="status btn btn-warning"> قيد المعالجة </a>
                                            @elseif ($row->status == 2)
                                                <a href="#" class="status btn btn-warning"> في المراجعة   </a>
                                            @elseif ($row->status == 3)
                                                <a href="#" class="status btn btn-success"> مقبول </a>
                                            @elseif ($row->status == 4)
                                                <a href="#" class="status btn btn-danger"> مرفوض </a>
                                            @elseif ($row->status == 5)
                                                <a href="#" class="status btn btn-info"> مطلوب تعديل </a>
                                                <a href="{{ userUrl('chat/'.$row->id)}}" class="status btn btn-info"> <i class="fa fa-message"></i> {{$value}} </a>
                                            @endif    
                                            {{-- edit research --}}
                                            @if ($row->status == 1)
                                            <a href="{{ userUrl('researches/edit/' . $row->id) }}"
                                                class="btn btn-outline-primary ml-2 float-left btn-sm"><i
                                                    class="fa-solid fa-pen"></i></a>
                                            @endif

                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
{{-- 
                                        <div class="mx-3 mb-2 mt-3 d-flex  align-items-center">
                                            <span class=" float-right text-secondary" style="min-width: 93px;">عنوان البحث  : </span>
                                            <a href="{{route('current_user_researches',['id'=>$row->id])}}" class="mx-3 font-weight-bold
                                                @if(preg_match("/^[\w\d\s.,-]*$/", $row->title))
                                                text-left
                                                @endif
                                                ">{{$row->title}}</a>
                                            <div class="clearfix"></div>
                                        </div> --}}
                                        <div class="row m-0 px-3 mb-3">
                                            <div class="col-4 p-0 " style="line-height: 2">
                                                <h6 class="m-0">عنوان البحث</h6>
                                            </div>
                                            <div class="col-8  pl-2  font-weight-bold">
                                                <a href="{{route('current_user_researches',['id'=>$row->id])}}">{{ $row->title }}</a>
                                            </div>
                                        </div>
                                        <div class="row m-0 px-3 mb-3">
                                            <div class="col-4 p-0 " style="line-height: 2">
                                                <h6 class="m-0">المؤلف</h6>
                                            </div>
                                            <div class="col-8  pl-2 font-weight-bold" >
                                                {{$row->user->name}}
                                            </div>
                                        </div>
                                        <div class="row m-0 px-3 mb-3">
                                            <div class="col-4 p-0 " style="line-height: 2">
                                                <h6 class="m-0">تاريخ الإرسال</h6>
                                            </div>
                                            <div class="col-8  pl-2 font-weight-bold" >
                                                {{parseTime($row->created_at)}}
                                            </div>
                                        </div>
                                        
                                        <!---->


                                    </div>
                                </div><!-- End Content -->
                            @endforeach
                        @else
                            <div class="col-lg-12 mb-4">
                                <div class="box-white py-5">
                                    <h5 class=" text-center">لا توجد ابحاث</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </section>

@endsection
@section('js')
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection
