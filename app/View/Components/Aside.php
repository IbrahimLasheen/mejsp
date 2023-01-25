<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Aside extends Component
{
    public $details;

    /*
    // Example
    /* 
            Single =  [
                'name' => 'الرئيسية',
                'icon' => '<i class="fa-solid fa-gauge-high"></i>',
                'link' => 'home'
            ];
            --------------------------
            Multble =  [
                'name' => 'المكتبة',
                'icon' => '<i class="fa-solid fa-photo-film"></i>',
                'sub_menu' => [
                    [
                        'name' => 'الصور',
                        'link' => 'library',
                    ],
                    [
                        'name' => 'اضافة جديد',
                        'link' => 'library/add-images',
                    ],
                ],
            ];

               <x-aside :details="$var" />
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.aside');
    }
}
