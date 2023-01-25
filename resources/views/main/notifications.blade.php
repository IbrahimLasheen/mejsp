@extends('main.layouts.master')
@section('title', 'الإشعارات')
@section('content')
<section>
    <div class="container">
        <div class="row">

            <div class="col-12 mb-4">
                <h5 class="page-name"></h5><!-- Page Name -->
            </div>

            <!-- Include Aside -->
            @include('main.user.aside')

            <div class="col-lg-9">



                <div class="row">
                    <div class="col-12">

                        <div class="box-white">

                            @foreach(Auth::guard('user')->user()->notifications as $notification)
                            @if ($notification->read_at == null)

                            <li style="background-color: #cee0d0;" class="p-2 rounded">
                                {{-- <a class="dropdown-item" style="background-color: #cee0d0;" href="{{route('read_notificatio', $notification->id)}}"><i class="fa-sharp fa-solid fa-bell text-danger ml-2"></i> --}} {!! $notification->data['body'] !!} 
                                    
                               {{-- </a> --}}
                              <div class="d-block d-md-flex mt-2">
                                   <p class="text-muted"><i class="fa-regular fa-clock"></i> {{$notification->created_at->diffforhumans()}}</p>
                             @if($notification->data['type'] =="post" || $notification->data['type'] =="chat")
                                <a href="{{ userUrl('chat/'.$notification->data['id'])}}" class="mr-4">
                                  الاطلاع على حاله طلبك 
                                </a>
                                @elseif($notification->data['type'] == 'researche' || $notification->data['type'] =="approve")
                                <a href="{{route('current_user_researches',['id'=>$notification->data['id']])}}" class="mr-4">
                                  الاطلاع على حاله طلبك
                                </a>
                                @else
                                <a href="/u/researches/all" class="mr-4">
                                  الاطلاع على حاله طلبك
                                </a>
                                @endif
                               <a href="{{route('read_notificatio', $notification->id)}}" class="mr-4">
                                  تحديد كمقروء
                                </a>
                              </div>
                            </li>
                            @else

                            <li>
                                {!! $notification->data['body'] !!}
                             <div class="d-block d-md-flex mt-2">
                                   <p class="text-muted"><i class="fa-regular fa-clock"></i> {{$notification->created_at->diffforhumans()}}</p>
                              <a href="/u/researches/all" class="mr-4 ">
                                  الاطلاع على حاله طلبك
                              </a>
                               <p class="mr-4 text-muted">
                                        تم القراءة 
                                </p>
                              </div>
                            </li>
                            @endif
                            <li role="separator" class="dropdown-divider"></li>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
</section>
<div style="padding-top: 20px;"></div>

@endsection