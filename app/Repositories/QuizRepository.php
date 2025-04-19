<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;

class QuizRepository extends AppRepository
{
    public function __construct(Quiz $model)
    {
        parent::__construct($model);
    }

    public function all(Request $request)
    {
        $with = $request->with ? $request->with : [];

        $query =
            Auth()->user()->isStudent() ?
            $query = $this->model->with($with)
                ->whereHas('class.students', function ($q) {
                    $q->where('student_id', auth()->user()->student->id);
                })
            :
            $this->model->with($with)
                ->whereHas('class', function ($query) {
                    $query->where('teacher_id', auth()->user()->teacher->id);
                });




        return $this->dataTable($query, $request);
    }
    public function store(Request $request)
    {
        $name = $request->name;
        $description = $request->description;
        $class_id = $request->class_id;
        $duration = $request->duration;
        $is_active = $request->is_active;
        $is_active = $is_active ? 1 : 0;
        $essay_questions = $request->essay_questions;
        $mcq_questions = $request->mcq_questions;

        //Create Quiz
        $quiz = new Quiz();
        $quiz->name = $name;
        $quiz->description = $description;
        $quiz->class_id = $class_id;
        $quiz->duration = $duration;
        $quiz->is_active = $is_active;
        $quiz->show_results = $request->show_results;
        $quiz->save();

        //Create Essay Questions
        if ($essay_questions) {
            foreach ($essay_questions as $question) {
                $quiz->questions()->create([
                    'question' => $question['question'],
                    'model_answer' => $question['model_answer'],
                    'type' => 'essay',
                    'mark' => $question['mark'],
                ]);
            }
        }
        //Create MCQ Questions
        if ($mcq_questions) {
            foreach ($mcq_questions as $question) {
                $createdQuestion = $quiz->questions()->create([
                    'question' => $question['question'],
                    'model_answer' => $question['model_answer'],
                    'type' => 'mcq',
                    'mark' => $question['mark'],
                ]);
                //Create Choices
                foreach ($question['choices'] as $choice) {
                    $createdQuestion->choices()->create([
                        'choice' => $choice,
                    ]);
                }

            }
        }

        return response()->json([
            'message' => 'Quiz created successfully',
        ], 201);
    }

    public function attempt($id)
    {

        $quiz = $this->model->with(['questions.choices'])->find($id);

        if (!$quiz) {
            return response()->json([
                'message' => 'Quiz not found',
            ], 404);
        }

        if ($quiz->is_active == 0) {
            return response()->json([
                'message' => 'Quiz is not active',
            ], 422);
        }

        $studentId = auth()->user()->student->id;

        // Check student belongs to the class
        if (!$quiz->class->students->contains('id', $studentId)) {
            return response()->json([
                'message' => 'You are not in this class',
            ], 422);
        }

        $duration = $quiz->duration * 60;
        $attempt = $quiz->attempts()->where('student_id', $studentId)->first();

        if ($attempt) {
            $timeElapsed = $attempt->created_at->diffInSeconds(now());

            if ($timeElapsed >= $duration) {
                return response()->json([
                    'message' => 'Quiz time is over',
                ], 422);
            } else {
                $duration -= $timeElapsed;
            }
        } else {
            $quiz->attempts()->create([
                'student_id' => $studentId,
            ]);
        }

        return response()->json([
            'quiz' => $quiz->load(['questions.choices']),
            'duration' => $duration,
        ], 200);

    }



}
