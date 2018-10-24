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
use App\Http\Controllers\Api\V1\SemesterController;
use App\Http\Controllers\Api\V1\StudentController;
use App\Http\Controllers\Api\V1\SyncController;

Route::prefix('v1')->namespace('Api\V1')->group(function() {
	Route::get(ScheduleController::getResourceName(), ScheduleController::getControllerWithAction('getSchedule'));
	//	Route::resource('student', 'StudentController');
	Route::get('students', StudentController::getControllerWithAction('getStudents'));
	Route::prefix(StudentController::getResourceName())->group(function() {
		Route::get('/{msv}', StudentController::getControllerWithAction('getStudent'));
		Route::get('/{msv}/sync', StudentController::getControllerWithAction('syncStudent'));
	});
	Route::get('sync/student', SyncController::getControllerWithAction('syncInformationStudentByDepartment'));

	Route::resource(SemesterController::getResourceName(), SemesterController::getClassName());

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
