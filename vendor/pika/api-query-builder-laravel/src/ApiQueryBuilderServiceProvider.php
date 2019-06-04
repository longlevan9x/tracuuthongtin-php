<?php
/**
 * Created by PhpStorm.
 * User: LongPC
 * Date: 10/25/2018
 * Time: 11:03
 */

namespace Pika\Api;

use Illuminate\Support\ServiceProvider;

/**
 * Class ApiQueryBuilderServiceProvider
 * @package Pika\Api
 */
class ApiQueryBuilderServiceProvider extends ServiceProvider
{
	/**
	 * Boot any application services.
	 * return void
	 */
	public function boot() {
		$this->publishes([
			__DIR__ . '/config.php' => config_path('api-query-builder.php'),
		]);
	}

	/**
	 * Register any application services.
	 */
	public function register() {
		$this->mergeConfigFrom(__DIR__ . '/config.php', 'api-query-builder');
	}
}
