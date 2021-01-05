<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MainContent extends Component
{
    public $title;

    public $bread;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = null, $bread = null)
    {
        $this->title = $title;
        $this->bread = $bread;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.main-content');
    }
}
