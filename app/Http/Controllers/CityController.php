<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\City;

class CityController extends Controller
{
    public function getByProvince($id)
    {
        $cities = City::where('province_id', $id)
            ->orderBy('city_name')
            ->get();

        return response()->json($cities);
    }
}
