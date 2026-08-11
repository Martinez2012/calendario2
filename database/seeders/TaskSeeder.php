<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TeacherSubjectGroup;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        TeacherSubjectGroup::all()->each(function (TeacherSubjectGroup $asignacion) use ($faker) {
            // 2 tareas por cada asignación (profesor+materia+grupo)
            for ($i = 0; $i < 2; $i++) {
                $asignada = $faker->dateTimeBetween('-1 month', 'now');
                $vence = (clone $asignada)->modify('+' . rand(3, 14) . ' days');

                Task::create([
                    'teacher_subject_group_id' => $asignacion->id,
                    'title' => ucfirst($faker->words(3, true)),
                    'description' => $faker->paragraph(2),
                    'assigned_at' => $asignada,
                    'due_at' => $vence,
                ]);
            }
        });
    }
}