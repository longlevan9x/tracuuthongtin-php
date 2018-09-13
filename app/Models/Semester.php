<?php

namespace App\Models;

use App\Commons\CConstant;
use App\Crawler\LichHoc;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Yadakhov\InsertOnDuplicateKey;

/**
 * Class Semester
 * @package App\Models
 * @property string $name
 * @property int $is_active
 * @mixin \Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Semester whereCreatedAt($value)
 * @method static Builder|Semester whereId($value)
 * @method static Builder|Semester whereIsActive($value)
 * @method static Builder|Semester whereName($value)
 * @method static Builder|Semester whereUpdatedAt($value)
 */
class Semester extends Model
{
	use InsertOnDuplicateKey;
	/**
	 * @var array
	 */
	protected $fillable = ['name', 'is_active'];

	/**
	 * @throws \Exception
	 */
	public function syncSemester() {
		$lichHoc = new LichHoc(false, 1);
		$dotList = $lichHoc->getDot()->getDotList();
		$data    = [];
		foreach($dotList as $index => $item) {
			$data[] = [
				'name'       => $item,
				'is_active'  => CConstant::STATE_ACTIVE,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];
		}

		self::insertOnDuplicateKey($data);
		$syncHistory               = new SyncHistory();
		$syncHistory->name         = Student::getTableName();
		$syncHistory->type         = 'web';
		$syncHistory->total_record = count($data);
		$syncHistory->status       = CConstant::STATE_ACTIVE;
		$syncHistory->save();
	}
}
