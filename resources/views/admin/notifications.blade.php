@extends('admin.layouts.master')
@section('title', 'الإشعارات')
@section('content')
    <div class="container">
        <div class="box-white">
    <div>
            @foreach(Auth::guard('admin')->user()->notifications as $notification)
            @if ($notification->read_at == null)
            <li>
                <a class="dropdown-item" style="background-color: #cee0d0;" href="{{route('read-now', ['type'=>$notification->data['type'],'noti'=>$notification->id,'id'=>$notification->data['id']])}}"><i class="fa-sharp fa-solid fa-bell text-danger ml-2"></i> {!! $notification->data['body'] !!}
                    <p class="text-muted m-0"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</p>
                </a>
            </li>
            @else
            <li>
                <a class="dropdown-item" href="{{route('read-now', ['type'=>$notification->data['type'],'noti'=>$notification->id,'id'=>$notification->data['id']])}}"><i class="fa-sharp fa-solid fa-bell text-danger ml-2"></i> {!! $notification->data['body'] !!}
                    <p class="text-muted m-0"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</p>
                </a>
            </li>
            @endif
            <li role="separator" class="dropdown-divider"></li>
            @endforeach

        </div>


    </div>
@endsection
