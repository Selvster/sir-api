<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class UserRepository extends AppRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !password_verify($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('user')->plainTextToken;

        return response()->json([
            'token' => $token,
            'type' => $user->type,
        ]);
    }

    public function register(Request $request)
    {
        //Validate unique email only
        if (User::where('email', $request->input('email'))->first()) {
            return response()->json([
                'message' => 'Email already exists'
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
            'type' => $request->type,
            'dob' => $request->dob,
            'gender' => $request->gender
        ]);

        if ($user) {
            if ($request->type == 'Student') {
                $student = new Student();
                $student->user_id = $user->id;
                $student->save();
            } else if ($request->type == 'Teacher') {
                $teacher = new Teacher();
                $teacher->user_id = $user->id;
                $teacher->save();
            }
        }

        $token = $user->createToken('user')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function user()
    {
        if (auth()->user()->isStudent()) {

            $student = Auth::user()->student;

            $resultsCount = $student->results()->count();

            $classesCount = $student->classes()->count();

            return json_encode([
                'user' => $student->user,
                'info' => [
                    'quizzes_count' => $resultsCount,
                    'classes_count' => $classesCount,
                ]
            ]);


        } else if (auth()->user()->isTeacher()) {
            $teacher = Auth::user()->teacher;

            $quizzesCount = $teacher->classes()->withCount('quizzes')->get()->sum('quizzes_count');
        
            $classesCount = $teacher->classes()->count();

            return json_encode([
                'user' => $teacher->user,
                'info' => [
                    'quizzes_count' => $quizzesCount,
                    'classes_count' => $classesCount,
                ]
            ]);
        }
    }
}
