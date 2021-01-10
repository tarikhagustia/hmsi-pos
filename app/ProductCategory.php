<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;
use Illuminate\Support\Facades\Auth;

class ProductCategory extends Model
{
    use HasStatus;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function scopeBranch($builder, $id = null)
    {
        if (!$id) {
            return $builder->where('branch_id', Auth::user()->branch_id);
        }
        return $builder->where('branch_id', $id);
    }
}
