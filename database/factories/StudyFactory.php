<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Study;
use App\Teacher;
use Faker\Generator as Faker;

$factory->define(Study::class, function (Faker $faker) {
    $teacher = Teacher::inRandomOrder()->first();

    return [
        'name' => $faker->sentence,
        'desc' => $faker->paragraph,
        'price' => $faker->numberBetween(500000, 1000000),
        'number_of_meeting' => rand(1, 2),
        'teachers' => [$teacher->id],
        'payment_type' => 'MONTHLY',
    ];
});
