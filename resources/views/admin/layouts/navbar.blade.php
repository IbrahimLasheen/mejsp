<nav id="navbar">
    <div id="btn-aside-toggle"><i class="fas fa-bars"></i></div>


    @if(Auth::guard('admin')->check())
    <span class="badge badge-notify">{{Auth::guard('admin')->user()->unreadNotifications ->count()}}</span>
    <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" style="margin-left: 30px;">
        <i class="fa-sharp fa-solid fa-bell"></i>
    </button>
    <ul class="dropdown-menu not-body" style="transform: translate3d(52px, 62px, 0px);">
    <div style="overflow-y: scroll;max-height:300px;">
            @foreach(Auth::guard('admin')->user()->notifications->slice(0, 5) as $notification)
            @if ($notification->read_at == null)
            <li>
                 @if ($notification->data['type'] == 'chat') 
                <a class="dropdown-item" style="background-color: #cee0d0;" href="/admin/users/chat/{{ $notification->data['id'] }}?notification_id={{ $notification->id }}"><i class="fa-sharp fa-solid fa-bell text-danger ml-2"></i> {!! $notification->data['body'] !!}
                    <p class="text-muted m-0"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</p>
                </a>
                @else
                <a class="dropdown-item" style="background-color: #cee0d0;" href="{{route('read-now', ['type'=>$notification->data['type'],'noti'=>$notification->id,'id'=>$notification->data['id']])}}"><i class="fa-sharp fa-solid fa-bell text-danger ml-2"></i> {!! $notification->data['body'] !!}
                    <p class="text-muted m-0"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</p>
                </a>
                @endif
            </li>
            @else
            <li>
                @if ($notification->data['type'] == 'chat') 
                <a class="dropdown-item" href="/admin/users/chat/{{ $notification->data['id'] }}">
                    <i class="fa-sharp fa-solid fa-bell text-danger ml-2"></i> {!! $notification->data['body'] !!}
                    <p class="text-muted m-0"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</p>
                </a>
                @else 
                <a class="dropdown-item" href="{{route('read-now', ['type'=>$notification->data['type'],'noti'=>$notification->data['id'],'id'=>$notification->data['id']])}}"><i class="fa-sharp fa-solid fa-bell text-danger ml-2"></i> {!! $notification->data['body'] !!}
                    <p class="text-muted m-0"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</p>
                </a>
                @endif
                
            </li>
            @endif
            <li role="separator" class="dropdown-divider"></li>
            @endforeach

        </div>
      
        <li class="text-center bg-white" style="font-size: 18px;">
            <a class="" href="{{adminUrl('notification')}}">جميع الإشعارات</a>
        </li>

    </ul>

    @endif
    <style>
        .scrollable-bootstrap-menu ul {
            height: auto;
            max-height: 50px;
            overflow-x: hidden;
        }

        .ss {
            list-style: none;
            padding: 5px 0;
        }

        .badge-notify {
            background: red;
            position: absolute;
            top: 11px;
            left: 96px;
            border-radius: 50%;
            color: white;
        }

        .dropdown-menu {
            max-width: 25rem !important;
            line-height: 24px;
            text-align: right;
            margin-left: 2rem;
            border-bottom: 3px solid darkred;
        }

        .dropdown-item {
            width: 100% !important;
            white-space: normal !important;
        }
    </style>
    <div class="profile toast-title" data-toggle="tooltip" data-placement="bottom" title="حسابي">
        <a href="{{ adminUrl("profile") }}"><img src="{{ getAuth('admin','image') == null ? asset('admin-assets/images/default-profile-image.png') : asset("admin-assets/uploads/admins/".getAuth('admin','image'))}}"></a>
    </div>


</nav><!-- NavBar -->