<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Category;
use App\Models\Transaction;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'description' => $faker->sentence(10),
        'amount' => $faker->numberBetween(5,10),
        'category_id' => function() {
        	return create(Category::class)->id;
        },
        'user_id' => function() {
        	return create('App\User')->id;
        }
    ];
});
