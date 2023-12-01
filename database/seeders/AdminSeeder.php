<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => '$2y$10$dgOOspCZP/w5LAvgiw5LUu1hFmODLUL/9B1otNB0wQ8Bcm7kiyvCK',
            'confirm_password' => '$2y$10$dgOOspCZP/w5LAvgiw5LUu1hFmODLUL/9B1otNB0wQ8Bcm7kiyvCK'
        ])->assignRole('writer', 'admin');
    }
}
