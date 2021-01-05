<?php


namespace App\Repositories;


use App\City;
use Illuminate\Support\Facades\Cache;

class CityRepository
{
    public function getAllCities()
    {
        return Cache::remember('GET_ALL_CITIES', 60 * 5, function (){
            return City::query()->orderBy('city_name')->get();
        });
    }
}
