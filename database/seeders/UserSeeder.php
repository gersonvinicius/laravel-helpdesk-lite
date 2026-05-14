<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'atendente@example.com'],
            [
                'name' => 'Atendente Demo',
                'email' => 'atendente@example.com',
                'password' => Hash::make('password'),
                'role' => UserRole::Atendente,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'solicitante@example.com'],
            [
                'name' => 'Solicitante Demo',
                'email' => 'solicitante@example.com',
                'password' => Hash::make('password'),
                'role' => UserRole::Solicitante,
                'email_verified_at' => now(),
            ]
        );
    }
}
