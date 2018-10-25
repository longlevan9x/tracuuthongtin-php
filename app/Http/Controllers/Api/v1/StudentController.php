<?php

namespace App\Http\Controllers\Api\V1;

use App\Commons\CConstant;
use App\Http\Controllers\Api\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

/**
 * Class StudentController
 * @package App\Http\Controllers\Api\V1
 */
class StudentController extends Controller
{
	/**
	 * StudentController constructor.
	 * @param Student $student
	 */
	public function __construct(Student $student) { parent::__construct($student); }

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getStudent() {
		$model = $this->getModel();

		if ($model->exists()) {
			return responseJson(CConstant::STATUS_SUCCESS, $model, 200);

		}

		return responseJson(CConstant::STATUS_FAIL, "Student " . CConstant::STATUS_NOT_FOUND, 404);
	}
}
