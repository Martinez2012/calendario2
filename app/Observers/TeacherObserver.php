<?php

namespace App\Observers;

use App\Models\Teacher;

class TeacherObserver
{
    public function deleted(Teacher $teacher): void
    {
        $teacher->user?->removeRole('Profesor');
    }
}