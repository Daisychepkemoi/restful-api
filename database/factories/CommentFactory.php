<?php

$factory->define(App\Comments::class, function (Faker\Generator $faker) {
    $userid=App\User::pluck('id');
    $answerid=App\Answers::pluck('id')->toArray();
    $answers = App\Answers::get();
// $user_id=App\User::where('role','admin')->where('function','user')->pluck('id')->toArray();
    
foreach ($answers as $ans) {
$Questionid=App\Answers::where('id',$ans->id)->pluck('questions_id');
}
    return [
		// 'user_id' => 1,  
		'users_id' => $faker->randomElement($userid), 
		'answers_id' => $faker->randomElement($answerid),   
		'questions_id' => $faker->randomElement($Questionid),
		'body' => $faker->sentence(10),
    ];
});

 