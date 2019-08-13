<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Admin::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
       	'email' => $faker->email,
        'password' => $faker->password,
       	'number'=> $faker->phonenumber
    ];
});
