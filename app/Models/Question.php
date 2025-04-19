<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'quiz_id',
        'question',
        'model_answer',
        'type',
        'mark',
    ];
    protected $table = 'questions';

   public function choices(){
        return $this->hasMany(Choice::class,'question_id');
    }

    public function quiz(){
        return $this->belongsTo(Quiz::class,'quiz_id');
    }

    public function answers(){
        return $this->hasMany(Answer::class,'question_id');
    }
  


}
