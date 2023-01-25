<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InterOrders extends Component
{
    public $details;


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
        return view('components.inter-orders');
    }
}
