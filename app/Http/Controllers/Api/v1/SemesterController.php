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
use App\Models\Student;
use Illuminate\Http\Request;
use Pika\Api\QueryBuilder;
use Pika\Api\RequestCreator;

/**
 * Class SemesterController
 * @package App\Http\Controllers\Api\v1
 */
class SemesterController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function index(Request $request) {
        $queryBuilder = new QueryBuilder(new Semester(), $request);
        $queryBuilder->setDefaultUri(RequestCreator::createWithParameters(['order_by' => 'sort_order,desc']));

        $models = $queryBuilder->build()->get();

        if ($models->isNotEmpty()) {
            return responseJson(config('api_response.http_code.200'), $models, config('api_response.status.success'));
        }

        return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
	}

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id) {
        $queryBuilder = new QueryBuilder(new Semester(), $request);
        $queryBuilder->setDefaultUri(RequestCreator::createWithParameters(['id' => $id]));
        $model = $queryBuilder->build()->first();

        if (isset($model)) {
            return responseJson(config('api_response.http_code.200'), $model, config('api_response.status.success'));
        }

        return responseJson(config('api_response.http_code.204'), null, config('api_response.status.error'));
	}
}