<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'student_id',
        'question_id',
        'answer',
        'mark',
        'is_correct',
        'result_id',
    ];
    protected $table = 'answers';

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
    public function feedback()
    {
        return $this->hasOne(AnswerFeedback::class, 'answer_id');
    }

}
