<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 07/11/2018
 * Time: 00:48
 */

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection;

/**
 * Trait ModelMethodTrait
 * @package App\Models\Traits
 * @method  static Builder whereId(int | string $id)
 * @method  static Builder whereIsActive(int $value)
 * @see     Builder
 * @see     QueryBuilder
 */
trait ModelMethodTrait
{
	/**
	 * @param  QueryBuilder $query
	 * @param int           $value
	 * @return QueryBuilder
	 */
	public function scopeActive($query, $value = 1) {
		return $query->where('is_active', $value);
	}

	/**
	 * @param QueryBuilder $query
	 * @return QueryBuilder
	 */
	public function scopeInActive($query) {
		return $this->scopeActive($query, 0);
	}

	/**
	 * @param QueryBuilder $query
	 * @return QueryBuilder
	 */
	public function scopeOrderBySortOrder($query) {
		return $query->orderBy('sort_order');
	}

	/**
	 * @param QueryBuilder $query
	 * @return QueryBuilder
	 */
	public function scopeOrderBySortOrderDesc($query) {
		return $query->orderByDesc('sort_order');
	}

	public function scopeMyPluck($query, $column, $key = null, $title = '') {
		$models = $query->pluck($column, $key);
		/** @var Collection $models */
		$models->put(0, __('admin.select') . " " . $title);
		$models = $models->toArray();
		ksort($models, SORT_STRING);
		//dd($models);
		return new Collection($models);
	}
}