@php $journal=''; @endphp @extends('main.layouts.master')@section('title', $row->name)@section('keywords', str_replace(' ', ',', $row->name))@section('description', $row->meta_desc)@section('type', 'journals')@section('url', urldecode(Request::url()))@section('image', asset("assets/uploads/journals/$row->cover"))@section('content')@include('main.journals.header') <section id="journals"> <div class="container"> <div class="row justify-content-center my-5"> <div class="col-xl-9 col-lg-12"> <div class="row"> <x-journal-contact address="{{$row->address}}" email="{{$row->email}}" phone="{{$row->phone}}"/> <div class="col-12 mt-5"> @if (count($internationalCredits) > 0) <div id="carousel-sections" class="mb-5"> <h2 class="section-title mb-5">الاعتمادات الدولية</h2> <div class="international-owl-carousel owl-carousel owl-theme"> @foreach ($internationalCredits as $inter) <div class="item"> <div class="box-white p-1"> @if (checkFile('assets/uploads/international-credits/' . $inter->image)) <img class="p-3" src="{{asset('assets/uploads/international-credits/' . $inter->image)}}"/> @else <img src="{{asset('assets/images/notfound.png')}}"/> @endif </div></div>@endforeach </div></div>@endif @if (count($team) > 0) <div id="carousel-sections" class="mb-5"> <h2 class="section-title mb-5">فريق التحرير</h2> <div class="team-owl-carousel owl-carousel owl-theme"> @foreach ($team as $te) <div class="item"> <div class="box-white team-box p-3 text-center"> <div class="image-box d-inline-block mb-2"> @if (checkFile('assets/uploads/team/' . $te->image)) <img src="{{asset('assets/uploads/team/' . $te->image)}}" alt="{{$te->name}}" title="{{$te->name}}"> @else <img src="{{asset('assets/images/notfound.png')}}" alt="{{$te->name}}" title="{{$te->name}}"> @endif </div><h6 class="text-center">{{Str::limit($te->name, 35)}}</h6> <small class="text-muted">{{Str::limit($te->job, 90)}}</small> <div class="links text-center mt-4 mb-2"> @if ($te->linkedin !=null) <a href="{{$te->linkedin}}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a> @endif @if ($te->email !=null) <a href="mailto:{{$te->email}}"><i class="fa-solid fa-envelope"></i></a> @endif @if ($te->website !=null) <a href="{{$te->website}}" target="_blank"><i class="fa-solid fa-globe"></i></a> @endif </div></div></div>@endforeach </div></div>@endif @if (count($versions) > 0) <div id="carousel-sections" class="mb-5"> <h2 class="section-title mb-4">إصدارات المجلة</h2> <div class="versions-owl-carousel owl-carousel owl-theme"> @foreach ($versions as $ver) <a href="@if ($ver->old_version !=null){{url('researches/' . $row->slug . '/version' . '/' . $ver->id)}}@else{{url('researches/' . $row->slug . '/version' . '/' . $ver->id)}}@endif" class="text-dark"> <div class="item"> <div class="box-white p-3"> @if ($ver->old_version !=null) <span class=" d-block">{{$ver->old_version}}</span> @else <span class="d-block"> <span>الإصدار</span> <span>{{$ver->version . ' : '}}</span> <span>{{$ver->day}}</span> <span>@if(intval($ver->month) != 0) {{$months_names[intval($ver->month) - 1]}} @else {{$ver->month}}  @endif</span> <span>{{$ver->year}}م</span> </span> @endif @if ($loop->index==0) <small class="latest-version badge badge-primary text-white">احدث إصدار</small> @endif </div></div></a> @endforeach </div></div>@endif </div><div class="col-12 mb-5"> <h2 class="section-title mb-4">الهدف و الرؤية</h2> <div class="box-white p-3"> <p class="mb-0">{{$row->brief_desc}}</p></div></div>@if ($row->ethics !=null) <div class="col-12 mb-5"> <h2 class="section-title mb-4">أخلاقيات النشر</h2> <div class="box-white p-3">{!! $row->ethics !!}</div></div>@endif @if ($row->authors_instructions !=null) <div class="col-12 mb-5"> <h2 class="section-title mb-4">تعليمات للمراجعين</h2> <div class="box-white p-3">{!! $row->authors_instructions !!}</div></div>@endif @if ($row->reviewers_instructions !=null) <div class="col-12 mb-5"> <h2 class="section-title mb-4">تعليمات للمؤلفين</h2> <div class="box-white p-3">{!! $row->reviewers_instructions !!}</div></div>@endif </div></div><div class="col-xl-3 col-lg-12"> <div class="row"> <div class="col-12"> <x-services :details="$services" list="true"/> </div><div class="col-12"> <x-journals/> </div><div class="col-12"> <x-blog/> </div></div></div></div></div></section> @endsection