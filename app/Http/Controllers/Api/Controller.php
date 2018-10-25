<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Model;
use Pika\Api\QueryBuilder;

/**
 * Class Controller
 * @package App\Http\Api\Controllers
 */
class Controller extends \App\Http\Controllers\Controller
{
	/**
	 * @var QueryBuilder
	 */
	protected $queryBuilder;

	/**
	 * Controller constructor.
	 * @param Model $model
	 */
	public function __construct(Model $model) {
		$this->setQueryBuilder($model);
		$this->buildQueryBuilder();
	}

	/**
	 * @return QueryBuilder
	 */
	public function getQueryBuilder(): QueryBuilder {
		return $this->queryBuilder;
	}

	/**
	 * @param Model $model
	 * @return Controller
	 */
	public function setQueryBuilder($model): Controller {
		$this->queryBuilder = new QueryBuilder($model, request());

		return $this;
	}

	/**
	 * @return $this
	 */
	protected function buildQueryBuilder() {
		$this->queryBuilder = $this->getQueryBuilder()->build();

		return $this;
	}

	/**
	 * @return mixed|\Unlu\Laravel\Api\Paginator
	 * @throws \Exception
	 */
	protected function paginateQueryBuilder() {
		return $this->getQueryBuilder()->paginate();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection|mixed|QueryBuilder[]
	 */
	protected function getModel() {
		return $this->getQueryBuilder()->get();
	}
}
