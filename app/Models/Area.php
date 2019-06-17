<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Area
 *
 * @mixin \Eloquent
 * @property int                             $id
 * @property string                          $code
 * @property string                          $name
 * @property int                             $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Area whereCode($value)
 * @method static Builder|Area whereCreatedAt($value)
 * @method static Builder|Area whereId($value)
 * @method static Builder|Area whereIsActive($value)
 * @method static Builder|Area whereName($value)
 * @method static Builder|Area whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area query()
 * @property-read \App\Models\Admins $author
 * @property-read \App\Models\Admins $authorUpdated
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Relationship[] $relationships
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area active($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area inActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area myPluck($column, $key = null, $title = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area orderBySortOrder()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area orderBySortOrderDesc()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area postTime($time = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereSlug($slug)
 */
class Area extends Model
{
	use ModelTrait;
	protected $fillable = ['code', 'name', 'is_active'];
}
