<?php

namespace App\Http\Controllers\Api\V1;

use App\Commons\CConstant;
use App\Http\Controllers\Api\Controller;
use App\Models\Schedule;


/**
 * Class ScheduleController
 * @package App\Http\Controllers\Api\V1
 */
class ScheduleController extends Controller
{
	/**
	 * ScheduleController constructor.
	 * @param Schedule $schedule
	 */
	public function __construct(Schedule $schedule) { parent::__construct($schedule); }

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getSchedule() {
		$model = $this->getModel();

		if ($this->getQueryBuilder()->getResults()->isNotEmpty()) {
			return responseJson(CConstant::STATUS_SUCCESS, $model, 200);

		}

		return responseJson(CConstant::STATUS_FAIL, "Schedule " . CConstant::STATUS_NOT_FOUND, 404);
	}
}
