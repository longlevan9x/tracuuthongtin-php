<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Models\Schedule;
use Pika\Api\QueryBuilder;
use Illuminate\Http\Request;


/**
 * Class ScheduleController
 * @package App\Http\Controllers\Api\V1
 */
class ScheduleController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function show(Request $request) {
        if (empty($request->get('code'))) {
            return responseJson(httpcode_replace(config('api_response.http_code.400'), 'code'), null, config("api_response.status.missing_param"));
        }

        $queryBuilder = new QueryBuilder(new Schedule(), $request);

        $model = $queryBuilder->build()->first();

        if (isset($model)) {
            return responseJson(config("api_response.http_code.200"), $model, config('api_response.status.success'));
        }
        return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
    }
}
