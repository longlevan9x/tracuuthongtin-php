<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Models\Schedule;
use Pika\Api\QueryBuilder;
use Illuminate\Http\Request;
use Pika\Api\RequestCreator;


/**
 * Class ScheduleController
 * @package App\Http\Controllers\Api\V1
 */
class ScheduleController extends Controller
{
	/**
	 * @param Request $request
	 * @param         $schedule_code
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Request $request, $schedule_code) {
        $queryBuilder = new QueryBuilder(new Schedule(), $request);

		$queryBuilder->setDefaultUri(RequestCreator::createWithParameters(['code' => $schedule_code]));
		$model = $queryBuilder->build()->first();

        if (isset($model)) {
            return responseJson(config("api_response.http_code.200"), $model, config('api_response.status.success'));
        }
        return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
    }
}
