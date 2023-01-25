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

                        @if (count($researches) > 0)
                            @foreach ($researches as $row)
                               @if(\App\Models\Message::where('research_id',$row->id)->count())
                                {{-- @php 
                                    $value = \App\Models\Message::where(['u_show' => 0, 'research_id'=>$row->id ])->get();
                                    $value = $value->count();
                                @endphp --}}
                                <div class="col-lg-12 mb-4">
                                    <div class="box-white px-0">
                                        <div class="d-flex justify-content-between align-items-center px-3">

                                         
                                            <div style="flex:auto;">
                                                <a class=" font-weight-bold" style="line-height: 1.8" href="{{route('current_user_researches',['id'=>$row->id])}}">{{ $row->title }}</a>
                                                
                                            </div>
                                            <div class="d-flex" style="min-width:170px">
                                                <div class="controls mx-2">
                                                    
                                                    @if ($row->status == 3)
                                                        <span href="#" class=" badge badge-success p-2"> مقبول </span>
                                                    @elseif ($row->status == 4)
                                                        <span href="#" class=" badge badge-danger p-2"> مرفوض </span>
                                                    @elseif ($row->status == 1)
                                                        <a href="#" class=" badge badge-warning"> قيد المعالجة </a>
                                                    @elseif ($row->status == 2)
                                                        <a href="#" class=" badge badge-warning"> في المراجعة   </a>
                                                    @elseif ($row->status == 5)
                                                        <a href="#" class=" badge badge-info"> مطلوب تعديل </a>
                                                    @endif  
    
                                                </div>
                                                    <a href="{{ userUrl('chat/'.$row->id)}}" class="status btn btn-info">  عرض المحادثة </a>

                                            </div>
                                        
                                        <!---->


                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @else
                            <div class="col-lg-12 mb-4">
                                <div class="box-white py-5">
                                    <h5 class=" text-center">لا توجد محادثات</h5>
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
