<?php

namespace App\Http\Controllers\Json;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Product;

class ProductController extends Controller
{
    public function all()
    {
        $query = Product::orderBy('name');

        if (request()->has('category')) {
            $query->where('category_id', request()->category);
        }

        $products = $query->get();

        return response()->json($products);
    }
}
