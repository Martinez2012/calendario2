<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@escuela.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // 15 usuarios que luego se convertirán en Profesores
        User::factory()->count(15)->create();

        // 60 usuarios que luego se convertirán en Estudiantes
        User::factory()->count(60)->create();

        // Si usas Spatie\Permission\Traits\HasRoles, asigna roles aquí, ej:
        // User::find(1)->assignRole('admin');
    }
}