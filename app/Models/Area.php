<?php

namespace App\Models;

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
 */
class Area extends Model
{
	protected $fillable = ['code', 'name', 'is_active'];
}
