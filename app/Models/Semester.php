<?php

namespace App\Models;

use App\Commons\CConstant;
use App\Crawler\LichHoc;
use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Yadakhov\InsertOnDuplicateKey;

/**
 * Class Semester
 *
 * @package App\Models
 * @property string      $name
 * @property int         $is_active
 * @mixin \Eloquent
 * @property int         $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Semester whereCreatedAt($value)
 * @method static Builder|Semester whereId($value)
 * @method static Builder|Semester whereIsActive($value)
 * @method static Builder|Semester whereName($value)
 * @method static Builder|Semester whereUpdatedAt($value)
 * @property-read \App\Models\Admins $author
 * @property-read \App\Models\Admins $authorUpdated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester active($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester inActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester myPluck($column, $key = null, $title = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester orderBySortOrder()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester orderBySortOrderDesc()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester whereSlug($slug)
 */
class Semester extends Model
{
	use  ModelTrait;
	use InsertOnDuplicateKey;
	/**
	 * @var array
	 */
	protected $fillable = ['name', 'is_active'];
}
