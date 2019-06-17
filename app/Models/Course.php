<?php

namespace App\Models;

use App\Models\Department;
use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Course
 *
 * @package App\Models
 * @property-read Department $department
 * @mixin \Eloquent
 * @property int             $id
 * @property string|null     $code
 * @property string          $name
 * @property int|null        $id_department
 * @property int|null        $total_student
 * @property int|null        $is_active trang thai hoat dong
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 * @method static Builder|Course whereCode($value)
 * @method static Builder|Course whereCreatedAt($value)
 * @method static Builder|Course whereId($value)
 * @method static Builder|Course whereIdDepartment($value)
 * @method static Builder|Course whereIsActive($value)
 * @method static Builder|Course whereName($value)
 * @method static Builder|Course whereTotalStudent($value)
 * @method static Builder|Course whereUpdatedAt($value)
 * @property int|null $department_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereDepartmentId($value)
 * @property int|null $year
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course query()
 * @property-read \App\Models\Admins $author
 * @property-read \App\Models\Admins $authorUpdated
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Relationship[] $relationships
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course active($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course inActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course myPluck($column, $key = null, $title = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course orderBySortOrder()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course orderBySortOrderDesc()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course postTime($time = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereSlug($slug)
 */
class Course extends Model
{
	use ModelTrait;
	/**
	 * @var array
	 */
	protected $fillable = ['code', 'department_id', 'name', 'total_student', 'is_active'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function department() {
		return $this->belongsTo(Department::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function students() {
		return $this->hasMany(Student::class);
	}
}
