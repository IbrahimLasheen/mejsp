<?php

namespace App\View\Components;

use Illuminate\View\Component;

class JournalContact extends Component
{
    public $address;
    public $phone;
    public $email;
    public function __construct($address , $phone , $email)
    {
        $this->address  = $address;
        $this->phone  = $phone;
        $this->email  = $email;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.journal-contact');
    }
}
