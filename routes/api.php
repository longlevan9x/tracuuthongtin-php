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
	Route::get('student/view', StudentController::getControllerWithAction('show'));
	Route::get('schedules', StudentController::getControllerWithAction('getSchedules'));
	Route::get('schedule-exams', StudentController::getControllerWithAction('getScheduleExams'));
	Route::resource(SemesterController::getResourceName(), SemesterController::getClassName());

	Route::get('schedule/view', ScheduleController::getControllerWithAction('show'));
	Route::get('schedule-exam/view', ScheduleExamController::getControllerWithAction('show'));

	Route::get('semester', SemesterController::getControllerWithAction('index'));
	Route::get('semester/view', SemesterController::getControllerWithAction('show'));

	Route::get('student/ranking', StudentController::getControllerWithAction('showRanking'));
	//test
    /*crawl*/
    Route::prefix('crawl')->group(function() {
        Route::get('student/{msv}', CrawlController::getControllerWithAction('crawlStudent'));
        Route::get('student-course/{code}', CrawlController::getControllerWithAction('crawlStudentCourse'));
        Route::get('schedule/{msv}', CrawlController::getControllerWithAction('crawlSchedule'));
        Route::get('schedule-course/{code}', CrawlController::getControllerWithAction('crawlScheduleCourse'));
        Route::get('schedule-exam/{msv}', CrawlController::getControllerWithAction('crawlScheduleExam'));
        Route::get('schedule-exam-course/{code}', CrawlController::getControllerWithAction('crawlScheduleExamCourse'));
        Route::get('semester', CrawlController::getControllerWithAction('crawlSemester'));
    });
    /*crawl*/
});
