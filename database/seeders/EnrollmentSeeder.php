<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $groups = Group::all();
        $anioActual = now()->year;

        Student::all()->each(function (Student $student) use ($groups, $anioActual) {
            Enrollment::create([
                'student_id' => $student->id,
                'group_id' => $groups->random()->id,
                'school_year' => $anioActual,
            ]);
        });
    }
}