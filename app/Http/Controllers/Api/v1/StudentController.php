<?php

namespace App\Http\Controllers\Api\V1;

use App\Commons\CConstant;
use App\Crawler\Crawl;
use App\Http\Controllers\Api\Controller;
use App\Models\Schedule;
use App\Models\ScheduleExam;
use App\Models\Semester;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Pika\Api\QueryBuilder;
use Pika\Api\RequestCreator;


/**
 * Class StudentController
 * @package App\Http\Controllers\Api\V1
 */
class StudentController extends Controller
{
	/**
	 * @param Request $request
	 * @param         $student_code
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Request $request, $student_code) {
		$queryBuilder = new QueryBuilder(new Student, $request);
		$queryBuilder->setDefaultUri(RequestCreator::createWithParameters(['code' => $student_code]));
		$model = $queryBuilder->build()->first();
		$model->makeHidden(['department_id', 'course_id', 'department']);
		if (isset($model)) {
			return responseJson(config('api_response.http_code.200'), $model, config('api_response.status.success'));
		}

		return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
	}

	/**
	 * @param Request $request
	 * @param         $student_code
	 * @return array|Model|\Illuminate\Http\Request|null|object|\Pika\Api\QueryBuilder|string
	 */
	public function getScheduleExams(Request $request, $student_code) {
		$queryBuilder = new QueryBuilder(new ScheduleExam, $request);

		if (empty($request->get('semester'))) {
			$semester      = Semester::query()->orderBySortOrderDesc()->first();
			$semester_name = $semester->name;
			$queryBuilder->setDefaultUri(RequestCreator::createWithParameters(['semester' => $semester_name]));
		}

		$queryBuilder->setQuery(ScheduleExam::joinRelations('studentScheduleExams')->whereJoin('studentScheduleExams.student_code', '=', $student_code));
		$models = $queryBuilder->build()->get();

		if ($models->isNotEmpty()) {
			return responseJson(config("api_response.http_code.200"), $models, config('api_response.status.success'));
		}

		return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
	}

	/**
	 * @param Request $request
	 * @param         $student_code
	 * @return array|Model|\Illuminate\Http\Request|null|object|\Pika\Api\QueryBuilder|string
	 */
	public function getSchedules(Request $request, $student_code) {
		$queryBuilder = new QueryBuilder(new Schedule, $request);

		if (empty($request->get('semester'))) {
			$semester      = Semester::query()->orderBySortOrderDesc()->first();
			$semester_name = $semester->name;
			$queryBuilder->setDefaultUri(RequestCreator::createWithParameters(['semester' => $semester_name]));
		}

		$queryBuilder->setQuery(Schedule::joinRelations('studentSchedules')->whereJoin('studentSchedules.student_code', '=', $student_code));
		$models = $queryBuilder->build()->get();

		if ($models->isNotEmpty()) {
			return responseJson(config("api_response.http_code.200"), $models, config('api_response.status.success'));
		}

		return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function showRanking(Request $request) {
		if (empty($request->get('course_id'))) {
			return responseJson(httpcode_replace(config('api_response.http_code.400'), 'course_id'), null, config('api_response.status.missing_param'));
		}

		$order_by = '';
		if (empty($request->get('order_by'))) {
			$order_by = "gpa_4,desc";
		}
		$queryBuilder = new QueryBuilder(new Student, $request);

		$queryBuilder->setDefaultUri(RequestCreator::createWithParameters(['order_by' => $order_by]));
		$models = $queryBuilder->build()->get();

		if ($models->isNotEmpty()) {
			return responseJson(config('api_response.http_code.200'), $models, config('api_response.status.success'));
		}

		return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
	}

	public function checkStudent($student_code) {
		$student = Student::whereCode($student_code)->first();
		if (isset($student)) {
			if ($student->is_active == 1) {
				return responseJson(config('api_response.http_code.200'), $student_code, config('api_response.status.success'));
			}
			else {
				return responseJson(config('api_response.http_code.204'), "Msv không tồn tại", config('api_response.status.error'));
			}
		}
		else {
			$crawl    = new Crawl;
			$response = $crawl->crawlStudent($student_code);

			if ($response->original['status'] == 1) {
				return responseJson(config('api_response.http_code.200'), $student_code, config('api_response.status.success'));
			}
			else {
				Student::updateOrInsert(['code' => $student_code, 'is_active' => 0, 'created_at' => Carbon::now()]);

				return responseJson(config('api_response.http_code.204'), "Msv không tồn tại", config('api_response.status.error'));
			}
		}
	}
}
