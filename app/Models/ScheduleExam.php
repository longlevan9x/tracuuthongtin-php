<?php

namespace App\Models;

use App\Crawler\LichThi;
use App\Helpers\Facade\Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yadakhov\InsertOnDuplicateKey;

/**
 * App\Models\ScheduleExam
 * @mixin \Eloquent
 * @property int         $id
 * @property string      $code        ma lop hoc phan
 * @property string      $name        ten mon thi
 * @property int|null    $group       nhom
 * @property string|null $test_day    ngay thi
 * @property string|null $serial      si so
 * @property string|null $semester    ky thi
 * @property string|null $examination tiet thi
 * @property string|null $room        phong thi
 * @property string|null $type        loai thi
 * @property string|null $note        ghi chu
 * @property int|null    $is_active   trang thai hoat dong
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|ScheduleExam whereCode($value)
 * @method static Builder|ScheduleExam whereCreatedAt($value)
 * @method static Builder|ScheduleExam whereExamination($value)
 * @method static Builder|ScheduleExam whereGroup($value)
 * @method static Builder|ScheduleExam whereId($value)
 * @method static Builder|ScheduleExam whereIsActive($value)
 * @method static Builder|ScheduleExam whereName($value)
 * @method static Builder|ScheduleExam whereNote($value)
 * @method static Builder|ScheduleExam whereRoom($value)
 * @method static Builder|ScheduleExam whereSemester($value)
 * @method static Builder|ScheduleExam whereSerial($value)
 * @method static Builder|ScheduleExam whereTestDay($value)
 * @method static Builder|ScheduleExam whereType($value)
 * @method static Builder|ScheduleExam whereUpdatedAt($value)
 */
class ScheduleExam extends Model
{
	use InsertOnDuplicateKey;
	protected $fillable = ['code', 'name', 'group', 'test_day', 'examination', 'room', 'type', 'note', 'is_active'];

	/**
	 * @param $department_code
	 * @throws \Exception
	 */
	public function syncScheduleExamByDepartment($department_code) {
		/** @var Department $department */
		$department = Department::where(['code' => $department_code])->first();
		if (isset($department) && !empty($department)) {
			set_time_limit(0);
			$scheduleExams = [];

			$lichThi       = new LichThi;
			$msv           = $department->code;
			$total_student = $department->total_student;
			//            $total_student = 200;

			for ($index = 1; $index <= $total_student; $index++) {
				$lichThi->msv  = Helper::getMsv($msv, $index);
				$scheduleExam  = $lichThi->getLichThi('3 (2017 - 2018)')->asArray();
				$scheduleExams += $scheduleExam;
			}

			//            echo "<pre>";
			//            print_r($scheduleExams);
			//            print_r(array_values($scheduleExams));
			//            die;
			ScheduleExam::insertOnDuplicateKey(array_values($scheduleExams));
		}
	}
}
