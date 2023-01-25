<aside id="aside" class="col-lg-3 col-md-4 mb-4">

    <div class="box-white p-2">
        <div class="open-menu p-1">
            القائمة
            <i class="fas fa-angle-down float-left mt-1"></i>
            <div class="clearfix"></div>
        </div><!-- Toggle -->
        <ul id="menu" class=" mb-0" >
            <hr>

            <li class="{{ activeLink(userPrefix() . '/dashboard') }}"><a href="{{ userUrl('dashboard') }}">
                    <i class="fas fa-columns"></i> لوحة التحكم</a>
            </li>
            @if($front_sections['international_conference'] == 1) 
            <li class="{{ activeLink(userPrefix() . '/conference/create') }}"><a
                    href="{{ userUrl('conference/create') }}"><i class="fa-solid fa-file-circle-plus"></i> طلب الانضمام لمؤتمر دولي</a>
            </li>
            @endif

            @if($front_sections['international_publishing'] == 1) 
            <li class="{{ activeLink(userPrefix() . '/international-publishing/create') }}"><a
                    href="{{ userUrl('international-publishing/create') }}"><i class="fa-solid fa-bullhorn"></i> النشر
                    الدولي</a>
            </li>
            @endif

            @if($front_sections['add_research'] == 1) 
            <li class="{{ activeLink(userPrefix() . '/researches') }}"><a href="{{ userUrl('researches') }}"><i class="fa-solid fa-file-word"></i> تقديم دراسة</a>
            </li>
            @endif
            <li class="{{ activeLink(userPrefix() . '/researches/all') }}"><a href="{{ userUrl('researches/all') }}"><i class="fa-solid fa-file-word"></i> عرض الطلبات </a>
            </li>
            <li class="{{ activeLink(userPrefix() . '/count-publication-prices') }}"><a href="{{ userUrl('count-publication-prices') }}"><i class="fa-solid fa-money-bill"></i> حساب رسوم النشر  </a>
            </li>
            <li class="{{ activeLink(userPrefix() . '/invoice/my-invoices') }}"><a href="{{ userUrl('invoice/my-invoices') }}"><i class="fa-solid fa-file-invoice-dollar"></i> فواتيري  </a>
            </li>
            <li class="{{ activeLink(userPrefix() . '/researches/chats/old-chats') }}"><a href="{{ userUrl('researches/chats/old-chats') }}"><i class="fa-solid fa-message"></i> محادثاتي السابقة  </a>
            </li>

            <hr>
            <li
                class="@if (getAuth('user', 'qualification') == null && getAuth('user', 'country_code') == null) {{ 'bg-danger shadow' }} @endif mb-0 {{ activeLink(userPrefix() . '/settings') }}">
                <a href="{{ userUrl('settings') }}"><i class="fas fa-cog"></i> الاعدادات</a>
            </li>
            <hr>
            <li><a href="{{ url(userPrefix() . '/logout') }}"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>
            </li>
        </ul>
    </div>


</aside>
<!-- End Aside Links-->
@if (getAuth('user', 'email_verified_at') == null)
    <!-- Box email_verification_token --->
    <div id="email_verification_token" class="">
        تأكيد البريد الالكتروني
        <form class="d-inline-block" action="{{ userUrl('email-verification') }}" method="post">
            @csrf
            <button type="submit" class="badge badge-light">تأكيد حسابي</button>
        </form>
    </div>
@endif
