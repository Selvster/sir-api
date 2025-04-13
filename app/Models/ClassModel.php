<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Student;
use App\Models\Teacher;

class ClassModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'classes';
    protected $fillable = ['name','description','code','teacher_id'];

    public function teacher(){
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    public function students(){
        return $this->belongsToMany(Student::class,'classes_students','class_id','student_id');
    }

    public function quizzes(){
        return $this->hasMany(Quiz::class,'class_id');
    }

  
}
