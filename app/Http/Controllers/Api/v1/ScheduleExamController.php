<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Models\ScheduleExam;
use Illuminate\Http\Request;
use Pika\Api\QueryBuilder;
use Pika\Api\RequestCreator;

/**
 * Class ScheduleExamController
 * @package App\Http\Controllers\Api\V1
 */
class ScheduleExamController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $schedule_exam_code) {
        $queryBuilder = new QueryBuilder(new ScheduleExam(), $request);
	    $queryBuilder->setDefaultUri(RequestCreator::createWithParameters(['code' => $schedule_exam_code]));
        $model = $queryBuilder->build()->first();

        if (isset($model)) {
            return responseJson(config("api_response.http_code.200"), $model, config('api_response.status.success'));
        }
        return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
    }
}
