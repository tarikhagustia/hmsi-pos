<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasStatus;
    protected $appends = [
        'image_url',
        'quantity',
    ];

    protected $guarded = [];

    public function getFullNameAttribute()
    {
        return "[$this->sku] $this->name";
    }

    public function getImageUrlAttribute()
    {
        $isNull = is_null($this->image);
        $exists = \Storage::exists($this->image);

        if ($isNull || !$exists) {
            return 'https://dummyimage.com/320x320/f4f6f9/000.png&text=No+Image';
        }

        return asset('storage/'.$this->image);
    }

    public function getQuantityAttribute()
    {

        if (is_null($this->stocks)) {
            return 0;
        }

        return $this->stocks->qty;
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function stocks()
    {
        return $this->hasOne(ProductStock::class);
    }

    public function scopeBranch($builder, $id = null)
    {
        if (!$id) {
            return $builder->where('branch_id', Auth::user()->branch_id);
        }
        return $builder->where('branch_id', $id);
    }
}
