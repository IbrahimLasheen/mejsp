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
                            
                                @php 
                                    $value = \App\Models\Message::where(['u_show' => 0, 'research_id'=>$research_details->id ])->get();
                                    $value = $value->count();
                                @endphp
                                <div class="col-lg-12 mb-4">
                                    <div class="box-white px-0">
                                        <h6 class=" px-3 float-right mt-1">التفاصيل </h6>
                                        <div class="controls">
                                            @if ($research_details->status == 1)
                                                <a href="#" class="status btn btn-warning"> قيد المعالجة </a>
                                            @elseif ($research_details->status == 2)
                                                <a href="#" class="status btn btn-warning"> في المراجعة   </a>
                                            @elseif ($research_details->status == 3)
                                                <a href="#" class="status btn btn-success"> مقبول </a>
                                            @elseif ($research_details->status == 4)
                                                <a href="#" class="status btn btn-danger"> مرفوض </a>
                                            @elseif ($research_details->status == 5)
                                                <a href="#" class="status btn btn-info"> مطلوب تعديل </a>
                                                <a href="{{ userUrl('chat/'.$research_details->id)}}" class="status btn btn-info"> <i class="fa fa-message"></i> {{$value}} </a>
                                            @endif    
                                                
                                            {{-- edit research --}}
                                            @if ($research_details->status == 1)
                                            <a href="{{ userUrl('researches/edit/' . $research_details->id) }}"
                                                class="btn btn-outline-primary ml-2 float-left btn-sm"><i
                                                    class="fa-solid fa-pen"></i></a>
                                            @endif

                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>

                                        <div class="mx-3 mb-2 mt-3 d-flex  align-items-center">
                                            <span class=" float-right text-secondary" style="min-width: 93px;">عنوان البحث  : </span>
                                            <a href="{{route('current_user_researches',['id'=>$research_details->id])}}" class="mx-3 font-weight-bold
                                                @if(preg_match("/^[\w\d\s.,-]*$/", $research_details->title))
                                                text-left
                                                @endif
                                                ">{{$research_details->title}}</a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="mx-3 mb-2 mt-3 d-flex  align-items-center">
                                            <span class=" float-right text-secondary" style="min-width: 93px;">المؤلف  : </span>
                                            <span class="mx-3 font-weight-bold
                                                @if(preg_match("/^[\w\d\s.,-]*$/", $research_details->user->name))
                                                text-left
                                                @endif
                                                ">{{$research_details->user->name}}</span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="px-3 mb-1 my-4  d-flex justify-content-start">
                                            <span class="bolld float-right text-secondary" style="min-width: 93px;">تاريخ الارسال :</span>
                                            <span class="mx-3 font-weight-bold ">{{parseTime($research_details->created_at)}}</span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="px-3 mb-1 my-4  d-flex justify-content-start">
                                            <span class="bolld float-right text-secondary" style="min-width: 93px;">تاريخ آخر تحديث :</span>
                                            <span class="mx-3 font-weight-bold ">{{parseTime($research_details->updated_at)}}</span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <!---->


                                        <div class="mx-3 mb-2 mt-3 d-flex  align-items-center">
                                            <span class=" float-right text-secondary" style="min-width: 93px;">نوع البحث : </span>
                                            <span class="  float-left mx-3">
                                                @if ($research_details->type == 0)
                                                    {{ 'مفتوح المصدر' }}
                                                @else
                                                    {{ 'مقيد الوصول' }}
                                                @endif
                                            </span>
                                            <div class="clearfix"></div>
                                        </div>


                                        <!---->
                                        <div class="mx-3 mb-2 mt-3 d-flex  align-items-center">
                                            <span class=" float-right text-secondary" style="min-width: 93px;">تاريخ الارسال : </span>
                                            <span class=" float-left  mx-3">{{ parseTime($research_details->created_at) }}</span>
                                            <div class="clearfix"></div>
                                        </div>


                                        <!---->
                                        <div class="mx-3 mb-2 mt-3 d-flex  align-items-center">
                                            <span class=" float-right text-secondary" style="min-width: 93px;">المجلة : </span>
                                            <span class=" float-left mx-3 @if(preg_match("/^[\w\d\s.,-]*$/", $research_details->user->name))
                                                text-left
                                                @endif" >{{ $research_details->journal->name }}</span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <!---->


                                    </div>
                                </div>
                    </div>
                </div>

            </div>

        </div>

    </section>

@endsection
@section('js')
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection
