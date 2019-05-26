<?php

namespace App\Http\Controllers\Api\V1;

use App\Commons\CConstant;
use App\Crawler\Crawl;
use App\Http\Controllers\Api\Controller;
use App\Models\Schedule;
use App\Models\ScheduleExam;
use App\Models\Semester;
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
    public function show(Request $request) {
        if (empty($request->get('msv'))) {
            return responseJson(httpcode_replace(config('api_response.http_code.400'), 'msv'), null, config('api_response.status.missing_param'));
        }

        $queryBuilder = new QueryBuilder(new Student, $request);

        $model = $queryBuilder->build()->first();

        if (isset($model)) {
            return responseJson(config('api_response.http_code.200'), $model, config('api_response.status.success'));
        }

        return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
    }

    /**
     * @param Request $request
     * @return array|Model|\Illuminate\Http\Request|null|object|\Pika\Api\QueryBuilder|string
     */
    public function getScheduleExams(Request $request) {
        if (empty($request->get('msv'))) {
            return responseJson(httpcode_replace(config('api_response.http_code.400'), 'msv'), null, config('api_response.status.missing_param'));
        }

        $queryBuilder = new QueryBuilder(new ScheduleExam(), $request);

        if (empty($request->get('semester'))) {
            $semester = Semester::query()->orderBySortOrderDesc()->first();
            $semester_name = $semester->name;
            $queryBuilder->setDefaultUri(RequestCreator::createWithParameters(['semester' => $semester_name]));
        }

        $queryBuilder->setExcludedParameters(['msv']);
        $queryBuilder->setQuery(ScheduleExam::joinRelations('studentScheduleExams')->whereJoin('studentScheduleExams.student_code', '=', $request->get('msv')));
        $models = $queryBuilder->build()->get();

        if ($models->isNotEmpty()) {
            return responseJson(config("api_response.http_code.200"), $models, config('api_response.status.success'));
        }
        return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
    }

    /**
     * @param Request $request
     * @return array|Model|\Illuminate\Http\Request|null|object|\Pika\Api\QueryBuilder|string
     */
    public function getSchedules(Request $request) {
        if (empty($request->get('msv'))) {
            return responseJson(httpcode_replace(config('api_response.http_code.400'), 'msv'), null, config('api_response.status.missing_param'));
        }

        $queryBuilder = new QueryBuilder(new Schedule(), $request);
        if (empty($request->get('semester'))) {
            $semester = Semester::query()->orderBySortOrderDesc()->first();
            $semester_name = $semester->name;
            $queryBuilder->setDefaultUri(RequestCreator::createWithParameters(['semester' => $semester_name]));
        }

        $queryBuilder->setExcludedParameters(['msv']);
        $queryBuilder->setQuery(Schedule::joinRelations('studentSchedules')->whereJoin('studentSchedules.student_code', '=', $request->get('msv')));
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

    public function checkCode(Request $request) {
	    if (empty($request->get('msv'))) {
		    return responseJson(httpcode_replace(config('api_response.http_code.400'), 'msv'), null, config('api_response.status.missing_param'));
	    }

		$msv = $request->get('msv');

	    $student = Student::whereCode($msv)->first();
		if (!isset($student)) {

		}
	    else {
			$crawl = new Crawl();
			$crawl->crawlStudent($msv);

			return responseJson(config('api_response.http_code.200'), $msv, config('api_response.status.success'));
	    }
    }
}
