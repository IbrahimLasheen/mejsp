<nav dir="rtl" id="navbar" class="navbar navbar-expand-sm navbar-light fixed-top">

     <a class="navbar-brand" href="{{url('')}}"><img src="{{asset('assets/images/logo.png')}}" alt="مؤسسة الشرق الأوسط للنشر العلمي" title="مؤسسة الشرق الأوسط للنشر العلمي"></a> 
     <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"><i class="fa-solid fa-list-ul"></i></button>
        <div id="div-mobile">
            @if(Auth::guard('user')->check())

            <span class="badge badge-notify">{{Auth::guard('user')->user()->unreadNotifications ->count()}}</span>
            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fa-sharp fa-solid fa-bell"></i>
            </button>
            <ul class="dropdown-menu not-body">
                <div style="overflow-y: scroll;max-height:300px;" class="noti">
                    @foreach(Auth::guard('user')->user()->notifications->slice(0, 5) as $notification)
                    @if ($notification->read_at == null)
                    <li class="dropdown-item">
                        <a  href="{{userUrl('notification')}}" class="d-flex small text-dark p-2">
                            <i class="fa-sharp fa-solid fa-bell ml-2 d-none"></i>
                                <span>{!! $notification->data['body'] !!}</span>
                            </a>
                        <span class="text-muted mt-0 small"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</span>
                    </li>

                    @else
                    <li class="dropdown-item">
                        <a  href="{{userUrl('notification')}}" class="d-flex small text-dark p-2">
                            <i class="fa-sharp fa-solid fa-bell ml-2 d-none"></i>
                                <span>{!! $notification->data['body'] !!}</span>
                            </a>
                        <span class="text-muted mt-0 small"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</span>
                    </li>

                    @endif
                    <li role="separator" class="dropdown-divider"></li>

                    @endforeach
                </div>
                <li class="text-right mr-3 bg-white py-2">
                    <a href="{{userUrl('notification')}}" class="small text-dark">
                        <i class="fa-sharp fa-solid mt-2 fa-bell ml-2 small"></i>
                        جميع الإشعارات
                        </a>
                </li>
            </ul>

            @endif
        </div>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item"> <button title="بحث" class="nav-link btn-search"><i class="fa-solid fa-magnifying-glass"></i></button> </li>
                @if($front_sections['blog'] == 1) <li class="nav-item"> <a class="nav-link" href="{{url('blog')}}" title="المدونة">المدونة</a> </li>@endif
                @if($front_sections['blog_en'] == 1) <li class="nav-item"> <a class="nav-link" href="{{url('en/blog')}}" title="Blog">Blog</a> </li>@endif
                @if($front_sections['journals'] == 1) 
                <li class="nav-item @if($front_sections['journals'] != 1) d-none @endif"> <a class="nav-link " href="{{url('journals')}}" title="المجلات"
                   >المجلات</a> </li>
                @endif
                @if($front_sections['international_conference'] == 1) 
                <li class="nav-item @if($front_sections['international_conference'] != 1) d-none @endif"> <a class="nav-link btn-second" href="{{userUrl('conference/create')}}" title="طلب الانضمام لمؤتمر دولي">طلب الانضمام لمؤتمر دولي</a> </li>
                @endif
                @if($front_sections['international_publishing'] == 1) 
                <li class="nav-item @if($front_sections['international_publishing'] != 1) d-none @endif"> <a class="nav-link btn-second" href="{{userUrl('international-publishing/create')}}" title="النشر الدولي">النشر الدولي</a> </li>
                @endif
                @if($front_sections['add_research'] == 1) 
                <li class="nav-item">
                    <a class="nav-link btn-second @if($front_sections['add_research'] != 1) d-none @endif" href="{{userUrl('researches')}}" title="تقديم دراسة">تقديم دراسة</a>
                </li>
                @endif


                <style>
                    #div-desktop {
                        display: none;
                    }

                    @media screen and (min-width: 500px) {
                        #div-mobile {
                            display: none;
                        }

                        #div-desktop {
                            display: block;
                        }
                    }

                    .badge-notify {
                        background: red;
                        /* position: absolute;
                        top: 18px;
                        left: 77px; */
                        margin-right: 1%;
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
                        display: inherit !important;
                    }
                </style>
                @if (Auth::guard('user')->check())
                <li class="nav-item ml-3"> 
                <a class="nav-link btn-main" href="{{userUrl('dashboard')}}">لوحه التحكم</a> </li>
                @else
                <li class="nav-item ml-3"> <a class="nav-link btn-main" href="{{url('login')}}" title="المجلات">دخول</a> </li>
                @endif
            </ul>
        </div>
        <div id="div-desktop">
            @if(Auth::guard('user')->check())
            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                <span class="badge badge-notify">{{Auth::guard('user')->user()->unreadNotifications ->count()}}</span>

                <i class="fa-sharp fa-solid fa-bell"></i>

            </button>

            <ul class="dropdown-menu not-body">
                <div style="overflow-y: scroll;max-height:300px;" class="noti">
                    @foreach(Auth::guard('user')->user()->notifications->slice(0, 5) as $notification)
                    @if ($notification->read_at == null)
                    <li class="dropdown-item">
                         <a class="d-flex small text-dark" href="{{userUrl('notification')}}"><i class="fa-sharp fa-solid mt-2 fa-bell ml-2 small text-dark"></i>
                            {!! $notification->data['body'] !!}
                        </a>
                        <span class="text-muted mt-0 small"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</span>
                    </li>

                    @else
                    <li class="dropdown-item">
                    <div class=" d-flex small text-dark">
                        <i class="fa-sharp fa-solid mt-2 fa-bell ml-2 small text-dark"></i>
                        <div>
                            <span>{!! $notification->data['body'] !!}</span>
                            <a href="/u/researches/all" class="small">
                                  الاطلاع على حاله طلبك
                              </a>
                        </div>
                    </div>
                    <span class="text-muted small ml-2"><i class="fa-regular fa-clock"></i> {{$notification->created_at->diffforhumans()}}</span>
                    </li>

                    @endif
                    <li role="separator" class="dropdown-divider"></li>

                    @endforeach

                </div>
                <li class="text-right mr-3 bg-white py-2">
                    <a href="{{userUrl('notification')}}" class="small text-dark">
                        <i class="fa-sharp fa-solid mt-2 fa-bell ml-2 small"></i>
                        جميع الإشعارات
                        </a>
                </li>
            </ul>

            @endif
        </div>
    </div>
</nav>