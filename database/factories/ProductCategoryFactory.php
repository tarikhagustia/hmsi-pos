<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
    return [
        'branch_id' => 1,
        'name' => $faker->sentence(2, true),
        'desc' => $faker->paragraphs(3, true),
    ];
});
