<?php

namespace App\View\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class Services extends Component
{
    public $details;
    public $col;
    public $list;
    public function __construct($details = null, $list = false, $col = "col-lg-2 col-6")
    {
        $this->col = $col;

        $this->list = $list;

        if ($details == null) {
            $this->details = DB::table('services')->get();
        } else {
            $this->details = $details;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.services');
    }
}
