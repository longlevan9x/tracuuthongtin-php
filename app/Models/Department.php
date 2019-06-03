<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Department
 *
 * @package App\Models
 * @property int                                  code
 * @property int                                  total_student
 * @mixin \Eloquent
 * @property int|null                             $is_active trang thai hoat dong
 * @property Carbon|null                          $created_at
 * @property Carbon|null                          $updated_at
 * @method static Builder|Department whereCreatedAt($value)
 * @method static Builder|Department whereId($value)
 * @method static Builder|Department whereIsActive($value)
 * @method static Builder|Department whereName($value)
 * @method static Builder|Department whereUpdatedAt($value)
 * @property int                                  $id
 * @property string                               $name
 * @property-read Admins                          $author
 * @property-read Admins                          $authorUpdated
 * @property-read Collection|\App\Models\Course[] $course
 * @method static Builder|Department active($value = 1)
 * @method static Builder|Department findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|Department inActive()
 * @method static Builder|Department myPluck($column, $key = null, $title = '')
 * @method static Builder|Department orderBySortOrder()
 * @method static Builder|Department orderBySortOrderDesc()
 * @method static Builder|Department whereSlug($slug)
 * @property int|null $school_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Relationship[] $relationships
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department postTime($time = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereSchoolId($value)
 */
class Department extends Model
{
	use ModelTrait;
	/**
	 * @var array
	 */
	protected $fillable = ['name', 'is_active'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function course() {
		return $this->hasMany(Course::class);
	}
}
