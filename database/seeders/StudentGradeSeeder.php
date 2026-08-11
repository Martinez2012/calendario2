<?php

namespace Database\Seeders;

use App\Models\StudentGrade;
use App\Models\TaskSubmission;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentGradeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        // Solo se califican las entregas que realmente se enviaron
        TaskSubmission::whereIn('status', ['submitted', 'late'])->get()->each(function (TaskSubmission $entrega) use ($faker) {
            StudentGrade::create([
                'student_id' => $entrega->student_id,
                'task_submission_id' => $entrega->id,
                'score' => $faker->randomFloat(2, 60, 100), // decimal(5,2)
                'observations' => $faker->boolean(30) ? $faker->sentence(6) : null,
            ]);

            $entrega->update(['status' => 'graded']);
        });
    }
}