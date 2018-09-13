<?php

namespace App\Models;

use App\Commons\CConstant;
use App\Crawler\LichHoc;
use App\Helpers\Facade\Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\FileHelpers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yadakhov\InsertOnDuplicateKey;

/**
 * App\Models\Schedule
 * @mixin \Eloquent
 * @property int         $id
 * @property string      $code       ma lop hoc phan
 * @property string|null $name       ten mon hoc
 * @property string|null $semester   hoc ky
 * @property string|null $lesson     tiet hoc
 * @property string|null $start_time thoi gian bat dau
 * @property string|null $end_time   thoi gian ket thuc
 * @property string|null $weekday    ngay trong tuan
 * @property string|null $session    ca hoc
 * @property string|null $teacher    giang vien
 * @property string|null $classroom  phòng học
 * @property int|null    $is_active  trang thai hoat dong
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Schedule whereClassroom($value)
 * @method static Builder|Schedule whereCode($value)
 * @method static Builder|Schedule whereCreatedAt($value)
 * @method static Builder|Schedule whereEndTime($value)
 * @method static Builder|Schedule whereId($value)
 * @method static Builder|Schedule whereIsActive($value)
 * @method static Builder|Schedule whereLesson($value)
 * @method static Builder|Schedule whereName($value)
 * @method static Builder|Schedule whereSemester($value)
 * @method static Builder|Schedule whereSession($value)
 * @method static Builder|Schedule whereStartTime($value)
 * @method static Builder|Schedule whereTeacher($value)
 * @method static Builder|Schedule whereUpdatedAt($value)
 * @method static Builder|Schedule whereWeekday($value)
 */
class Schedule extends Model
{
	use InsertOnDuplicateKey;

	protected $fillable = ['code', 'name', 'semester', 'lesson', 'start_time', 'end_time', 'weekday', 'session', 'teacher', 'classroom', 'is_active'];

	/**
	 * @param $department_code
	 * @throws \Exception
	 */
	public function syncScheduleByDepartment($department_code) {
		/** @var Department $department */
		$department = Department::where(['code' => $department_code])->first();
		if (isset($department) && !empty($department)) {
			set_time_limit(0);
			$schedules = [];

			$lichHoc       = new LichHoc;
			$msv           = $department->code;
			$total_student = $department->total_student;
			//            $total_student = 200;

			for ($index = 1; $index <= $total_student; $index++) {
				$lichHoc->msv = Helper::getMsv($msv, $index);
				$schedule     = $lichHoc->getLichHoc()->asArray();
				$schedules    += $schedule;
			}

			//            echo "<pre>";
			//            print_r(array_values($schedules));
			//            print_r($schedules);
			//            die;
			Schedule::insertOnDuplicateKey(array_values($schedules));

			$syncHistory               = new SyncHistory;
			$syncHistory->name         = Schedule::getTableName();
			$syncHistory->type         = 'web';
			$syncHistory->total_record = count($schedules);
			$syncHistory->status       = CConstant::STATE_ACTIVE;
			$syncHistory->save();
		}
	}
}
