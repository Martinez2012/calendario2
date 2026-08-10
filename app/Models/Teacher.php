<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'document',
        'specialty',
        'professional_title',
        'hire_date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function teacherSubjectGroups()
    {
        return $this->hasMany(TeacherSubjectGroup::class);
    }
}