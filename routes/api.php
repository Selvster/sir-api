<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassRequestsController;
use App\Http\Controllers\ClassStudentsController;
use App\Http\Controllers\QuizController;

//Auth Routes

Route::post('auth/login', [UserController::class, 'login']);
Route::post('auth/register', [UserController::class, 'register']);

//Resources

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('classes',ClassController::class);
    Route::delete('classes/{id}/students/{student_id}/remove', [ClassController::class, 'removeStudent']);
    Route::resource('classes_requests',ClassRequestsController::class);
    Route::post('classes_requests/{id}/accept', [ClassRequestsController::class, 'accept']);
    Route::post('classes_requests/{id}/reject', [ClassRequestsController::class, 'reject']);
    Route::resource('classes_students',ClassStudentsController::class);
    Route::resource('quizzes',QuizController::class);
    Route::get('quizzes/{id}/attempt', [QuizController::class, 'attempt']);
    Route::post('quizzes/submit', [QuizController::class, 'submit']);
});