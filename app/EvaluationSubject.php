<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationSubject extends Model
{
    protected $guarded = [];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function category()
    {
        return $this->belongsTo(StudyCategory::class);
    }

}
