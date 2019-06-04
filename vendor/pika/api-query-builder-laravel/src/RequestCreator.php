<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 10/25/2018
 * Time: 11:01
 */

namespace Pika\Api;

use Illuminate\Http\Request;

/**
 * Class RequestCreator
 * @package Pika\Api
 */
class RequestCreator
{
	/**
	 * @param array $params
	 * @return Request
	 */
	public static function createWithParameters($params = [])
	{
		return self::createCustomRequest($params);
	}

	/**
	 * @param array $get
	 * @param array $post
	 * @param array $attrs
	 * @param array $cookies
	 * @param array $files
	 * @param array $server
	 * @return Request
	 */
	private static function createCustomRequest($get = [], $post = [], $attrs = [], $cookies = [], $files = [], $server = [])
	{
		if (count($get) == 0) {
			$get = $_GET;
		}

		if (count($post) == 0) {
			$post = $_POST;
		}

		if (count($cookies) == 0) {
			$cookies = $_COOKIE;
		}

		if (count($files) == 0) {
			$files = $_FILES;
		}

		if (count($server) == 0) {
			$server = $_SERVER;
		}

		$requestUri = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_SERVER['REDIRECT_URL'];
		$requestQueryString = '';

		if (count($get) > 0) {
			$requestQueryString .= '?';

			foreach ($get as $paramKey => $paramValue) {
				preg_match(UriParser::getPattern(), $paramValue, $matches);

				if (count($matches) == 0) {
					$paramValue = sprintf('=%s', $paramValue);
				}

				$requestQueryString .= sprintf('%s%s', $paramKey, $paramValue) . '&';
			}
		}

		if (substr($requestQueryString, -1) == '&') {
			$requestQueryString = substr($requestQueryString, 0, strlen($requestQueryString) - 1);
		}

		$server['REQUEST_URI'] = $requestUri . $requestQueryString;

		return new Request($get, $post, $attrs, $cookies, $files, $server);
	}
}