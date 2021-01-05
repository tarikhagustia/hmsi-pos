<?php


namespace App\Repositories;


use App\Branch;
use App\City;
use Illuminate\Support\Facades\Cache;

class BranchRepository
{
    public function getAll()
    {
        return Cache::remember('GET_ALL_BRANCH', 60 * 5, function (){
            return Branch::query()->orderBy('name')->get();
        });
    }
}
