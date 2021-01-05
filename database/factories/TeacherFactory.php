<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Teacher;
use Faker\Generator as Faker;

$factory->define(Teacher::class, function (Faker $faker) {
    return [
        'nip' => $faker->nik(),
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'address' => $faker->address,
        'city_id' => 1102,
        'zip_code' => 43192,
        'phone_number' => $faker->phoneNumber,
        'status' => 'ACTIVE',
        'comment' => null,
        'avatar' => null
    ];
});
