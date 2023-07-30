<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $fillable = [
        'name',
        'surname',
        'dob',
        'course_id',
        'repeated_grade',
        'repeated_courses',
        'nationality',
        'origin',
        'arrival_date',
        'email',
        'password',
        'level',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quizzes()
{
    return $this->hasMany(Quiz::class);
}
}
