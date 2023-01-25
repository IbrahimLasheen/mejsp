<?php

namespace App\View\Components;

use App\Models\Journals as ModelsJournals;
use Illuminate\View\Component;

class Journals extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $journals = ModelsJournals::select("name",'slug')->orderBy("id", 'DESC')->get();

        return view('components.journals',compact('journals'));
    }
}
