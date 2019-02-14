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

$factory->define(App\Models\ProductCompany::class, function (Faker $faker) {

    $category_ids = \App\Models\ProductCategory::where('status', true)->get()->pluck('id')->toArray();

    return [
        'category_id' => $faker->randomElement($category_ids),
        'name' => $faker->sentence,
        'content' => $faker->text,
    ];
});
