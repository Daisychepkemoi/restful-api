<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments=factory(App\Comments::class, 100)->create();
    
    }
}

