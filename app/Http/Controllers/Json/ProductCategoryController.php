<?php

namespace App\Http\Controllers\Json;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ProductCategory;

class ProductCategoryController extends Controller
{
    public function all()
    {
        $categories = ProductCategory::orderBy('name')->get();

        return response()->json($categories);
    }
}
