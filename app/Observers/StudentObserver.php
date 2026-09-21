<?php

namespace App\Observers;

use App\Models\Student;

class StudentObserver
{
    public function deleted(Student $student): void
    {
        $student->user?->removeRole('Alumno');
    }
}
