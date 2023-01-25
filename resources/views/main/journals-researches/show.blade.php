@extends('main.layouts.master')
@section('title', $pageTitle)
@php
$fileLink = asset('assets/uploads/journals-researches/' . $row->file);
$price = $row->price;
$pageTitleText = '';
@endphp

@if ($row->version->old_version != null)
    @php
        $pageTitleText = $row->version->old_version . ' من ' . $row->journal->name;
    @endphp
@else
    @php
        $pageTitleText = 'الإصدار ' . $row->version->version . ': ' . $row->version->day . ' ' . $row->version->month . ' ' . $row->version->year . ' من ' . $row->journal->name;
    @endphp
@endif
@section('title', $pageTitleText)
@section('keywords', str_replace(' ', ',', $pageTitleText))
@section('description', $pageTitleText)
@section('type', 'Researches')
@section('url', urldecode(URL::current()))


@section('content')
<style>
    .chip {
    display: inline-block;

    border-radius: 5px;
    background-color: #f1f1f1;
    }
</style>
    <!-- Start Header -->
    <header id="header-show-version" class=" d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="title">
                        
                        <h1 class="text-center">
                            @if ($row->version->old_version != null)
                                {{ $row->version->old_version }}
                                <br>
                                {{ ' من ' . $row->journal->name }}
                            @else
                            @php 
                             $month = (intval($row->version->month) != 0) ? $months[intval($row->version->month) - 1] : $row->version->month;
                            @endphp
                                {{ 'الإصدار ' . $row->version->version . ': ' . $row->version->day .' '.$month .' '. $row->version->year }}
                                <br>
                                {{ ' من ' . $row->journal->name }}
                            @endif
                        </h1>

                    </div>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
    </header>
    <!-- End Header -->


    <!-- Start Journals -->
    <section id="researches">
        <div class="container">

            <div class="row justify-content-center my-5">

                <div class="col-xl-9 col-lg-12 mb-5 mb-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="box-white shadow " @if(strlen($row->title) == strlen(utf8_decode($row->title))) style="text-align:left;direction:ltr" @endif>

                                <h2
                                    class="title font-weight-bold @if(strlen($row->title) == strlen(utf8_decode($row->title))) text-left @endif">
                                    {{ $row->title }}
                                </h2>

                                <span class="author-name text-secondary"><i class="fa-solid fa-user ml-1"></i>
                                    @if ($row->author_name == null)
                                        {{ 'غير معروف' }}
                                    @else
                                        {{ $row->author_name }}
                                    @endif
                                </span>
                                <div style="text-align: center;">
                                    <span class="mb-2" style="
                                        font-size: 14pt;font-weight:bold;
                                    line-height: 50px;
                                    " >
                                        @if(strlen($row->title) == strlen(utf8_decode($row->title))) Abstract
                                        @else الملخص @endif
                                    </span>
                                    <p style=" font-size: 14pt;line-height:56px;text-align: justify; @if(strlen($row->title) == strlen(utf8_decode($row->title))) direction:ltr; @else direction:rtl; @endif">{!! $row->abstract !!}</p>    
                                </div>
                               
                                <div @if(strlen($row->title) == strlen(utf8_decode($row->title))) style="text-align:left;direction:ltr" @endif>
                                    @if($row->keywords)
                                    <span class="mb-2" style="text-align: inherit;text-align: inherit;font-weight:bold;
                                        font-size: 14pt;
                                    line-height: 50px;
                                    @if(strlen($row->title) == strlen(utf8_decode($row->title))) font-family: 'times new roman' !important; @else font-family 'traditional arabic'  @endif" >
                                        @if(strlen($row->title) == strlen(utf8_decode($row->title))) Keywords: 
                                        @else الكلمات المفتاحية: @endif
                                    </span>
                                    @foreach (explode(',',$row->keywords) as $k)
                                     @if(!empty($k))
                                      <a href="/search?q={{$k}}" class="chip mx-1 px-2 mt-1 keyword-element" style=" margin: 0cm;
                                      text-align: justify;   unicode-bidi: embed;
                                      /* font-size: 14pt; */
                                       line-height: 28px; 
                                      @if(strlen($row->title) == strlen(utf8_decode($row->title))) font-family: 'times new roman' !important; @else font-family 'traditional arabic'  @endif">
                                        {{$k}}
                                      </a>
                                      @endif
                                    @endforeach
                                  @endif
                                </div>
                           
                                
                                <div class="pt-2 mt-3"></div>
                                @if(date('2022-12-11') > date('Y-m-d',strtotime($row->created_at))) 
                                    @if (checkFile('assets/uploads/journals-researches/' . $row->file))
                                    {{-- || checkFile('assets/uploads/journals-researches/' . $row->file) --}}
                                        @if (preg_match('/[a-zA-z]/', $row->title))
                                            @if ($price != null)
                                            <a target="_blank" class="btn-main"
                                            href="{{ userUrl('researches/checkout/' . Crypt::encryptString($row->id)) }}">
                                            {{ 'Buy - ' . $price  }}
                                            <small>USD</small>
                                            </a>
                                            @else
                                                <a href="{{ $fileLink }}" target="_blank" class="btn-main">
                                                    {{ 'Download PDF' }}
                                                </a>
                                            @endif
                                        @else
                                            @if ($price != null)
                                                <a target="_blank" class="btn-main"
                                                    href="{{ userUrl('researches/checkout/' . Crypt::encryptString($row->id)) }}">
                                                    {{ 'شراء - ' . $price }}
                                                    <small>دولار</small>
                                                </a>
                                            @else
                                                <a href="{{ $fileLink }}" target="_blank" class="btn-main">
                                                    {{ 'تحميل الملف PDF' }}
                                                </a>
                                            @endif
                                        @endif
                                    @else
                                    @if (preg_match('/[a-zA-z]/', $row->title))
                                    <small>More details will be added soon.</small>
                                    @else
                                        <small>سيتم إضافة المزيد من التفاصيل قريبا</small>
                                        @endif
                                    @endif
                                @else 
                                @if ($row->file  && (pathinfo('assets/uploads/journals-researches/' . $row->file)['extension'] =='pdf'))
                                    @if (preg_match('/[a-zA-z]/', $row->title))
                                        @if ($price != null)
                                            <a target="_blank" class="btn-main"
                                            href="{{ userUrl('researches/checkout/' . Crypt::encryptString($row->id)) }}">
                                            {{ 'Buy - ' . $price  }}
                                            <small>USD</small>
                                            </a>
                                        @else
                                            <a href="{{ $fileLink }}" target="_blank" class="btn-main">
                                                {{ 'Download PDF' }}
                                            </a>
                                        @endif
                                    @else
                                        @if ($price != null)
                                            <a target="_blank" class="btn-main"
                                                href="{{ userUrl('researches/checkout/' . Crypt::encryptString($row->id)) }}">
                                                {{ 'شراء - ' . $price }}
                                                <small>دولار</small>
                                            </a>
                                        @else
                                            <a href="{{ $fileLink }}" target="_blank" class="btn-main">
                                                {{ 'تحميل الملف PDF' }}
                                            </a>
                                        @endif
                                    @endif
                                @else
                                @if (preg_match('/[a-zA-z]/', $row->title))
                                <small>More details will be added soon.</small>
                                @else
                                    <small>سيتم إضافة المزيد من التفاصيل قريبا</small>
                                    @endif
                                @endif

                                @endif

                                <div class="pb-2"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xl-3 col-lg-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-6 col-md-6">
                            <x-services list="true" />
                        </div><!-- Services 2 -->

                        <div class="col-xl-12 col-lg-6 col-md-6">
                            <x-journals />
                        </div><!-- blog -->
                    </div>
                </div><!-- Grid 2 -->

            </div>
        </div>
    </section>
    <!-- End Journals -->


@endsection
