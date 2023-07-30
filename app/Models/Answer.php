<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'is_correct',
        'question_id',
        'is_delete',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
