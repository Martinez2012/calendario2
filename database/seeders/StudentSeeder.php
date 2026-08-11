<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        // Los 60 usuarios creados después del admin y los 15 profesores
        // (id 17 al 76)
        $users = User::orderBy('id')
            ->skip(16)
            ->take(60)
            ->get();

        $contador = 1;

        foreach ($users as $user) {

            Student::create([
                'user_id' => $user->id,

                'student_code' => 'EST-' . str_pad(
                    $contador,
                    4,
                    '0',
                    STR_PAD_LEFT
                ),

                'document' => $faker->unique()->numerify('##########'),

                'birth_date' => $faker->dateTimeBetween(
                    '-17 years',
                    '-6 years'
                )->format('Y-m-d'),

                'guardian_name' => $faker->name(),

                'guardian_phone' => $faker->phoneNumber(),
            ]);

            $contador++;
        }
    }
}