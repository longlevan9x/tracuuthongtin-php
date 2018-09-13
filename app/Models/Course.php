<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 *
 * @package App\Models
 * @property-read \App\Models\Department $department
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $code
 * @property string $name
 * @property int|null $id_department
 * @property int|null $total_student
 * @property int|null $is_active trang thai hoat dong
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereIdDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereTotalStudent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereUpdatedAt($value)
 */
class Course extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = ['code', 'id_department', 'name', 'total_student', 'is_active'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function department() {
    	return $this->belongsTo(Department::class, 'id_department', 'id');
    }
}
