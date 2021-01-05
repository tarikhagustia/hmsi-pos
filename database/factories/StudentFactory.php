<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use App\Student;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Student::class, function (Faker $faker) {
    $city = City::inRandomOrder()->first();
    $schoolLevels = [
        'SD' => [1, 2, 3, 4, 5, 6],
        'SMP' => [1, 2, 3],
        'SMA' => [1, 2, 3],
    ];
    $levels = array_keys($schoolLevels);
    $level = $levels[array_rand($levels, 1)];
    $class = $schoolLevels[$level][array_rand($schoolLevels[$level], 1)];
    $guardianTypes = ['Ayah', 'Ibu'];
    $guardianType = $guardianTypes[array_rand($guardianTypes, 1)];

    return [
        'student_uid' => Str::random(10),
        'name' => $faker->name,
        'email' => $faker->email,
        'address' => $faker->address,
        'city_id' => $city->city_id,
        'zip_code' => $faker->numberBetween(4000, 4999),
        'phone_number' => $faker->phoneNumber,
        'school_name' => $faker->sentence,
        'school_address' => $faker->address,
        'school_level' => $level,
        'school_class' => $class,
        'guardian_name' => $faker->name,
        'guardian_type' => $guardianType,
        'guardian_phone_number' => $faker->phoneNumber,
        'guardian_address' => $faker->address,
        'guardian_job' => $faker->jobTitle,
        'status' => 'ACTIVE',
        'comment' => null,
        'avatar' => null,
    ];
});
