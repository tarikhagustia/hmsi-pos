<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductStock;
use Faker\Generator as Faker;

$factory->define(ProductStock::class, function (Faker $faker) {
    return [
        'qty' => $faker->numberBetween(100, 300),
    ];
});
