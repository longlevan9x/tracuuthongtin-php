<?php

namespace App\Http\Controllers\Api\V1;

use App\Commons\CConstant;
use App\Http\Controllers\Api\Controller;
use App\Models\Schedule;
use Request;


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
	public function getSchedule(Request $request) {
        if (empty($request->get('code'))) {
            return responseJson('error', httpcode_replace(config('http_code.400'), 'code'), 400);
        }

		$model = $this->getModel();

		if ($this->getQueryBuilder()->getResults()->isNotEmpty()) {
			return responseJson(CConstant::STATUS_SUCCESS, $model, 200);

		}

		return responseJson(CConstant::STATUS_FAIL, "Schedule " . CConstant::STATUS_NOT_FOUND, 404);
	}
}
