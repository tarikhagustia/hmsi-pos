<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;

class Study extends Model
{
    use HasStatus;

    const PAYMENT_TYPE_MONTHLY = 'MONTHLY';
    const PAYMENT_TYPE_PACKAGE = 'PACKAGE';

    protected $casts = [
        'references' => 'array',
        'teachers' => 'array',
        'payment_terms' => 'array'
    ];

    protected $guarded = [];

    protected $appends = ['name'];

    public function isRecurring()
    {
        return $this->payment_type == static::PAYMENT_TYPE_PACKAGE;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function teacher()
    {
        $teacher = Teacher::whereIn('id', $this->teachers)->first();

        return $teacher;
    }

    public function teachers()
    {
        $teachers = Teacher::whereIn('id', $this->teachers)->get();

        return $teachers;
    }

    public function getNameAttribute()
    {
        return "{$this->unit} {$this->level} {$this->number_of_meeting}x";
    }

}
