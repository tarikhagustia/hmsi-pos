<?php

use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\ProductCategory::class, 5)->create()->each(function ($category){
            $category->products()->save(factory(\App\Product::class)->make());
        });
    }
}
