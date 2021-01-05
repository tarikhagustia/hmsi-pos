<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasStatus;

class Teacher extends Model
{
    use HasBranch, HasStatus;

    protected $guarded = [];

    public function getAvatarUrlAttribute()
    {
        return ($this->avatar) ? Storage::url($this->avatar) : "https://www.gravatar.com/avatar/". md5(strtolower($this->email));
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
