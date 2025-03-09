<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeacherClassController;
use App\Http\Controllers\TeacherClassRequestsController;
use App\Http\Controllers\TeacherClassStudentsController;

//Auth Routes

Route::post('auth/login', [UserController::class, 'login']);
Route::post('auth/register', [UserController::class, 'register']);

//Resources

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('teacher_classes',TeacherClassController::class);
    Route::resource('teacher_classes_requests',TeacherClassRequestsController::class);
    Route::resource('teacher_classes_students',TeacherClassStudentsController::class);

});