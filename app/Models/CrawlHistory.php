<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class SyncHistory
 *
 * @package App\Models
 * @mixin Eloquent
 * @property int         $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CrawlHistory whereCreatedAt($value)
 * @method static Builder|CrawlHistory whereId($value)
 * @method static Builder|CrawlHistory whereName($value)
 * @method static Builder|CrawlHistory whereStatus($value)
 * @method static Builder|CrawlHistory whereTotalRecord($value)
 * @method static Builder|CrawlHistory whereType($value)
 * @method static Builder|CrawlHistory whereUpdatedAt($value)
 * @property string|null $name
 * @property int         $status
 * @property int         $total_record
 * @property string|null $type
 * @property-read Admins $author
 * @property-read Admins $authorUpdated
 * @method static Builder|CrawlHistory active($value = 1)
 * @method static Builder|CrawlHistory findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|CrawlHistory inActive()
 * @method static Builder|CrawlHistory myPluck($column, $key = null, $title = '')
 * @method static Builder|CrawlHistory orderBySortOrder()
 * @method static Builder|CrawlHistory orderBySortOrderDesc()
 * @method static Builder|CrawlHistory whereSlug($slug)
 * @property float|null $time
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrawlHistory whereTime($value)
 */
class CrawlHistory extends Model
{
	use ModelTrait;
	/**
	 * @var array
	 */
	protected $fillable = ['table', 'status', 'total_record', 'type', 'time'];
}
