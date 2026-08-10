<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'start',
        'end',
        'group_id',
        'teacher_subject_group_id',
    ];


    public function group()
    {
        return $this->belongsTo(Group::class);
    }


    public function teacherSubjectGroup()
    {
        return $this->belongsTo(TeacherSubjectGroup::class);
    }
}