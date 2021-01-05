<?php


namespace App\Repositories;


use App\Constants\CacheConstant;
use App\Product;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return Cache::remember(CacheConstant::PRODUCT_ALL, 60 * 1, function(){
            return $this->model->orderBy('name', 'asc')->get();
        });
    }
}
