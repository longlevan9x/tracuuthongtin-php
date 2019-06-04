<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 10/25/2018
 * Time: 11:02
 */

namespace Pika\Api;

use Illuminate\Pagination\LengthAwarePaginator;

/***
 * Class Paginator
 * @package Pika\Api
 */
class Paginator extends LengthAwarePaginator
{
	/**
	 * @var string
	 */
	protected $queryUri;

	/**
	 * @return string
	 */
	public function getQueryUri() {
		return $this->queryUri;
	}

	/**
	 * Paginator constructor.
	 * @param       $items
	 * @param       $total
	 * @param       $perPage
	 * @param null  $currentPage
	 * @param array $options
	 */
	public function __construct($items, $total, $perPage, $currentPage = null, array $options = [])
	{
		parent::__construct($items, $total, $perPage, $currentPage, $options);
	}

	/**
	 * @param $queryUri
	 * @return $this
	 */
	public function setQueryUri($queryUri)
	{
		$this->queryUri = str_replace(
			sprintf('&%s=%d', $this->getPageName(), $this->currentPage()),
			'',
			$queryUri
		);

		return $this;
	}

	/**
	 * @return mixed|null|string
	 */
	public function nextPageUrl()
	{
		return $this->appendQueryParametersToUrl(parent::nextPageUrl());
	}

	/**
	 * @return mixed|null|string
	 */
	public function previousPageUrl()
	{
		return $this->appendQueryParametersToUrl(parent::previousPageUrl());
	}

	/**
	 * @param null $url
	 * @return mixed|null|string
	 */
	private function appendQueryParametersToUrl($url = null)
	{
		if ($url) {
			$pageParameter = explode('?', $url)[1];
			$url = str_replace('?' . $pageParameter, '', $url);
			$url .= '?' . $this->queryUri . '&' . $pageParameter;
		}

		return $url;
	}
}
