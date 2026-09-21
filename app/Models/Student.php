<?php

namespace App\Models;

use App\Observers\StudentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(StudentObserver::class)]
class Student extends Model
{
    protected $fillable = [
        'user_id',
        'student_code',
        'birth_date',
        'guardian_name',
        'guardian_phone',
    ];

    protected static function booted(): void
    {
        static::creating(function (Student $student) {
            if (blank($student->student_code)) {
                $student->student_code = self::generateNextCode();
            }
        });
    }

    protected static function generateNextCode(): string
    {
        $lastNumber = static::query()
            ->selectRaw("MAX(CAST(SUBSTRING(student_code, 5) AS UNSIGNED)) as max_number")
            ->value('max_number');

        $nextNumber = ($lastNumber ?? 0) + 1;

        return 'EST-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function taskSubmissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class);
    }
}