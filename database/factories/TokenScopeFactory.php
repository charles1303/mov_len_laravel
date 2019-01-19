<?php

use Faker\Generator as Faker;

$factory->define(App\Auth\Models\TokenScope::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElements(['ratings', 'ages', 'movies'],1)[0]
    ];
});
