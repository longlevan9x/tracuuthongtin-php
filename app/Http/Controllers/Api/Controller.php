<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;
use Pika\Api\QueryBuilder;

/**
 * Class Controller
 * @package App\Http\Api\Controllers
 */
class Controller extends \App\Http\Controllers\Controller
{
	/**
	 * @var Model $repository
	 */
	protected $repository;
}
