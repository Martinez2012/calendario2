<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubjectGroup extends Model
{
    protected $fillable = [
        'teacher_id',
        'subject_id',
        'group_id',
    ];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }


    public function group()
    {
        return $this->belongsTo(Group::class);
    }


    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    public function events()
    {
        return $this->hasMany(Event::class);
    }
}