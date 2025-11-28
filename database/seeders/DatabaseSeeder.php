<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Create an admin user
        User::updateOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create a sample intern
        User::updateOrCreate([
            'email' => 'intern@example.com'
        ], [
            'name' => 'Wulan Rachmawati',
            'password' => Hash::make('password'),
            'role' => 'intern',
        ]);
    }
}
