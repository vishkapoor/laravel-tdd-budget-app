<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Category;
use App\Models\Transaction;
use App\User;
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
            if(Category::all()->count()) {
                return Category::all()->random()->id;
            }
            return create(Category::class)->id;
        },
        'user_id' => function () {
            if(User::all()->count()) {
                return User::all()->random()->id;
            }
            return create(User::class)->id;
        }
    ];
});
