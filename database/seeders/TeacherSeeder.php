<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        // Los 15 usuarios creados después del admin
        $users = User::orderBy('id')
            ->skip(1)
            ->take(15)
            ->get();

        $especialidades = [
            'Matemáticas',
            'Ciencias',
            'Lenguaje',
            'Humanidades',
            'Educación Física',
        ];

        foreach ($users as $user) {

            $especialidad = $faker->randomElement($especialidades);

            Teacher::create([
                'user_id' => $user->id,
                'document' => $faker->unique()->numerify('##########'),
                'specialty' => $especialidad,
                'professional_title' => 'Licenciado en ' . $especialidad,
                'hire_date' => $faker
                    ->dateTimeBetween('-5 years', 'now')
                    ->format('Y-m-d'),
            ]);
        }
    }
}