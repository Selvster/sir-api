<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherClass extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name','code','teacher_id'];

    public function teacher(){
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function requests(){
        return $this->hasMany(TeacherClassRequests::class,'class_id');
    }

    public function students(){
        return $this->belongsToMany(User::class,'teacher_class_students','class_id','student_id');
    }
}
