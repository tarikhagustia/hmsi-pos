<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;

class ProductCategory extends Model
{
    use HasStatus;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
