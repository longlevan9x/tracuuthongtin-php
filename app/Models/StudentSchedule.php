<?php

namespace App\Models;

use App\Commons\CConstant;
use App\Crawler\Helper;
use App\Crawler\LichHoc;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yadakhov\InsertOnDuplicateKey;

/**
 * Class StudentSchedule
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int         $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StudentSchedule whereCreatedAt($value)
 * @method static Builder|StudentSchedule whereId($value)
 * @method static Builder|StudentSchedule whereUpdatedAt($value)
 * @property string      $student_code
 * @property string      $schedule_code
 * @method static Builder|StudentSchedule whereScheduleCode($value)
 * @method static Builder|StudentSchedule whereStudentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentSchedule query()
 */
class StudentSchedule extends Model
{
	use InsertOnDuplicateKey;
	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['student_code', 'schedule_code'];

	public function schedules() {
		//return $this->
	}
}
