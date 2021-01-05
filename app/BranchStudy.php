<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchStudy extends Model
{
    protected $guarded = [];

    public function study()
    {
        return $this->belongsTo(Study::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function getNameAttribute()
    {
        return ($this->class_name != "") ? $this->class_name : "{$this->study->name} oleh {$this->teacher->name}";
    }
}
