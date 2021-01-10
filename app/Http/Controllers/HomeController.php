<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->hasAnyRole(['Admin']))
        {
            $totalProducts = Product::branch()->count();
            $totalCategories = ProductCategory::branch()->count();
            $totalSelleProduct = OrderItem::whereHas('order', function($q){
                $q->where('branch_id', Auth::user()->branch_id);
            })->count();
            $totalGross = Order::branch()->sum('total_amount');
            return view('home', compact('totalProducts', 'totalCategories', 'totalSelleProduct', 'totalGross'));
        }

        return view('home_admin');

    }
}
