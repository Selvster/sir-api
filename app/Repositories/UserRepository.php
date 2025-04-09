<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Student;
use App\Models\Teacher;

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
}
