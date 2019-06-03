<?php

namespace App\Models;

use App\Crawler\Helper;
use App\Crawler\LichThi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Yadakhov\InsertOnDuplicateKey;

/**
 * App\Models\StudentScheduleExam
 *
 * @mixin \Eloquent
 * @property int         $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|StudentScheduleExam whereCreatedAt($value)
 * @method static Builder|StudentScheduleExam whereId($value)
 * @method static Builder|StudentScheduleExam whereUpdatedAt($value)
 * @property string $student_code
 * @property string $schedule_exam_code
 * @method static Builder|StudentScheduleExam whereScheduleExamCode($value)
 * @method static Builder|StudentScheduleExam whereStudentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentScheduleExam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentScheduleExam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StudentScheduleExam query()
 */
class StudentScheduleExam extends Model
{
	use InsertOnDuplicateKey;

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = ['student_code', 'schedule_exam_code'];

	/**
	 * @param $department_code
	 * @throws \Exception
	 */
	public function syncStudentScheduleExamByDepartment($department_code) {
		/** @var Department $department */
		$department = Department::where(['code' => $department_code])->first();
		if (isset($department) && !empty($department)) {
			$students = Student::select(['id', 'code'])->where(['id_department' => $department->id])->get()->toArray();

			set_time_limit(0);
			$studentScheduleExams = [];

			$lichHoc       = new LichThi;
			$msv           = $department->code;
			$total_student = $department->total_student;

			$code_student_list = array_column($students, 'code');
			$id_student_list   = array_column($students, 'id');

			for ($index = 1; $index <= $total_student; $index++) {
				$lichHoc->msv = Helper::getMsv($msv, $index);

				$key_msv    = array_search($lichHoc->msv, $code_student_list); // return key of array
				$id_student = $id_student_list[$key_msv];

				$scheduleExam = $lichHoc->getLichThi('3 (2017 - 2018)')->asArray();

				$code_class_list = array_column($scheduleExam, 'code');
				$scheduleExams   = ScheduleExam::select(['id', 'code'])->whereIn('code', $code_class_list)->get()->toArray();

				foreach ($scheduleExams as $key_s => $scheduleExam) {
					$studentScheduleExams[] = [
						'student_id'       => $id_student,
						'schedule_exam_id' => $scheduleExam['id'],
						'created_at'       => date('Y-m-d H:i:s'),
						'updated_at'       => date('Y-m-d H:i:s'),
					];
				}
			}
			//            echo "<pre>";
			//            print_r($studentScheduleExams);
			//            die;
			StudentScheduleExam::insertIgnore($studentScheduleExams);
		}
	}
}
