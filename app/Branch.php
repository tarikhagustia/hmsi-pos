<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = [];

    public function admin()
    {
        return $this->hasOne(User::class);
    }

    public function studies()
    {
        return $this->hasMany(Study::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function study()
    {
        return $this->hasMany(BranchStudy::class);
    }

}
