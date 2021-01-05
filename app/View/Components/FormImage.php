<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormImage extends Component
{
    public $label;

    public $labelCurrent;

    public $name;

    public $imageUrl;

    public $error;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $label,
        $labelCurrent = 'Gambar saat ini',
        $name = 'image',
        $imageUrl = null,
        $error = null
    )
    {
        $this->label = $label;
        $this->labelCurrent = $labelCurrent;
        $this->name = $name;
        $this->imageUrl = $imageUrl;
        $this->error = $error;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form-image');
    }
}
