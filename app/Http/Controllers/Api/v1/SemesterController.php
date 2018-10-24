<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 5/24/2018
 * Time: 9:22 AM
 */

namespace App\Http\Controllers\Api\V1;


use App\Commons\CConstant;
use App\Http\Controllers\Api\Controller;
use App\Models\Semester;
use Unlu\Laravel\Api\QueryBuilder;

/**
 * Class SemesterController
 * @package App\Http\Controllers\Api\v1
 */
class SemesterController extends Controller
{
	/**
	 * SemesterController constructor.
	 * @param Semester $semester
	 */
	public function __construct(Semester $semester) {
		parent::__construct($semester);
	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index() {
		if ($this->paginateQueryBuilder()->isEmpty()) {
			return responseJson("Semester" . CConstant::STATUS_NOT_FOUND, null, 404);
		}

		return responseJson(CConstant::STATUS_SUCCESS, $this->paginateQueryBuilder(), 200);

	}

	public function show(Semester $semester) {
		if (!isset($semester) || empty($semester)) {
			return responseJson("Semester" . CConstant::STATUS_NOT_FOUND, null, 404);
		}

		return responseJson(CConstant::STATUS_SUCCESS, $semester, 200);
	}
}