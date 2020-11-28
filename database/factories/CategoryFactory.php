<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'cover' => $faker->imageUrl(640, 480, 'animals', true),
        'description' => $faker->sentence(5),
        'title' => \Str::title($faker->words(2, true)),
    ];
});
