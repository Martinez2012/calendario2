<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


#[Fillable([
    'name',
    'email',
    'password'
])]

#[Hidden([
    'password',
    'remember_token'
])]

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
     //use HasFactory, Notifiable, HasRoles;
     use HasFactory, Notifiable;
    

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * Perfil docente
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }


    /**
     * Perfil estudiante
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }
}