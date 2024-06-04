<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Authorizeds\LeaveAloneAuthorizedController;
use App\Http\Controllers\Authorizeds\SearchAuthorizedController;
use App\Http\Controllers\Authorizeds\UpdateAuthorizedController;
use App\Http\Controllers\Courses\SearchCourseController;
use App\Http\Controllers\Retired\SearchRetiredController;
use App\Http\Controllers\Retired\UpdateRetiredController;
use App\Http\Controllers\Storage\ImageSaveController;
use App\Http\Controllers\Storage\ImageSearchController;
use App\Http\Controllers\Students\SearchCourseStudentController;
use App\Http\Controllers\Students\SearchStudentController;
use App\Http\Controllers\Teachers\SearchTeacherController;
use App\Http\Controllers\Tutors\SearchTutorController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Middleware\TeacherEnsureTokenIsValid;
use App\Http\Middleware\TutorEnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

Route::middleware([TutorEnsureTokenIsValid::class])->group(function () {
    Route::post('/authorizeds', UpdateAuthorizedController::class);
});
Route::post('/authorizeds/leave-alone', LeaveAloneAuthorizedController::class);
Route::middleware([TeacherEnsureTokenIsValid::class])->group(function () {
    Route::patch('/ausent/{student_id}', [UpdateRetiredController::class, "markAsAbsent"]);
    Route::patch('/retireds/{student_id}', [UpdateRetiredController::class, "markAsRetired"]);
    Route::get('/retireds', SearchRetiredController::class);
    Route::get('/authorizeds', SearchAuthorizedController::class);
    Route::get('/courses', SearchCourseController::class);
    Route::get('/students', SearchStudentController::class);
    Route::get('/students/course/{id}', SearchCourseStudentController::class);
    Route::get('/teachers', SearchTeacherController::class);
    Route::get('/tutors', SearchTutorController::class);
});

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::post('/upload-image', ImageSaveController::class);
    Route::get('/image/{name}', ImageSearchController::class);

    Route::post('/auth/refresh', [AuthController::class, "refresh"]);
    Route::get('/auth/user', [AuthController::class, "userSession"]);
    Route::post('/auth/logout', [AuthController::class, "logout"]);
});


Route::post('/auth/login', [AuthController::class, "login"]);

Route::get('/', function () {
    return "what's up my friend";
});
