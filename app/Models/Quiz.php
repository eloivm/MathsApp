<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'level'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_quiz')
                    ->withPivot('student_answer')
                    ->withTimestamps();
    }
}
