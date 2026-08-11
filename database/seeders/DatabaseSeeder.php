<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Fase 1: Configuración base
            UserSeeder::class,
            GradeSeeder::class,
            SubjectSeeder::class,

            // Fase 2: Estructura académica
            TeacherSeeder::class,
            GroupSeeder::class,
            StudentSeeder::class,

            // Fase 3: Asignación y matrícula
            TeacherSubjectGroupSeeder::class,
            ClassScheduleSeeder::class,
            EnrollmentSeeder::class,

            // Módulo independiente (depende opcionalmente de Groups/TeacherSubjectGroups)
            EventSeeder::class,

            // Fase 4: Operación diaria
            TaskSeeder::class,
            TaskSubmissionSeeder::class,

            // Fase 5: Evaluación
            StudentGradeSeeder::class,
        ]);
    }
}