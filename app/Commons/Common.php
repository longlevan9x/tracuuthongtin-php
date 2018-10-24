<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 6/28/2018
 * Time: 11:20 AM
 */

namespace App\Commons;


class Common
{
	/**
	 * @param string $app_name
	 * @return mixed
	 */
	public function showAppName($app_name = '') {
		return str_replace('_', ' ', $app_name);
	}

	/**
	 * @param        $relate
	 * @param        $field
	 * @param string $default_value
	 * @return string|int|array
	 */
	public function getRelateField($relate, $field, $default_value = '') {
		return isset($relate) ? $relate->{$field} : $default_value;
	}
}