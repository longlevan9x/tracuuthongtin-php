<?php

namespace App\Http\Controllers\Api\V1;

use App\Commons\CConstant;
use App\Http\Controllers\Api\Controller;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Pika\Api\QueryBuilder;
use Pika\Api\RequestCreator;
use Pika\Api\UriParser;

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


        if ($this->getQueryBuilder()->getResults()->isNotEmpty()) {
            return responseJson(CConstant::STATUS_SUCCESS, $model->scheduleExams()->get(), 200);

        }

        return responseJson(CConstant::STATUS_FAIL, "Student " . CConstant::STATUS_NOT_FOUND, 404);
    }

    /**
     * @param Request $request
     * @return array|Model|\Illuminate\Http\Request|null|object|\Pika\Api\QueryBuilder|string
     */
    public function getSchedules(Request $request) {
        if (empty($request->get('code'))) {
            return responseJson('error', httpcode_replace(config('http_code.400'), 'code'), 400);
        }
        $models = Schedule::joinRelations('studentSchedules')->whereJoin('studentSchedules.student_code', '=', $request->get('code'))->get();
        return response()->json($models);
        return view('layouts.app');
        $models = Schedule::whereSemester('2 (2018 - 2019)')->first();
        $models->load(['studentSchedules' => function($query) {
            /** @var QueryBuilder $query */
            $query->where("student_code", '15103100001');
        }]);
        return view('layouts.app');
//        $queryBuilder = new QueryBuilder(new Student, $request);

        $uriParser = new UriParser($request);

        $model = Schedule::query()->where($uriParser->whereParameters())->get();
        $extra_query = $request->get('extra_query');


//        $model = $queryBuilder->build()->get();

        return responseJson(CConstant::STATUS_SUCCESS, $model, 200);

    }
}
