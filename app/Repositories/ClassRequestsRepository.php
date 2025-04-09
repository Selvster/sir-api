<?php

namespace App\Repositories;

use App\Models\ClassModel;
use App\Models\ClassRequests;
use Illuminate\Http\Request;
use App\Models\ClassStudents;


class ClassRequestsRepository extends AppRepository
{
    public function __construct(ClassRequests $model)
    {
        parent::__construct($model);
    }

    public function all(Request $request)
    {
        $with = $request->with ? $request->with : [];
        $query = $this->model->with($with)
            ->whereHas('class', function ($query) {
                $query->where('teacher_id', auth()->user()->teacher->id);
            });
        return $this->dataTable($query, $request);
    }

    public function store(Request $request)
    {
        $code = $request->code;

        $instance = new ClassModel();

        $class = $instance->where('code', $code)->first();

        if (!$class) {
            return response()->json([
                'message' => 'Class not found',
            ], 404);
        }

        //if the class is already requested by the student
        $classRequest = ClassRequests::where('class_id', $class->id)->where('student_id', auth()->user()->student->id)->first();
        if ($classRequest) {
            return response()->json([
                'message' => 'Class request already sent',
            ], 422);
        }

        //if the class is already joined by the student
        $classStudent = ClassStudents::where('class_id', $class->id)->where('student_id', auth()->user()->student->id)->first();
        if ($classStudent) {
            return response()->json([
                'message' => 'Class already joined',
            ], 422);
        }

        $classRequest = new ClassRequests();
        $classRequest->class_id = $class->id;
        $classRequest->student_id = auth()->user()->student->id;

        $classRequest->save();
        return response()->json([
            'message' => 'Class request sent successfully',
        ], 201);
    }

    public function accept($id)
    {
        $classRequest = ClassRequests::find($id);
        if (!$classRequest) {
            return response()->json([
                'message' => 'Class request not found',
            ], 404);
        }

        $classStudent = new ClassStudents();
        $classStudent->class_id = $classRequest->class_id;
        $classStudent->student_id = $classRequest->student_id;
        $classStudent->save();

        $classRequest->delete();

        return response()->json([
            'message' => 'Class request accepted successfully',
        ], 200);
    }
    public function reject($id)
    {
        $classRequest = ClassRequests::find($id);
        if (!$classRequest) {
            return response()->json([
                'message' => 'Class request not found',
            ], 404);
        }

        $classRequest->delete();

        return response()->json([
            'message' => 'Class request rejected successfully',
        ], 200);
    }

}
