<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnswerFeedback extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'answer_id',
        'feedback'
    ];
    protected $table = 'answers_feedbacks';

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }
  


}
