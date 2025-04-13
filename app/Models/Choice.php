<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Choice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'question_id',
        'choice'
    ];
    protected $table = 'choices';

    public function question(){
        return $this->belongsTo(Question::class,'question_id');
    }
  


}
