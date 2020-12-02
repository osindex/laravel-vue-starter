<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Dept;
use Faker\Generator as Faker;

$factory->define(Dept::class, function (Faker $faker) {
    return [
        'parent_id' => $faker->numberBetween(0, 2),
        'name' => $faker->companyPrefix,
    ];
});
