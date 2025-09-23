<?php

use App\Http\Controllers\GoalController;
use App\Http\Controllers\GoalHistoryController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InClassController;
use App\Http\Controllers\SelfStudyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Models\SelfStudy;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\AcademyController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WeekGoalController;
use App\Http\Controllers\ListGoalController;
use App\Http\Controllers\SemesterController;

Route::apiResource('listgoal', ListGoalController::class);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/v1/login', [AuthController::class, 'login']);
Route::post('/v1/logout', [AuthController::class, 'logout']);
Route::post('v1/register', [AuthController::class, 'register']);


Route::get('/v1/teachers', [TeacherController::class, 'index']);

Route::middleware('auth.jwt')->get('/profile', [ProductController::class, 'get']);
// Class management
Route::get('/v1/classes', [ClassController::class, 'index']);
Route::post('/v1/classes', [ClassController::class, 'create']);
Route::delete('/v1/classes/{id}', [ClassController::class, 'delete']);
Route::patch('/v1/classes/{id}', [ClassController::class, 'updateClass']);
// Student management
Route::get('/v1/students', [UserController::class, 'getStudents']);
Route::post('/v1/avatar', [UserController::class, 'updateAvatar']);
// Teacher management
Route::get('/v1/teachers', [UserController::class, 'getTeachers']);

Route::patch('/v1/classes/{id}', [ClassController::class, 'updateClass']);
Route::get('/academies', [AcademyController::class, 'index']);
Route::post('/academies', [AcademyController::class,'store']);
Route::get('/academies/{id}', [AcademyController::class, 'show']);
Route::put('/academies/{id}', [AcademyController::class, 'update']); 
Route::delete('/academies/{id}', [AcademyController::class, 'destroy']);


Route::get('/goal', [GoalController::class, 'index']);
Route::post('/goal', [GoalController::class, 'store']);
Route::get('/goal/{id}', [GoalController::class, 'show']);
Route::put('/goal/{id}', [GoalController::class, 'update']);
Route::delete('/goal/{id}', [GoalController::class, 'destroy']);
Route::put('/goal/{id}/completeStatus', [GoalController::class, 'updateCompleteStatus']);


Route::get('/inclass',[InClassController::class,'index']);
Route::put('/inclass/{id}',[InClassController::class,'update']);
Route::get('/inclass/{id}',[InClassController::class,'show']);
Route::post('/inclass/create/',[InClassController::class,'store']);

Route::get('/selfstudy',[SelfStudyController::class,'index']);
Route::get('/selfstudy/{id}', [SelfStudyController::class, 'show']); 
Route::put('/selfstudy/{id}', [SelfStudyController::class, 'update']); 
Route::post('/selfstudy', [SelfStudyController::class, 'store']);

// 
// Route::get('/task', [TaskController::class, 'index']);

//Week's Goal
Route::get('/week-goals', [WeekGoalController::class, 'getAllWeekGoals']);
Route::get('/week-goals/{id}', [WeekGoalController::class, 'getWeekGoal']);
Route::post('/week-goals', [WeekGoalController::class, 'storeWeekGoal']);
Route::put('/week-goals/{id}', [WeekGoalController::class, 'updateWeekGoal']);
Route::put('/week-goals/{id}/status', [WeekGoalController::class, 'updateWeekGoalStatus']);
Route::delete('/week-goals/{id}', [WeekGoalController::class, 'deleteWeekGoal']);
Route::get('/week-goals/status/{status}', [WeekGoalController::class, 'getWeekGoalsByStatus']);


// SemesterController

Route::get('/semesters', [SemesterController::class, 'index']);
Route::post('/semesters/store', [SemesterController::class, 'store']);
Route::get('/semesters/{id}', [SemesterController::class, 'show']);
Route::put('/semesters/{id}', [SemesterController::class, 'update']);
Route::delete('/semesters/{id}', [SemesterController::class, 'destroy']);

//GoalHistoryController
Route::get('/goal-history/{goalId}', [GoalHistoryController::class, 'getHistoryByGoal']);
Route::post('/goal-history', [GoalHistoryController::class, 'store']);
Route::get('/goal-history-with-goal/{goalId}', [GoalHistoryController::class, 'getGoalWithHistory']);

//StudentController
Route::put('/students/{id}', [StudentController::class, 'update']);

Route::get('users/{userId}/goals', [GoalController::class, 'getGoalsByUser']);

