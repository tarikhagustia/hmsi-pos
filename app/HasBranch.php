<?php

namespace App;

trait HasBranch {
    public function scopeForBranch($query)
    {
        return $query->where('branch_id', request()->user()->branch_id);
    }
}
