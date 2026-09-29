<?php

namespace App\Observers;

use App\Models\Teacher;
use App\Models\User;

class TeacherObserver
{
    public function created(Teacher $teacher): void
    {
        $teacher->user?->assignRole('profesor');
    }

    public function updated(Teacher $teacher): void
    {
        if ($teacher->wasChanged('user_id')) {
            if ($teacher->getOriginal('user_id')) {
                User::find($teacher->getOriginal('user_id'))?->removeRole('profesor');
            }

            $teacher->user?->assignRole('profesor');
        }
    }

    public function deleted(Teacher $teacher): void
    {
        $teacher->user?->removeRole('profesor');
    }
}