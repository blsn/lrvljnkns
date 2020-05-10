<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title'         => $faker->text(20),
        'body'          => $faker->text(300),
        'user_id'       => 2,
        'cover_image'   => 'noimage.jpg'
    ];
});
