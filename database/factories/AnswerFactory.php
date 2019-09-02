<?php

$factory->define(App\Answers::class, function (Faker\Generator $faker) {
    $userid=App\User::pluck('id');
    $Questionid=App\Questions::pluck('id');
    return [
		'users_id' => $faker->randomElement($userid),  
		'questions_id' => $faker->randomElement($Questionid),  
		'body' => $faker->sentence(10),
    ];
});

 