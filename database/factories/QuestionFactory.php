<?php

$factory->define(App\Questions::class, function (Faker\Generator $faker) {
    $userid=App\User::pluck('id');
    return [
		// 'user_id' => 1,  
		'users_id' => $faker->randomElement($userid),  
		'body' => $faker->sentence(10),
    ];
});
