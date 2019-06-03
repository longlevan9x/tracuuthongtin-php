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
 * @property-read Admins $author
 * @property-read Admins $authorUpdated
 * @method static Builder|Semester active($value = 1)
 * @method static Builder|Semester findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|Semester inActive()
 * @method static Builder|Semester myPluck($column, $key = null, $title = '')
 * @method static Builder|Semester orderBySortOrder()
 * @method static Builder|Semester orderBySortOrderDesc()
 * @method static Builder|Semester whereSlug($slug)
 * @property int|null    $sort_order
 * @method static Builder|Semester whereSortOrder($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Relationship[] $relationships
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester postTime($time = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Semester query()
 */
class Semester extends Model
{
	use  ModelTrait;
	use InsertOnDuplicateKey;
	/**
	 * @var array
	 */
	protected $fillable = ['name', 'is_active', 'sort_order'];
}
