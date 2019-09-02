<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions=factory(App\Questions::class, 10)->create();
    
    }
}

