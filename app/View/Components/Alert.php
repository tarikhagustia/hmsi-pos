<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $title;
    
    public $message;
    
    public $type;

    public $icons = [
        'success' => 'check',
        'danger' => 'times',
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'Success', $message = '', $type = 'success')
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
