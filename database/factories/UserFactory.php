<?php

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    $avatars = [
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png',
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png',
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png',
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png',
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png',
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png',
    ];

    return [
        'name' => $faker->name,
        'nickname' => $faker->userName,
        'avatar' => $faker->randomElement($avatars),
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
