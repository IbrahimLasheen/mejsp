<?php

namespace App\View\Components;

use App\Models\Articles;
use Illuminate\View\Component;

class Blog extends Component
{
 

    public function __construct()
    {
    
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $articles = Articles::select("title",'slug','version','id')->orderBy("id", 'DESC')->limit(6)->get();
        return view('components.blog',compact('articles'));
    }
}
