<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'grade_id',
        'name',
    ];


    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }


    public function teacherSubjectGroups()
    {
        return $this->hasMany(TeacherSubjectGroup::class);
    }


    public function events()
    {
        return $this->hasMany(Event::class);
    }
}