@extends('main.layouts.master') @section('title', $pageTitle)@section('title', $pageTitle)@section('keywords', str_replace(' ', ',', $pageTitle))@section('description', $pageTitle)@section('type', 'Researches')@section('url', urldecode(URL::current()))@section('content') <header id="header-show-version" class=" d-flex justify-content-center align-items-center"> <div class="container"> <div class="row justify-content-center"> <div class="col-lg-10"> <div class="title"> <h1 class="text-center"> 

@if ($row->old_version !=null)
{{$row->old_version}}<br>{{' من ' . unSlug($slug)}}
@else
<span>الإصدار</span> 
<span>{{$row->version . ' : '}}</span> 
<span>{{$row->day}}</span> 
<span>@if(intval($row->month) != 0 ) {{$months[intval($row->month) - 1]}} @else  {{$row->month}} @endif</span> 
<span>{{$row->year}}م</span> 
<br>
{{' من ' . unSlug($slug)}}
@endif 

</h1> </div></div></div></div><div class="overlay"></div></header> <section id="researches"> <div class="container"> <div class="row justify-content-center my-5"> <div class="col-lg-9"> <div class="box-white mb-4"> <h5 class="mb-2 font-weight-normal mb-3">البحث</h5> <form action="" method="GET"> <input type="text" class="form-control" name="search" value="@isset($_GET['search']){{trim($_GET['search'])}}@endisset" placeholder="اكتب اسم البحث"> <input type="submit" class="d-none"> </form> </div><div class="row"> @if (count($researches) > 0) @foreach ($researches as $res) <div class="col-12 mb-4"> <a href="{{url('researches/' . $res->slug)}}"> <div class="box-white" @if(strlen($res->title) == strlen(utf8_decode($res->title))) style="direction:ltr;text-align:left" @endif> <h2 class="title"  @if(strlen($res->title) == strlen(utf8_decode($res->title))) style="text-align:left !important" @endif>{{$res->title}}</h2> <span class="author-name text-secondary"><i class="fa-solid fa-user ml-1"></i> @if ($res->author_name==null){{'غير معروف'}}@else{{$res->author_name}}@endif </span> </div></a> </div>@endforeach @else <div class="col-12"> <div class="box-white py-5"> <h5 class=" text-center">لا توجد ابحاث</a></h5> </div></div>@endif </div></div><div class="col-lg-3"> <div class="row"> <div class="col-12"> <x-journals/> </div><div class="col-12"> <x-services list="true"/> </div><div class="col-12"> <x-blog/> </div></div></div></div></div></section> @endsection
