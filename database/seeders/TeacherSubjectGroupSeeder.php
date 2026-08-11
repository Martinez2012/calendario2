<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSubjectGroup;
use Illuminate\Database\Seeder;

class TeacherSubjectGroupSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();

        // Por cada grupo, asigna 4 materias con un profesor aleatorio para cada una
        Group::all()->each(function (Group $group) use ($teachers, $subjects) {
            $materiasDelGrupo = $subjects->random(4);

            foreach ($materiasDelGrupo as $materia) {
                TeacherSubjectGroup::firstOrCreate([
                    'teacher_id' => $teachers->random()->id,
                    'subject_id' => $materia->id,
                    'group_id' => $group->id,
                ]);
            }
        });
    }
}