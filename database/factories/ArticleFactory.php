<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween(1, 6),
        'content' => implode('<br/><br/>', $faker->paragraphs(8)),
        'description' => $faker->sentence(5),
        'published_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'cover' => $faker->imageUrl(640, 480),
        'title' => Str::title($faker->words(4, true)),
        'state' => $faker->numberBetween(0, 1),
    ];
});
