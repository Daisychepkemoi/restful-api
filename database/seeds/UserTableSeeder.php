<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 // $admin = factory(\App\User::class)->create([
      //       'email' => 'daisy@example.com',
      //       'name' => 'daisy',
      //       'password' => Hash::make('123456'),
      //   ]);
        $users=factory(App\User::class, 2)->create();
    
    }
}

