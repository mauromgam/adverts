<?php

use Faker\Generator as Faker;

/**
 * Advert factory.
 * Used in seeding the clients table.
 */

$factory->define(App\Advert::class, function (Faker $faker) {
    return [
        'title'        => 'Advert ' . $faker->randomNumber(7),
        'description'  => $faker->realText(500),
        'price'        => $faker->numberBetween(1000, 10000),
        'category_id'  => \App\Category::inRandomOrder()->first()->id,
        'user_id'      => \App\User::inRandomOrder()->first()->id,
    ];
});
