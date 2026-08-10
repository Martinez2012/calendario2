<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'teacher_subject_group_id',
        'title',
        'description',
        'assigned_at',
        'due_at',
    ];


    public function teacherSubjectGroup()
    {
        return $this->belongsTo(TeacherSubjectGroup::class);
    }


    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }
}