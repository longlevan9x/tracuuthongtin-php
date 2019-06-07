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

	Route::get('student/{student_code}/schedules', StudentController::getControllerWithAction('getSchedules'));
	Route::get('student/{student_code}/schedule-exams', StudentController::getControllerWithAction('getScheduleExams'));
	Route::get('student/{student_code}/check', StudentController::getControllerWithAction('checkStudent'));
	//Route::resource(SemesterController::getResourceName(), SemesterController::getClassName())->except(['create', 'update']);
	Route::get('student/ranking', StudentController::getControllerWithAction('showRanking'));

	Route::get('student/{student_code}', StudentController::getControllerWithAction('show'));

	Route::get('schedule/{schedule_code}', ScheduleController::getControllerWithAction('show'));
	Route::get('schedule-exam/{schedule_exam_code}', ScheduleExamController::getControllerWithAction('show'));

	Route::get('semester', SemesterController::getControllerWithAction('index'));
	Route::get('semester/{id}', SemesterController::getControllerWithAction('show'));


	//test
    /*crawl*/
    Route::prefix('crawl')->group(function() {
        Route::get('debt', function () {
            (new \App\Crawler\CongNo(false, 16103100001))->asArray();
        });
        Route::get('student', CrawlController::getControllerWithAction('crawlStudent'));
        Route::get('student/course', CrawlController::getControllerWithAction('crawlStudentCourse'));
        Route::get('schedule', CrawlController::getControllerWithAction('crawlSchedule'));
        Route::get('schedule/course', CrawlController::getControllerWithAction('crawlScheduleCourse'));
        Route::get('schedule-exam', CrawlController::getControllerWithAction('crawlScheduleExam'));
        Route::get('schedule-exam/course', CrawlController::getControllerWithAction('crawlScheduleExamCourse'));
        Route::get('semester', CrawlController::getControllerWithAction('crawlSemester'));
    });
    /*crawl*/
});
