<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormSelect extends Component
{
    public $label;

    public $name;

    public $dataSources;

    public $tags;

    public $initial;

    public $triggerChange;

    public $value;

    public $error;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $label = null,
        $name = null,
        $dataSources = [],
        $tags = false,
        $initial = true,
        $triggerChange = true,
        $value = null,
        $error = null
    )
    {
        $this->label = $label;
        $this->name = $name;
        $this->dataSources = $dataSources;
        $this->tags = $tags;
        $this->initial = $initial;
        $this->triggerChange = $triggerChange;
        $this->value = $value;
        $this->error = $error;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form-select');
    }
}
