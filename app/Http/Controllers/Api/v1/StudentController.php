<?php

namespace App\Http\Controllers\Api\V1;

use App\Commons\CConstant;
use App\Http\Controllers\Api\Controller;
use App\Models\Student;
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
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getStudent(Request $request) {
		if (empty($request->get('code'))) {
			return responseJson('error', httpcode_replace(config('http_code.400'), 'code'), 400);
		}

		$queryBuilder = new QueryBuilder(new Student, $request);

		$model = $queryBuilder->build()->first();

		if (isset($model)) {
			return responseJson(CConstant::STATUS_SUCCESS, $model, 200);
		}

		return responseJson(CConstant::STATUS_FAIL, "Student " . CConstant::STATUS_NOT_FOUND, 404);
	}

	/**
	 * @return array|Model|\Illuminate\Http\Request|null|object|\Pika\Api\QueryBuilder|string
	 */
	public function getScheduleExams() {
		/** @var Student $model */
		$model = $this->getModel();

		if ($this->getQueryBuilder()->getResults()->isNotEmpty()) {
			return responseJson(CConstant::STATUS_SUCCESS, $model->scheduleExams()->get(), 200);

		}

		return responseJson(CConstant::STATUS_FAIL, "Student " . CConstant::STATUS_NOT_FOUND, 404);
	}

	/**
	 * @return array|Model|\Illuminate\Http\Request|null|object|\Pika\Api\QueryBuilder|string
	 */
	public function getSchedules() {
		/** @var Student $model */
		$model = $this->getModel();

		if ($this->getQueryBuilder()->getResults()->isNotEmpty()) {
			return responseJson(CConstant::STATUS_SUCCESS, $model->schedules()->get(), 200);

		}

		return responseJson(CConstant::STATUS_FAIL, "Student " . CConstant::STATUS_NOT_FOUND, 404);
	}
}
