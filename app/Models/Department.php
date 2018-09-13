<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * @package App\Models
 * @property int    code
 * @property string name
 * @property int    total_student
 * @property int    id
 * @mixin \Eloquent
 * @property int|null $is_active trang thai hoat dong
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Department whereCreatedAt($value)
 * @method static Builder|Department whereId($value)
 * @method static Builder|Department whereIsActive($value)
 * @method static Builder|Department whereName($value)
 * @method static Builder|Department whereUpdatedAt($value)
 */
class Department extends Model
{
	//
	/**
	 * @var array
	 */
	protected $fillable = ['name', 'is_active'];
}
