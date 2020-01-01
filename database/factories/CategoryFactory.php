<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Category;
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

$factory->define(Category::class, function (Faker $faker) {
	
	$name = $faker->sentence(1);

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'user_id' => function() {
        	if(User::all()->count()) {
        		return User::all()->random()->id;
        	}
        	return create(User::class)->id;
        }
    ];
});
