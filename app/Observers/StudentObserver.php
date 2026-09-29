<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\User;

class StudentObserver
{
    public function created(Student $student): void
    {
        $student->user?->assignRole('alumno');
    }

    public function updated(Student $student): void
    {
        if ($student->wasChanged('user_id')) {
            if ($student->getOriginal('user_id')) {
                User::find($student->getOriginal('user_id'))?->removeRole('alumno');
            }

            $student->user?->assignRole('alumno');
        }
    }

    public function deleted(Student $student): void
    {
        $student->user?->removeRole('alumno');
    }
}