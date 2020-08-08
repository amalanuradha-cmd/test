<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Tasks;
use Faker\Generator as Faker;

$factory->define(Tasks::class, function (Faker $faker) {

    return [
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
