<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'duration',
        'class_id',
    ];
    protected $table = 'quizzes';

    public function class(){
        return $this->belongsTo(ClassModel::class,'class_id');
    }

    public function questions(){
        return $this->hasMany(Question::class,'quiz_id');
    }
  


}
