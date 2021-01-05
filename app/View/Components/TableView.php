<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableView extends Component
{
    public $title;

    public $searchable;

    public $action;

    public $pagination;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = null, $searchable = null, $action = null, $pagination = null)
    {
        $this->title = $title;
        $this->searchable = $searchable;
        $this->action = $action;
        $this->pagination = $pagination;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.table-view');
    }
}
