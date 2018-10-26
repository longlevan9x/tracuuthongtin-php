<?php

namespace App\Http\Controllers\Api\V1;

use App\Commons\CConstant;
use App\Http\Controllers\Api\Controller;
use App\Models\Student;
use App\Models\StudentScheduleExam;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ScheduleExamController
 * @package App\Http\Controllers\Api\V1
 */
class ScheduleExamController extends Controller
{
	/**
	 * ScheduleController constructor.
	 * @param StudentScheduleExam $student_schedule_exam
	 */
	public function __construct(StudentScheduleExam $student_schedule_exam) { parent::__construct($student_schedule_exam); }

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getScheduleExam() {
		$model = $this->getModel();

		if ($this->getQueryBuilder()->getResults()->isNotEmpty()) {
			return responseJson(CConstant::STATUS_SUCCESS, $model, 200);

		}

		return responseJson(CConstant::STATUS_FAIL, "Schedule Exam" . CConstant::STATUS_NOT_FOUND, 404);
	}
}
