@php $enTemplate=''; $ads=''; @endphp @extends('main.layouts.master') @section('title', $row->title)@section('keywords', str_replace(' ', ',', $row->title)) @section('description', $row->meta_desc) @section('type', 'Article')@section('url', urldecode($url)) @section('image', asset("assets/uploads/articles-en/$row->image")) @section('content') <section id="show-article" class="section mt-5"> <div class="container"> <div class="row"> <div class="col-xl-3 col-lg-4 col-md-12 max-width"> <div class="row"> <div dir="rtl" class="col-lg-12 text-right col-md-6 col-12"> <x-services list='true'/> </div><div class="col-lg-12 text-right col-md-6 col-12"> <x-journals/> </div></div><div class="widget "> <div class="section-title"> <h5>Latest Articles</h5> </div><ul class="widget-latest-posts"> @foreach ($latestArticles as $art) <li class="last-post mb-3 box-white p-1"> <div class="image float-left mr-2"> <a href="@if ($art->version=='old'){{url('blog-single.php?lang=en&id=' . $art->id . '&name=' . $art->title)}}@else{{url("en/article/$art->slug")}}@endif"> @if (file_exists(public_path("assets/uploads/thumbnails/articles-en/$art->image"))) <img class=" img-fluid cover" src="{{asset("assets/uploads/thumbnails/articles-en/$art->image")}}" alt="{{$art->title}}"> @else <img class=" img-fluid" src="{{asset('assets/images/article-defualt.jpg')}}" alt="{{$art->title}}"> @endif </a> </div><div class="content float-left"> <p> <a class=" text-dark" href="@if ($art->version=='old'){{url('blog-single.php?lang=en&id=' . $art->id . '&name=' . $art->title)}}@else{{url("en/article/$art->slug")}}@endif">{{Str::limit($art->title, 20)}}</a> </p></div><div class="clearfix"></div></li>@endforeach </ul> </div></div><div class="col-xl-9 col-lg-8 mb-5"> <div class="box-white mb-4"> <div class="post-single-image"> @if (file_exists(public_path("assets/uploads/articles-en/$row->image"))) <img class=" img-fluid cover mb-3" src="{{asset("assets/uploads/articles-en/$row->image")}}" alt="{{$row->title}}" title="{{$row->title}}"> @else <img class=" img-fluid cover mb-3" src="{{asset('assets/images/article-defualt.jpg')}}" alt="{{$row->title}}" title="{{$row->title}}"> @endif </div><div class="post-single-content"> <h1 class="title-name">{{$row->title}}</h1> </div><div class="post-single-body">{!! $row->content !!}</div></div><div class="row"> <div class="col-md-6 mb-3"> @if (!empty($prev)) <div class="widget"> <div class="widget-next-post"> <div class="box-white p-2"> <div class="image float-left mr-3"> <a href="@if ($prev->version=='old'){{url('blog-single.php?lang=en&id=' . $prev->id . '&name=' . $prev->title)}}@else{{url("en/article/$prev->slug")}}@endif"> @if (file_exists(public_path("assets/uploads/thumbnails/articles-en/$prev->image"))) <img class=" img-fluid cover lazy" data-src="{{asset("assets/uploads/thumbnails/articles-en/$prev->image")}}" alt="{{$prev->title}}"> @else <img class=" img-fluid cover lazy" data-src="{{asset('assets/images/article-defualt.jpg')}}" alt="{{$prev->title}}"> @endif </a> </div><div class="content float-left"> <div class="mb-2"> <a class="link" href="@if ($prev->version=='old'){{url('blog-single.php?lang=en&id=' . $prev->id . '&name=' . $prev->title)}}@else{{url("en/article/$prev->slug")}}@endif"> <i class="fa-solid fa-arrow-left-long mr-1"></i> Previous Article</a> </div><a class=" text-dark" href="@if ($prev->version=='old'){{url('blog-single.php?lang=en&id=' . $prev->id . '&name=' . $prev->title)}}@else{{url("en/article/$prev->slug")}}@endif">{{Str::limit($prev->title, 35)}}</a> </div><div class="clearfix"></div></div></div></div>@endif </div><div class="col-md-6"> @if (!empty($next)) <div class="widget"> <div class="widget-previous-post"> <div class="box-white p-2"> <div class="image float-left mr-3"> <a href="@if ($next->version=='old'){{url('blog-single.php?lang=en&id=' . $next->id . '&name=' . $next->title)}}@else{{url("en/article/$next->slug")}}@endif"> @if (file_exists(public_path("assets/uploads/thumbnails/articles-en/$next->image"))) <img class=" img-fluid cover lazy" data-src="{{asset("assets/uploads/thumbnails/articles-en/$next->image")}}" alt="{{$next->title}}"> @else <img class=" img-fluid cover lazy" data-src="{{asset('assets/images/article-defualt.jpg')}}" alt="{{$next->title}}"> @endif </a> </div><div class="content float-left"> <div class="mb-2"> <a class="link" href="@if ($next->version=='old'){{url('blog-single.php?lang=en&id=' . $next->id . '&name=' . $next->title)}}@else{{url("en/article/$next->slug")}}@endif"> <span>Next Article</span> <i class="fa-solid fa-arrow-right-long ml-1"></i> </a> </div><a class=" text-dark" href="@if ($next->version=='old'){{url('blog-single.php?lang=en&id=' . $next->id . '&name=' . $next->title)}}@else{{url("en/article/$next->slug")}}@endif">{{Str::limit($next->title, 35)}}</a> </div><div class="clearfix"></div></div></div></div>@endif </div></div></div></div></div></section> @endsection
