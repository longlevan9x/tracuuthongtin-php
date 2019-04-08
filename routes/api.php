<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

use App\Http\Controllers\Api\V1\CrawlController;
use App\Http\Controllers\Api\V1\ScheduleController;
use App\Http\Controllers\Api\V1\ScheduleExamController;
use App\Http\Controllers\Api\V1\SemesterController;
use App\Http\Controllers\Api\V1\StudentController;

Route::prefix('v1')->namespace('Api\V1')->group(function() {
	Route::get('student', StudentController::getControllerWithAction('getStudent'));
	Route::get('schedules', StudentController::getControllerWithAction('getSchedules'));
	Route::get('schedule-exams', StudentController::getControllerWithAction('getScheduleExams'));
	Route::resource(SemesterController::getResourceName(), SemesterController::getClassName());

	Route::get('schedule', ScheduleController::getControllerWithAction('getSchedule'));
	Route::get('schedule-exam', ScheduleController::getControllerWithAction('getScheduleExam'));
});
