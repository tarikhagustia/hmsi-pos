<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


// Authenticated Route
Route::middleware('auth')->group(function () {

    Route::get('/', 'HomeController@index')->name('home');

    // Admin Routes
    Route::prefix('admin')->group(function () {
        Route::resource('branches', 'BranchController')->except('show');


        Route::resource('pos', 'PosController')->only('index', 'store');

        Route::resource('product-categories', 'ProductCategoryController')->except('show');
        Route::post('product-categories/{productCategory}/inactive', 'ProductCategoryController@inactive')->name('product-categories.inactive');
        Route::post('product-categories/{productCategory}/publish', 'ProductCategoryController@publish')->name('product-categories.publish');

        Route::resource('products', 'ProductController')->except('show');
        Route::post('products/{product}/inactive', 'ProductController@inactive')->name('products.inactive');
        Route::post('products/{product}/publish', 'ProductController@publish')->name('products.publish');


        Route::resource('users', 'UserController')->except('show');


        Route::get('reports/inventories', 'Report\InventoryReport@index')->name('report.inventory');
        Route::get('reports/inventories/{product}', 'Report\InventoryReport@show')->name('report.inventory.show');
        Route::get('reports/sales', 'Report\SaleReportController@index')->name('report.sale');
        Route::post('reports/sales', 'Report\SaleReportController@store')->name('report.sale.post');
        Route::get('reports/sales/{code}', 'Report\SaleReportController@show')->name('report.sale-show');

        Route::resource('profile', 'ProfileController')->only(['index', 'update']);

        Route::get('print', 'PrintController@print');
    });

    Route::prefix('json')->group(function () {
        Route::get('customers/all', 'Json\CustomerController@all');

        Route::get('product-categories/all', 'Json\ProductCategoryController@all');

        Route::get('products/all', 'Json\ProductController@all');

        Route::get('provinces/{id}/cities', 'CityController@getByProvince');

        Route::post('orders', 'Json\OrderController@store');
    });
});
