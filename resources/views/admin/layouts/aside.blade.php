<aside id="aside" class="aside-scroll">

    <ul class="side-menu">

        <li class="side-item-category">الرئيسية</li>


        @php
            $home = [
                'name' => 'لوحة التحكم',
                'icon' => '<i class="fa-solid fa-gauge-high"></i>',
                'link' => 'home',
            ];
        @endphp
        <x-aside :details="$home" />
        <!-- Dashboard -->

        @if (getAuth('admin', 'role') == 'administrator')
            @php
                $payments = [
                    'name' => 'المدفوعات',
                    'icon' => '<i class="fa-solid fa-money-bill-1-wave"></i>',
                    'link' => 'payments',
                ];
            @endphp
            <x-aside :details="$payments" />
            <!-- payments -->

            @php
                $invoices = [
                    'name' => 'الفواتير',
                    'icon' => '<i class="fa-solid fa-file-invoice-dollar"></i>',
                    'link' => 'invoices',
                    'sub_menu' => [
                        [
                            'link' => 'invoices',
                            'name' => 'جميع الفواتير',
                        ],
                         [
                            'link' => 'invoices/journals',
                            'name' => 'فواتير المجلات',
                        ],
                        [
                            'name' => 'اضافة فاتورة جديدة',
                            'link' => 'invoices/create',
                        ],
                    ],
                ];
                /*
                                        [
                            'name' => 'اضافة فاتورة جديدة',
                            'link' => 'invoices/create',
                        ],
                        [
                            'name' => 'اضافة فاتورة مجله',
                            'link' => 'invoices/create-journals',
                        ],
                        */
            @endphp
            <x-aside :details="$invoices" />
            <!--  Invoices -->
        @endif




        <li class="side-item-category">المدونات & الخدمات</li>

        @php
            $article = [
                'name' => 'المقالات',
                'icon' => '<i class="fa-regular fa-newspaper"></i>',
                'sub_menu' => [
                    [
                        'name' => 'جميع المقالات',
                        'link' => 'articles',
                    ],
                    [
                        'name' => 'اضافة مقالة جديدة',
                        'link' => 'article/create',
                    ],
                ],
            ];
        @endphp
        <x-aside :details="$article" />
        <!-- End Articles AR -->

        @php
            $services = [
                'name' => 'الخدمات',
                'icon' => '<i class="fa-brands fa-buffer"></i>',
                'sub_menu' => [
                    [
                        'name' => 'جميع الخدمات',
                        'link' => 'services',
                    ],
                    [
                        'name' => 'اضافة خدمة جديدة',
                        'link' => 'services/create',
                    ],
                ],
            ];
        @endphp
        <x-aside :details="$services" />
        <!-- End Services -->


        @php
            $article_en = [
                'name' => 'Articles',
                'icon' => '<i class="fa-regular fa-newspaper"></i>',
                'sub_menu' => [
                    [
                        'name' => 'All Articles',
                        'link' => 'en/articles',
                    ],
                    [
                        'name' => 'Add New Article',
                        'link' => 'en/article/create',
                    ],
                ],
            ];
        @endphp
        <x-aside :details="$article_en" />
        <!-- End Articles EN -->


        @if (getAuth('admin', 'role') == 'administrator')
            <li class="side-item-category">المؤتمرات & المجلات</li>
            @php
                $conference = [
                    'name' => 'المؤتمرات',
                    'icon' => '<i class="fa-solid fa-handshake"></i>',
                    'sub_menu' => [
                        [
                            'name' => 'الطلبات',
                            'link' => 'conference/all',
                        ],
                        [
                            'name' => 'انواع الشهادة',
                            'link' => 'conference/categories',
                        ],
                    ],
                ];
            @endphp
            <x-aside :details="$conference" />
            <!-- End conference -->

            @php
                $journals = [
                    'name' => 'المجلات',
                    'icon' => '<i class="fa-solid fa-book-open"></i>',
                    'sub_menu' => [
                        [
                            'name' => 'جميع المجلات',
                            'link' => 'journals',
                        ],
                        [
                            'name' => 'الاصدارات',
                            'link' => 'versions',
                        ],
                        [
                            'name' => 'اضافة مجلة جديدة',
                            'link' => 'journals/create',
                        ],
                    ],
                ];
            @endphp
            <x-aside :details="$journals" />
            <!-- End Journals -->


            @php
                $researches = [
                    'name' => 'الابحاث',
                    'icon' => '<i class="fa-solid fa-file-pen"></i>',
                    'sub_menu' => [
                        [
                            'name' => 'جميع الابحاث',
                            'link' => 'researches',
                        ],
                        [
                            'name' => 'اضافة بحث جديد',
                            'link' => 'researches/create',
                        ],
                    ],
                ];
            @endphp
            <x-aside :details="$researches" />
            <!-- End researches -->


            @php
                $researches = [
                    'name' => 'النشر الدولي',
                    'icon' => '<i class="fa-solid fa-fax"></i>',
                    'sub_menu' => [
                        [
                            'name' => 'انوع النشر الدولي',
                            'link' => 'international-publishing/types-of-publication',
                        ],
                        [
                            'name' => 'التخصصات',
                            'link' => 'international-publishing/specialties',
                        ],
                        [
                            'name' => 'المجلات',
                            'link' => 'international-publishing/journals',
                        ],
                        [
                            'name' => 'الطلبات',
                            'link' => 'international-publishing/orders',
                        ],
                    ],
                ];
            @endphp
            <x-aside :details="$researches" />
            <!-- End researches -->



            @php
                $team = [
                    'name' => 'المحررون',
                    'icon' => '<i class="fa-solid fa-people-group"></i>',
                    'sub_menu' => [
                        [
                            'name' => 'جميع المحررون',
                            'link' => 'team',
                        ],
                        [
                            'name' => 'اضافة عضو جديد',
                            'link' => 'team/create',
                        ],
                    ],
                ];
            @endphp
            <x-aside :details="$team" />
            <!-- End Team -->

            @php
                $international_credits = [
                    'name' => 'الاعتمادات',
                    'icon' => '<i class="fa-solid fa-circle-check"></i>',
                    'link' => 'international',
                ];
            @endphp
            <x-aside :details="$international_credits" />
            <!-- End international_credits -->



            <li class="side-item-category">الاعضاء</li>
            @php
                $users = [
                    'name' => 'المستخدمين',
                    'icon' => '<i class="fa-solid fa-users"></i>',
                    'link' => 'users',
                ];
            @endphp
            <x-aside :details="$users" />
            <!-- End Users -->

            @php
                $admins = [
                    'name' => 'المشرفين',
                    'icon' => '<i class="fa-solid fa-user-gear"></i>',
                    'sub_menu' => [
                        [
                            'name' => 'جميع المشرفين',
                            'link' => 'admins',
                        ],
                        [
                            'name' => 'اضافة مشرف جديد',
                            'link' => 'create/admin',
                        ],
                    ],
                ];
            @endphp
            <x-aside :details="$admins" />
            <!-- End admins -->
            
            @php
                $user_researches = [
                    'name' => 'أبحاث المستخدمين',
                    'icon' => '<i class="fa-solid fa-file-pen"></i>',
                    'sub_menu' => [
                        [
                            'name' => 'جميع الأبحاث ',
                            'link' => 'users/user-researches',
                        ],
                        [
                            'name' => ' بانتظار التعديل ',
                            'link' => 'users/user-researches/5',
                        ],
                        [
                            'name' => 'قيد المعالجة  ',
                            'link' => 'users/user-researches/1',
                        ],
                        [
                            'name' => 'تحت المراجعة  ',
                            'link' => 'users/user-researches/2',
                        ],
                        [
                            'name' => 'المقبولة  ',
                            'link' => 'users/user-researches/3',
                        ],
                        [
                            'name' => 'المرفوضة  ',
                            'link' => 'users/user-researches/4',
                        ],
                    ],
                ];
            @endphp
            <x-aside :details="$user_researches" />
            <!-- End user_researches -->



            <li class="side-item-category">عام</li>



            @php
                $faqs = [
                    'name' => 'الأسئلة الشائعة',
                    'icon' => '<i class="fa-solid fa-question"></i>',
                    'sub_menu' => [
                        [
                            'name' => 'جميع الأسئلة',
                            'link' => 'faqs',
                        ],
                        [
                            'name' => 'اضافة سؤال جديد',
                            'link' => 'faqs/create',
                        ],
                    ],
                ];
            @endphp
            <x-aside :details="$faqs" />
            <!-- End faqs -->

            @php
            $settings = [
                'name' => 'الاعدادات',
                'icon' => '<i class="fa-solid fa-gear"></i>',
                'sub_menu' => [
                    [
                        'name' => 'الكل',
                        'link' => 'settings',
                    ],
                    [
                        'name' => 'البريد الالكتروني',
                        'link' => 'settings/email_confirmation_alerts',
                    ],
                ],
            ];
        @endphp
        <x-aside :details="$settings" />
            {{-- @php
                $settings = [
                    'name' => 'الاعدادات',
                    'icon' => '<i class="fa-solid fa-gear"></i>',
                    'link' => 'settings',
                ];
            @endphp
            <x-aside :details="$settings" />
            <!-- settings --> --}}
        @endif


        <li class="side-item">
            <a class="" target="__blank" href="{{ url('') }}">
                <span class="side-icon"><i class="fa-solid fa-globe"></i></span>
                <span class="side-name-lable">زيارة الموقع</span>
            </a>
        </li><!-- visit site -->

        <li class="side-item">
            <a class="" href="{{ adminUrl('logout') }}">
                <span class="side-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                <span class="side-name-lable">تسجيل الخروج</span>
            </a>
        </li><!-- logout -->


        <div class="aside-overlay"></div>

        <!---OverLay -->
</aside><!-- End Aside Bar -->
