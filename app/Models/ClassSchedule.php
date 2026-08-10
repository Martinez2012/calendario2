<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = [
        'teacher_subject_group_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];


    public function teacherSubjectGroup()
    {
        return $this->belongsTo(TeacherSubjectGroup::class);
    }
}