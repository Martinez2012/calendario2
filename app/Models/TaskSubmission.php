<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $fillable = [
        'task_id',
        'student_id',
        'status',
        'submitted_at',
        'file',
        'teacher_feedback',
    ];


    public function task()
    {
        return $this->belongsTo(Task::class);
    }


    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function grade()
    {
        return $this->hasOne(StudentGrade::class);
    }
}