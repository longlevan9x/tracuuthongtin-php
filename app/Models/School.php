<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\School
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admins $author
 * @property-read \App\Models\Admins $authorUpdated
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Relationship[] $relationships
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School active($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School inActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School myPluck($column, $key = null, $title = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School orderBySortOrder()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School orderBySortOrderDesc()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School postTime($time = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class School extends Model
{
	use ModelTrait;

    protected $fillable = ['name', 'code', 'is_active'];
}
