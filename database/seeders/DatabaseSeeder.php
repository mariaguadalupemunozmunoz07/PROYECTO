<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Administrador 1',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin2@gmail.com'],
            [
                'name' => 'Administrador 2',
                'password' => Hash::make('admin023'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin3@gmail.com'],
            [
                'name' => 'Administrador 3',
                'password' => Hash::make('admin032'),
                'role' => 'admin',
            ]
        );
    }
}