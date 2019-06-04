<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 10/25/2018
 * Time: 11:02
 */

namespace Pika\Api;


use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator as BasePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Pika\Api\Exceptions\UnknownColumnException;
use Pika\Api\UriParser;

/**
 * Class QueryBuilder
 * @package Pika\Api
 */
class QueryBuilder
{
	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * @var \Pika\Api\UriParser
	 */
	protected $uriParser;

	/**
	 * @var \Pika\Api\UriParser
	 */
	protected $defaultUriParser;
	/**
	 * @var array
	 */
	protected $wheres = [];

	/**
	 * @var array|\Illuminate\Config\Repository|mixed
	 */
	protected $orderBy = [];

	/**
	 * @var \Illuminate\Config\Repository|mixed
	 */
	protected $limit;

	/**
	 * @var int
	 */
	protected $page = 1;

	/**
	 * @var int
	 */
	protected $offset = 0;

	/**
	 * @var array
	 */
	protected $columns = ['*'];

	/**
	 * @var array
	 */
	protected $relationColumns = [];

	/**
	 * @var array
	 */
	protected $includes = [];

	/**
	 * @var array
	 */
	protected $groupBy = [];

	/**
	 * @var array
	 */
	protected $excludedParameters = [];

	/**
	 * @var array
	 */
	protected $appends = [];

	/**
	 * @var \Illuminate\Database\Eloquent\Builder
	 */
	protected $query;

	/**
	 * QueryBuilder constructor.
	 * @param Model   $model
	 * @param Request $request
	 * @param Request $defaultRequest
	 */
	public function __construct(Model $model, Request $request, Request $defaultRequest = null) {
		$this->orderBy = config('api-query-builder.orderBy', []);

		$this->limit = config('api-query-builder.limit');

		$this->excludedParameters = array_merge($this->excludedParameters, config('api-query-builder.excludedParameters'));

		$this->model = $model;

		$this->uriParser = new UriParser($request);

		if (isset($defaultRequest)) {
			$this->setDefaultUri($defaultRequest);
		}

		$this->query = $this->model->newQuery();
	}

	/**
	 * @return $this
	 */
	public function build() {
		$this->prepare();

		if ($this->hasWheres()) {
			array_map([$this, 'addWhereToQuery'], $this->wheres);
		}

		if ($this->hasGroupBy()) {
			$this->query->groupBy($this->groupBy);
		}

		if ($this->hasLimit()) {
			$this->query->take($this->limit);
		}

		if ($this->hasOffset()) {
			$this->query->skip($this->offset);
		}


		array_map([$this, 'addOrderByToQuery'], $this->orderBy);

		$this->query->with($this->includes);

		if (empty($this->columns)) {
			$this->columns = ['*'];
		}

		$this->query->select($this->columns);

		return $this;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Builder[]|Collection|mixed
	 */
	public function get() {
		$result = $this->query->get();

		if ($this->hasAppends()) {
			$result = $this->addAppendsToModel($result);
		}

		return $result;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Model|object|static|null
	 */
	public function first() {
		return $this->get()->get(0);
	}

	/**
	 * @return mixed|Paginator
	 * @throws Exception
	 */
	public function paginate() {
		if (!$this->hasLimit()) {
			throw new Exception("You can't use unlimited option for pagination", 1);
		}

		$result = $this->basePaginate($this->limit);

		if ($this->hasAppends()) {
			$result = $this->addAppendsToModel($result);
		}

		return $result;
	}

	/**
	 * @param $value
	 * @param $key
	 * @return mixed
	 */
	public function lists($value, $key) {
		return $this->query->lists($value, $key);
	}

	/**
	 * @param Request $request
	 * @return $this
	 */
	public function setDefaultUri(Request $request) {
		$this->defaultUriParser = new UriParser($request);

		return $this;
	}

	/** Set method */
	/**
	 * @param Request $request
	 * @return $this
	 */
	public function setUriParser(Request $request) {
		$this->uriParser = new UriParser($request);

		return $this;
	}

	/**
	 * @param Builder $query
	 * @return $this
	 */
	public function setQuery(Builder $query) {
		$this->query = $query;
		return $this;
	}

	/**
	 * @param $excludedParameters
	 * @return $this
	 */
	public function setExcludedParameters($excludedParameters) {
		$this->excludedParameters = $excludedParameters;
		return $this;
	}

	/**
	 * @param $limit
	 * @return $this
	 */
	public function limit($limit) {
		$this->setLimit($limit);
		return $this;
	}
	/** Set Method */

	/**
	 * @return $this
	 */
	protected function prepare() {
		$this->setWheres($this->uriParser->whereParameters());

		$defaultConstantParameters = [];
		if (isset($this->defaultUriParser)) {
			$defaultWhereParameters = $this->defaultUriParser->whereParameters();
			if (!empty($defaultWhereParameters)) {
				$this->setWheres($defaultWhereParameters);
			}
			$defaultConstantParameters = $this->defaultUriParser->constantParameters();
		}

		$constantParameters = $this->uriParser->constantParameters();

		array_map([$this, 'prepareConstant'], $constantParameters);
		array_map([$this, 'prepareDefaultConstant'], $defaultConstantParameters);

		if ($this->hasIncludes() && $this->hasRelationColumns()) {
			$this->fixRelationColumns();
		}

		return $this;
	}

	/**
	 * @param $parameter
	 */
	private function prepareConstant($parameter) {
		if (!$this->uriParser->hasQueryParameter($parameter)) {
			return;
		}

		$callback = [$this, $this->setterMethodName($parameter)];

		$callbackParameter = $this->uriParser->queryParameter($parameter);

		call_user_func($callback, $callbackParameter['value']);
	}


	/**
	 * @param $parameter
	 */
	private function prepareDefaultConstant($parameter) {
		if (!$this->defaultUriParser->hasQueryParameter($parameter)) {
			return;
		}

		$callback = [$this, $this->setterMethodName($parameter)];

		$callbackParameter = $this->defaultUriParser->queryParameter($parameter);

		call_user_func($callback, $callbackParameter['value']);
	}

	/**
	 * @param $includes
	 */
	private function setIncludes($includes) {
		$this->includes = array_filter(explode(',', $includes));
	}

	/**
	 * @param $page
	 */
	private function setPage($page) {
		$this->page = (int) $page;

		$this->offset = ($page - 1) * $this->limit;
	}

	/**
	 * @param $columns
	 */
	private function setColumns($columns) {
		$columns = array_filter(explode(',', $columns));

		$this->columns = $this->relationColumns = [];

		array_map([$this, 'setColumn'], $columns);
	}

	/**
	 * @param $column
	 */
	private function setColumn($column) {
		if ($this->isRelationColumn($column)) {
			return $this->appendRelationColumn($column);
		}

		$this->columns[] = $column;
	}

	/**
	 * @param $keyAndColumn
	 */
	private function appendRelationColumn($keyAndColumn) {
		list($key, $column) = explode('.', $keyAndColumn);

		$this->relationColumns[$key][] = $column;
	}

	/**
	 *
	 */
	private function fixRelationColumns() {
		$keys = array_keys($this->relationColumns);

		$callback = [$this, 'fixRelationColumn'];

		array_map($callback, $keys, $this->relationColumns);
	}

	/**
	 * @param $key
	 * @param $columns
	 */
	private function fixRelationColumn($key, $columns) {
		$index = array_search($key, $this->includes);

		unset($this->includes[$index]);

		$this->includes[$key] = $this->closureRelationColumns($columns);
	}

	/**
	 * @param $columns
	 * @return \Closure
	 */
	private function closureRelationColumns($columns) {
		return function($q) use ($columns) {
			$q->select($columns);
		};
	}

	/**
	 * @param $order
	 */
	private function setOrderBy($order) {
		$this->orderBy = [];

		$orders = array_filter(explode('|', $order));

		array_map([$this, 'appendOrderBy'], $orders);
	}

	/**
	 * @param $order
	 */
	private function appendOrderBy($order) {
		if ($order == 'random') {
			$this->orderBy[] = 'random';

			return;
		}

		list($column, $direction) = explode(',', $order);

		$this->orderBy[] = [
			'column'    => $column,
			'direction' => $direction
		];
	}

	/**
	 * @param $groups
	 */
	private function setGroupBy($groups) {
		$this->groupBy = array_filter(explode(',', $groups));
	}

	/**
	 * @param $limit
	 */
	private function setLimit($limit) {
		$limit = ($limit == 'unlimited') ? null : (int) $limit;

		$this->limit = $limit;
	}

	/**
	 * @param $parameters
	 */
	private function setWheres($parameters) {
		$this->wheres = array_merge($this->wheres, $parameters);
	}

	/**
	 * @param $appends
	 */
	private function setAppends($appends) {
		$this->appends = explode(',', $appends);
	}

	/**
	 * @param $where
	 * @throws UnknownColumnException
	 */
	private function addWhereToQuery($where) {
		extract($where);

		// For array values (whereIn, whereNotIn)
		if (isset($values)) {
			$value = $values;
		}
		if (!isset($operator)) {
			$operator = '';
		}

		/** @var mixed $key */
		if ($this->isExcludedParameter($key)) {
			return;
		}

		if ($this->hasCustomFilter($key)) {
			/** @var string $type */
			return $this->applyCustomFilter($key, $operator, $value, $type);
		}

		if (!$this->hasTableColumn($key)) {
			throw new UnknownColumnException("Unknown column '{$key}'");
		}

		/** @var string $type */
		if ($type == 'In') {
			$this->query->whereIn($key, $value);
		}
		elseif ($type == 'NotIn') {
			$this->query->whereNotIn($key, $value);
		}
		else {
			if ($value == '[null]') {
				if ($operator == '=') {
					$this->query->whereNull($key);
				}
				else {
					$this->query->whereNotNull($key);
				}
			}
			else {
				$this->query->where($key, $operator, $value);
			}
		}
	}

	/**
	 * @param $order
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	private function addOrderByToQuery($order) {
		if ($order == 'random') {
			return $this->query->orderBy(DB::raw('RAND()'));
		}

		extract($order);

		/** @var string $column */
		/** @var string $direction */
		$this->query->orderBy($column, $direction);
	}

	/**
	 * @param        $key
	 * @param        $operator
	 * @param        $value
	 * @param string $type
	 */
	private function applyCustomFilter($key, $operator, $value, $type = 'Basic') {
		$callback = [$this, $this->customFilterName($key)];

		$this->query = call_user_func($callback, $this->query, $value, $operator, $type);
	}

	/**
	 * @param $column
	 * @return bool
	 */
	private function isRelationColumn($column) {
		return (count(explode('.', $column)) > 1);
	}

	/**
	 * @param $key
	 * @return bool
	 */
	private function isExcludedParameter($key) {
		return in_array($key, $this->excludedParameters);
	}

	/**
	 * @return bool
	 */
	private function hasWheres() {
		return (count($this->wheres) > 0);
	}

	/**
	 * @return bool
	 */
	private function hasIncludes() {
		return (count($this->includes) > 0);
	}

	/**
	 * @return bool
	 */
	private function hasAppends() {
		return (count($this->appends) > 0);
	}

	/**
	 * @return bool
	 */
	private function hasGroupBy() {
		return (count($this->groupBy) > 0);
	}

	/**
	 * @return \Illuminate\Config\Repository|mixed
	 */
	private function hasLimit() {
		return ($this->limit);
	}

	/**
	 * @return bool
	 */
	private function hasOffset() {
		return ($this->offset != 0);
	}

	/**
	 * @return bool
	 */
	private function hasRelationColumns() {
		return (count($this->relationColumns) > 0);
	}

	/**
	 * @param $column
	 * @return bool
	 */
	private function hasTableColumn($column) {
		return (Schema::hasColumn($this->model->getTable(), $column));
	}

	/**
	 * @param $key
	 * @return bool
	 */
	private function hasCustomFilter($key) {
		$methodName = $this->customFilterName($key);

		return (method_exists($this, $methodName));
	}

	/**
	 * @param $key
	 * @return string
	 */
	private function setterMethodName($key) {
		return 'set' . studly_case($key);
	}

	/**
	 * @param $key
	 * @return string
	 */
	private function customFilterName($key) {
		return 'filterBy' . studly_case($key);
	}

	/**
	 * @param $result
	 * @return mixed
	 */
	private function addAppendsToModel($result) {
		$result->map(function($item) {
			$item->append($this->appends);

			return $item;
		});

		return $result;
	}

	/**
	 * Paginate the given query.
	 * @param  int      $perPage
	 * @param  array    $columns
	 * @param  string   $pageName
	 * @param  int|null $page
	 * @return Paginator
	 * @throws \InvalidArgumentException
	 */
	private function basePaginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null) {
		$page = $page ?: BasePaginator::resolveCurrentPage($pageName);

		$perPage = $perPage ?: $this->model->getPerPage();

		$query = $this->query->getQuery();

		$total = $query->getCountForPagination();

		$results = $total ? $this->query->forPage($page, $perPage)->get($columns) : new Collection;

		return (new Paginator($results, $total, $perPage, $page, [
			'path'     => BasePaginator::resolveCurrentPath(),
			'pageName' => $pageName,
		]))->setQueryUri($this->uriParser->getQueryUri());
	}
}
