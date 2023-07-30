<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'course',
        'topic',
        'type',
        'enunciation',
        'is_delete',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'question_quiz')
                    ->withPivot('student_answer')
                    ->withTimestamps();
    }
}
