<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryReport extends Controller
{
    public function index()
    {
        $products = ProductStock::with(['product', 'branch'])
            ->where('branch_id', Auth::user()->branch_id)
            ->paginate(25);

        $products->appends(['search' => request()->search]);
        return view('reports.inventory', compact('products'));
    }

    public function show(ProductStock $product) {
        return view("reports.inventory_movement", compact('product'));
    }
}
