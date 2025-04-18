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
            []
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



}
