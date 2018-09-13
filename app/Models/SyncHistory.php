<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class SyncHistory
 * @package App\Models
 * @property string      name
 * @property integer     status
 * @property string      total_record
 * @property string      type
 * @mixin Eloquent
 * @property int         $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SyncHistory whereCreatedAt($value)
 * @method static Builder|SyncHistory whereId($value)
 * @method static Builder|SyncHistory whereName($value)
 * @method static Builder|SyncHistory whereStatus($value)
 * @method static Builder|SyncHistory whereTotalRecord($value)
 * @method static Builder|SyncHistory whereType($value)
 * @method static Builder|SyncHistory whereUpdatedAt($value)
 */
class SyncHistory extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = ['table', 'status', 'total_record', 'type'];

	/**
	 * @var string
	 */
	protected $table = 'sync_history';
}
