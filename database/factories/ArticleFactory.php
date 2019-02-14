<?php

use Carbon\Carbon;
use App\Models\ArticleCategory;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Article::class, function (Faker $faker) {

    $category_ids = ArticleCategory::where('status', true)->get()->pluck('id')->toArray();

    return [
        'category_id' => $faker->randomElement($category_ids),
        'title' => $faker->sentence,
        'cover' => $faker->imageUrl(),
        'description' => $faker->sentence,
        'content' => $faker->text,
        'published_at' => Carbon::now(),
    ];
});
