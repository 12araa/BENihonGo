<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sensei',
            'email' => 'admin@benihongo.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'equipped_avatar_id' => null,
        ]);

        User::create([
            'name' => 'Tanaka Kun',
            'email' => 'player@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'equipped_avatar_id' => 1,
        ]);
    }
}
