<?php

namespace App\Models;

use App\Observers\TeacherObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(TeacherObserver::class)]
class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'specialty',
        'professional_title',
        'hire_date',
    ];

    protected $casts = [
        'hire_date' => 'date',
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