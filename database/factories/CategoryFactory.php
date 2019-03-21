<?php

use Faker\Generator as Faker;

/**
 * Advert factory.
 * Used in seeding the clients table.
 */

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->realText(20),
    ];
});
