<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'branch_id' => 1,
        'sku' => $faker->numberBetween(9000000, 9999999),
        'name' => $faker->sentence(2),
        'desc' => $faker->paragraphs(3, true),
        'price' => $faker->randomFloat(),
        'status' => 'ACTIVE'
    ];
});

$factory->state(Product::class, 'fruit', function (Faker $faker) {
    $faker->addProvider(new \FakerRestaurant\Provider\id_ID\Restaurant($faker));

    return [
        'sku' => $faker->numberBetween(9000000, 9999999),
        'name' => $faker->fruitName,
        'desc' => $faker->paragraphs(3, true),
        'price' => $faker->numberBetween(10000, 100000),
        'status' => 'ACTIVE'
    ];
});
