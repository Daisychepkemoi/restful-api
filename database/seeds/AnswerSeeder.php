<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $answers=factory(App\Answers::class, 15)->create();
    }
}
