<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'user_type' => 'admin',
        ]);
        \App\Models\User::create([
            'name' => 'Agent',
            'email' => 'agent@gmail.com',
            'username' => 'agent',
            'password' => bcrypt('agent'),
            'user_type' => 'agent',
        ]);

    }
}
