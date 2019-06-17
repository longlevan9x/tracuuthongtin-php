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
	Route::get('student/{student_code}/marks', StudentController::getControllerWithAction('getMarks'));
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
        Route::get('student/{student_code}', CrawlController::getControllerWithAction('crawlStudent'));
        Route::get('student/course/{course_code}', CrawlController::getControllerWithAction('crawlStudentCourse'));
        Route::get('schedule/{student_code}', CrawlController::getControllerWithAction('crawlSchedule'));
        Route::get('schedule/course/{course_code}', CrawlController::getControllerWithAction('crawlScheduleCourse'));
        Route::get('schedule-exam/{student_code}', CrawlController::getControllerWithAction('crawlScheduleExam'));
        Route::get('schedule-exam/course/{course_code}', CrawlController::getControllerWithAction('crawlScheduleExamCourse'));
        Route::get('semester', CrawlController::getControllerWithAction('crawlSemester'));
        Route::get('money-pay/{student_code}', CrawlController::getControllerWithAction('crawlMoneyPay'));
        Route::get('money-pay/course/{course_code}', CrawlController::getControllerWithAction('crawlMoneyPayCourse'));
        Route::get('/mark/{student_code}', CrawlController::getControllerWithAction('crawlMark'));
        Route::get('/mark/course/{course_code}', CrawlController::getControllerWithAction('crawlMarkCourse'));
    });
    /*crawl*/
});
