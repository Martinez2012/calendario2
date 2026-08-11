<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TaskSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');
        $anioActual = now()->year;

        Task::with('teacherSubjectGroup')->get()->each(function (Task $tarea) use ($faker, $anioActual) {
            $groupId = $tarea->teacherSubjectGroup->group_id;

            // Estudiantes inscritos en el grupo de esta tarea, para el año escolar actual
            $estudiantesIds = Enrollment::where('group_id', $groupId)
                ->where('school_year', $anioActual)
                ->pluck('student_id');

            foreach ($estudiantesIds as $studentId) {
                $entrego = $faker->boolean(80);

                if ($entrego) {
                    $enviado = $faker->dateTimeBetween($tarea->assigned_at, $tarea->due_at);
                    $status = $enviado > $tarea->due_at ? 'late' : 'submitted';

                    TaskSubmission::create([
                        'task_id' => $tarea->id,
                        'student_id' => $studentId,
                        'status' => $status,
                        'submitted_at' => $enviado,
                        'file' => 'submissions/' . $faker->uuid() . '.pdf',
                        'teacher_feedback' => null,
                    ]);
                } else {
                    $vencida = now()->greaterThan($tarea->due_at);

                    TaskSubmission::create([
                        'task_id' => $tarea->id,
                        'student_id' => $studentId,
                        'status' => $vencida ? 'late' : 'pending',
                        'submitted_at' => null,
                        'file' => null,
                        'teacher_feedback' => null,
                    ]);
                }
            }
        });
    }
}