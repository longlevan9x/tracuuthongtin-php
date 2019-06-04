<?php

namespace Pika\Api;
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 10/25/2018
 * Time: 10:58
 */

use Illuminate\Http\Request;

/**
 * Class UrlParser
 * @package Pika\Api
 */
class UriParser
{
	const PATTERN             = '/!=|=|<=|<|>=|>/';
	const ARRAY_QUERY_PATTERN = '/(.*)\[\]/';

	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * @var array
	 */
	protected $constantParameters = [
		'order_by',
		'group_by',
		'limit',
		'page',
		'columns',
		'includes',
		'appends'
	];

	/**
	 * @var string
	 */
	protected $uri;

	/**
	 * @var string
	 */
	protected $queryUri;

	/**
	 * @var array
	 */
	protected $queryParameters = [];

	/**
	 * UrlParser constructor.
	 * @param Request $request
	 */
	public function __construct(Request $request) {
		$this->request = $request;

		$this->uri = $request->getRequestUri();

		$this->setQueryUri($this->uri);

		if ($this->hasQueryUri()) {
			$this->setQueryParameters($this->queryUri);
		}
	}

	/**
	 * @return string
	 */
	public static function getPattern() {
		return self::PATTERN;
	}

	/**
	 * @return string
	 */
	public static function getArrayQueryPattern() {
		return self::ARRAY_QUERY_PATTERN;
	}

	/**
	 * @param $key
	 * @return mixed
	 */
	public function queryParameter($key) {
		$keys = array_pluck($this->queryParameters, 'key');

		$queryParameters = array_combine($keys, $this->queryParameters);

		return $queryParameters[$key];
	}

	/**
	 * @return array
	 */
	public function constantParameters() {
		return $this->constantParameters;
	}

	/**
	 * @return array
	 */
	public function whereParameters() {
		return array_filter($this->queryParameters, function($queryParameter) {
			$key = $queryParameter['key'];

			return (!in_array($key, $this->constantParameters));
		});
	}

	/**
	 * @param $uri
	 */
	private function setQueryUri($uri) {
		$explode = explode('?', $uri);

		$this->queryUri = (isset($explode[1])) ? rawurldecode($explode[1]) : null;
	}

	/**
	 * @param $queryUri
	 */
	private function setQueryParameters($queryUri) {
		$queryParameters = array_filter(explode('&', $queryUri));

		array_map([$this, 'appendQueryParameter'], $queryParameters);
	}

	/**
	 * @param $parameter
	 */
	private function appendQueryParameter($parameter) {
		// whereIn expression
		preg_match(self::ARRAY_QUERY_PATTERN, $parameter, $arrayMatches);
		if (count($arrayMatches) > 0) {
			$this->appendQueryParameterAsWhereIn($parameter, $arrayMatches[1]);

			return;
		}

		// basic where expression
		$this->appendQueryParameterAsBasicWhere($parameter);
	}

	/**
	 * @param $parameter
	 */
	private function appendQueryParameterAsBasicWhere($parameter) {
		preg_match(self::PATTERN, $parameter, $matches);

		$operator = $matches[0];

		list($key, $value) = explode($operator, $parameter);

		if (!$this->isConstantParameter($key) && $this->isLikeQuery($value)) {
			$operator = 'like';
			$value    = str_replace('*', '%', $value);
		}

		$this->queryParameters[] = [
			'type'     => 'Basic',
			'key'      => $key,
			'operator' => $operator,
			'value'    => $value
		];
	}

	/**
	 * @param $parameter
	 * @param $key
	 */
	private function appendQueryParameterAsWhereIn($parameter, $key) {
		if (str_contains($parameter, '!=')) {
			$type      = 'NotIn';
			$seperator = '!=';
		}
		else {
			$type      = 'In';
			$seperator = '=';
		}

		$index = null;
		foreach ($this->queryParameters as $_index => $queryParameter) {
			if ($queryParameter['type'] == $type && $queryParameter['key'] == $key) {
				$index = $_index;
				break;
			}
		}

		if ($index !== null) {
			$this->queryParameters[$index]['values'][] = explode($seperator, $parameter)[1];
		}
		else {
			$this->queryParameters[] = [
				'type'   => $type,
				'key'    => $key,
				'values' => [explode($seperator, $parameter)[1]]
			];
		}
	}

	/**
	 * @return bool
	 */
	public function hasQueryUri() {
		return ($this->queryUri);
	}

	/**
	 * @return string
	 */
	public function getQueryUri() {
		return $this->queryUri;
	}

	/**
	 * @return bool
	 */
	public function hasQueryParameters() {
		return (count($this->queryParameters) > 0);
	}

	/**
	 * @param $key
	 * @return bool
	 */
	public function hasQueryParameter($key) {
		$keys = array_pluck($this->queryParameters, 'key');

		return (in_array($key, $keys));
	}

	/**
	 * @param $query
	 * @return false|int
	 */
	private function isLikeQuery($query) {
		$pattern = "/^\*|\*$/";

		return (preg_match($pattern, $query, $matches));
	}

	/**
	 * @param $key
	 * @return bool
	 */
	private function isConstantParameter($key) {
		return (in_array($key, $this->constantParameters));
	}
}