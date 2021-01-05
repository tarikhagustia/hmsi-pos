<?php

namespace App\View\Components;

use App\Teacher;
use Illuminate\View\Component;

class TeacherCard extends Component
{
    protected $teacher;
    /**
     * Create a new component instance.
     *
     * @param Teacher $teacher
     */
    public function __construct(Teacher $teacher)
    {
        $this->teacher = $teacher;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $teacher = $this->teacher;
        return view('components.teacher-card', compact('teacher'));
    }
}
