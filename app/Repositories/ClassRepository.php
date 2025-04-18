<?php

namespace App\Repositories;

use App\Models\ClassModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassRepository extends AppRepository
{
    public function __construct(ClassModel $model)
    {
        parent::__construct($model);
    }

    public function all(Request $request)
    {
        $with = $request->with ? $request->with : [];

        $query =
            Auth()->user()->isStudent() ?
            $this->model->with($with)
                ->whereHas('students', function ($query) {
                    $query->where('student_id', auth()->user()->student->id);
                })
            :
            $this->model->with($with)
                ->where('teacher_id', auth()->user()->teacher->id);



        return $this->dataTable($query, $request);
    }
    public function store(Request $request)
    {
        $class = new ClassModel();
        $class->name = $request->name;
        $class->description = $request->description;
        $class->teacher_id = Auth::user()->teacher->id;
        $class->code = strtoupper(uniqid('SIR_CLASS_'));
        $class->save();

        return response()->json([
            'message' => 'Class created successfully',
            'code' => $class->code,
        ], 201);
    }

    public function removeStudent($id, $student_id)
    {
        $class = $this->model->find($id);
        if (!$class) {
            return response()->json([
                'message' => 'Class not found',
            ], 404);
        }

        $class->students()->detach($student_id);

        return response()->json([
            'message' => 'Student removed from class successfully',
        ], 200);
    }


}
