<?php

use App\Models\Product;
use App\Models\ProductCategory;
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

$factory->define(Product::class, function (Faker $faker) {

    $name = $faker->sentence;
    $category_ids = ProductCategory::where('status', true)->get()->pluck('id')->toArray();

    return [
        'name' => $name,
        'full_name' => $name,
        'category_id' => $faker->randomElement($category_ids),
        'description' => $faker->sentence,
        'raise' => $faker->randomElement(array_keys(Product::$raiseMap)),
        'profit' => $faker->randomElement(array_keys(Product::$profitMap)),
        'profit_min_value' => $faker->randomFloat(2, 9, 13),
        'profit_description' => $faker->sentence,
        'term' => $faker->randomElement(array_keys(Product::$termMap)),
        'term_min_value' => $faker->numberBetween(0, 24),
        'invest_direction' => $faker->randomElement(array_keys(Product::$investDirectionMap)),
        'interest_type' => $faker->randomElement(array_keys(Product::$interestTypeMap)),
        'min_invest' => $faker->randomElement([100, 200, 300]),
        'collect_size' => $faker->randomElement([1, 2, 1.5, 2.5, 3]),
    ];
});
