<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'group_id',
        'school_year',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}