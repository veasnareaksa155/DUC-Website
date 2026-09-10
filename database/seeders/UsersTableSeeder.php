<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@duc.edu.kh',
                'email_verified_at' => NULL,
                'password' => '$2y$12$GJcs/cdSWowOlj1Fstt9suTivse/KBY1LuZRykxQaHBKYgzB85EzK',
                'remember_token' => '2M12rCN6cj4q1rIfodUGFtA2wU1uXeARKFMZVD4vKxnRQ2yJwtHOWmR0y72C',
                'created_at' => '2026-07-21 03:52:13',
                'updated_at' => '2026-07-21 03:52:13',
            ),
        ));
        
        
    }
}