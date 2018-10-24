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
 */
class StudentSchedule extends Model
{
	use InsertOnDuplicateKey;
	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['student_code', 'schedule_code'];

	/**
	 * @param $department_code
	 * @throws \Exception
	 */
	public function syncStudentScheduleByDepartment($department_code) {
		/** @var Department $department */
		$department = Department::where(['code' => $department_code])->first();
		if (isset($department) && !empty($department)) {
			$students = Student::select(['id', 'code'])->where(['id_department' => $department->id])->get()->toArray();

			set_time_limit(0);
			$studentSchedules = [];

			$lichHoc       = new LichHoc;
			$msv           = $department->code;
			$total_student = $department->total_student;

			$code_student_list = array_column($students, 'code');
			$id_student_list   = array_column($students, 'id');

			for ($index = 1; $index <= $total_student; $index++) {
				$lichHoc->msv = Helper::getMsv($msv, $index);

				$key_msv    = array_search($lichHoc->msv, $code_student_list); // return key of array
				$id_student = $id_student_list[$key_msv];

				$schedule = $lichHoc->getLichHoc()->asArray();

				$code_class_list = array_column($schedule, 'code');
				$schedules       = Schedule::select(['id', 'code'])->whereIn('code', $code_class_list)->get()->toArray();

				foreach ($schedules as $key_s => $schedule) {
					$studentSchedules[] = [
						'student_id'  => $id_student,
						'schedule_id' => $schedule['id'],
						'created_at'  => date('Y-m-d H:i:s'),
						'updated_at'  => date('Y-m-d H:i:s'),
					];
				}
			}
			//            echo "<pre>";
			//            print_r($studentSchedules);
			//            die;
			StudentSchedule::insertIgnore($studentSchedules);
			$syncHistory               = new CrawlHistory;
			$syncHistory->name         = StudentSchedule::getTableName();
			$syncHistory->type         = 'web';
			$syncHistory->total_record = count($studentSchedules);
			$syncHistory->status       = CConstant::STATUS_SUCCESS;
			$syncHistory->save();
			//            DB::table('student_schedules')->insert($studentSchedules);
		}
	}
}
