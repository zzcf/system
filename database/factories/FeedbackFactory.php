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

$factory->define(App\Models\Feedback::class, function (Faker $faker) {

    $product_ids = \App\Models\Product::where('status', true)->get()->pluck('id')->toArray();

    return [
        'product_id' => $faker->randomElement($product_ids),
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'source_url' => $faker->url,
        'source_ip' => $faker->ipv4,
    ];
});
