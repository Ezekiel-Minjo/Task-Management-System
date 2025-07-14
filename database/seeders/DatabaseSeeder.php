<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@cytonn.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'user@cytonn.com',
            'password' => bcrypt('password'),
        ]);
    }
}
