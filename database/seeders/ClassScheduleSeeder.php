<?php

namespace Database\Seeders;

use App\Models\ClassSchedule;
use App\Models\TeacherSubjectGroup;
use Illuminate\Database\Seeder;

class ClassScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // day_of_week: 1 = Lunes ... 5 = Viernes (ajusta si usas otra convención, ej. 0=Domingo)
        $dias = [1, 2, 3, 4, 5];
        $horasInicio = ['07:00:00', '08:00:00', '09:00:00', '10:00:00', '11:00:00'];

        TeacherSubjectGroup::all()->each(function (TeacherSubjectGroup $asignacion) use ($dias, $horasInicio) {
            $inicio = $horasInicio[array_rand($horasInicio)];
            $fin = date('H:i:s', strtotime($inicio) + 3600); // clase de 1 hora

            ClassSchedule::create([
                'teacher_subject_group_id' => $asignacion->id,
                'day_of_week' => $dias[array_rand($dias)],
                'start_time' => $inicio,
                'end_time' => $fin,
            ]);
        });
    }
}