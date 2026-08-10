<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    protected $fillable = [
        'student_id',
        'task_submission_id',
        'score',
        'observations',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function taskSubmission()
    {
        return $this->belongsTo(TaskSubmission::class);
    }
}