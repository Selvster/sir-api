<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherClassRequests extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['student_id','class_id'];

    public function student(){
        return $this->belongsTo(User::class,'student_id');
    }

    public function class(){
        return $this->belongsTo(TeacherClass::class,'class_id');
    }
}
