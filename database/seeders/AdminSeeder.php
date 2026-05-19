<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
            User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@kinetic.com',
            'password' => bcrypt('admin123'),
            'role'     => 'admin',
        ]);
    }
}