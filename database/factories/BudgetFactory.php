<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Budget;
use App\Models\Category;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Budget::class, function (Faker $faker) {
    return [
        'category_id' => function() {
        	if(Category::all()->count()) {
        		return Category::all()->random()->id;
        	}
        	return create(Category::class)->id;
        },
        'user_id' => function() {
        	if(User::all()->count()) {
        		return User::all()->random()->id;
        	}
        	return create(User::class)->id;
        },
        'amount' => $faker->randomFloat(2, 500, 1000),
        'month' => function() {
        	return Carbon::now()->month;
        }
    ];
});
