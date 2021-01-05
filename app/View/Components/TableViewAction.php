<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableViewAction extends Component
{
    public $show;

    public $edit;

    public $delete;

    public $inactive;

    public $publish;

    /**
     * Create a new component instance.
     *
     * @param null $show
     * @param null $edit
     * @param null $delete
     * @param null $inactive
     * @param null $publish
     */
    public function __construct($show = null,  $edit = null, $delete = null, $inactive = null, $publish = null)
    {
        $this->show = $show;
        $this->edit = $edit;
        $this->delete = $delete;
        $this->inactive = $inactive;
        $this->publish = $publish;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.table-view-action');
    }
}
