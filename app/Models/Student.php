<?php

namespace App\Models;

use App\Commons\CConstant;
use App\Commons\CRequest;
use App\Crawler\ThongTinSinhVien;
use Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Yadakhov\InsertOnDuplicateKey;

/**
 * Class Student
 * @package App\Models
 * @property string          code
 * @property string          name
 * @property string          class
 * @property int             id_department
 * @property string          branch_group
 * @property string          branch
 * @property string          status
 * @property string          day_admission
 * @property string          school_year
 * @property int             course
 * @property int             gender
 * @property string          type_education
 * @property int             area
 * @property string          average_cumulative
 * @property int             total_term
 * @property-read Department $department
 * @property-read Collection $schedule_exams
 * @property-read Collection $schedules
 * @mixin \Eloquent
 * @property int             $id
 * @property string          $code
 * @property string          $name
 * @property string|null     $class
 * @property int|null        $id_course          khoa hoc
 * @property string|null     $branch_group       Nganh
 * @property string|null     $branch             Chuyen nganh
 * @property string|null     $status             trang thai
 * @property string|null     $day_admission      ngay vao truong
 * @property string|null     $school_year        nien khoa
 * @property int|null        $id_department      khoa
 * @property string|null     $education_level    bac dao tao
 * @property string|null     $gender             gioi tinh
 * @property string|null     $type_education     Loai hinh dao tao
 * @property int|null        $area               Co so:10->hanoi, 20->namdinh
 * @property string|null     $average_cumulative trung binh tich luy
 * @property int|null        $total_term         tong so tin chi
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 * @method static Builder|Student whereArea($value)
 * @method static Builder|Student whereAverageCumulative($value)
 * @method static Builder|Student whereBranch($value)
 * @method static Builder|Student whereBranchGroup($value)
 * @method static Builder|Student whereClass($value)
 * @method static Builder|Student whereCode($value)
 * @method static Builder|Student whereCreatedAt($value)
 * @method static Builder|Student whereDayAdmission($value)
 * @method static Builder|Student whereEducationLevel($value)
 * @method static Builder|Student whereGender($value)
 * @method static Builder|Student whereId($value)
 * @method static Builder|Student whereIdCourse($value)
 * @method static Builder|Student whereIdDepartment($value)
 * @method static Builder|Student whereName($value)
 * @method static Builder|Student whereSchoolYear($value)
 * @method static Builder|Student whereStatus($value)
 * @method static Builder|Student whereTotalTerm($value)
 * @method static Builder|Student whereTypeEducation($value)
 * @method static Builder|Student whereUpdatedAt($value)
 */
class Student extends Model
{
	use InsertOnDuplicateKey;

	/**
	 * @var array
	 */
	protected $fillable = [
		'code',
		'name',
		'class',
		'id_department',
		'branch_group',
		'branch',
		'status',
		'day_admission',
		'school_year',
		'course',
		'gender',
		'type_education',
		'area',
		'average_cumulative',
		'total_term'
	];

	protected $appends = ['department'];

	/**
	 * @return array
	 */
	public function getAppends() {
		$extraFields = CRequest::prepareExtraFields(['schedules', 'scheduleExams']);

		return $this->appends = $extraFields;
	}

	/**
	 * @return Collection
	 */
	public function getSchedulesAttribute() {
		return $this->schedules();
	}

	/**
	 * @return Collection
	 */
	public function getScheduleExamsAttribute() {
		return $this->scheduleExams();
	}

	/**
	 * @return Collection
	 */
	public function schedules() {
		$semester = $this->getSemester()->name ?? '';

		return $this->belongsToMany(Schedule::class, StudentSchedule::getTableName())->where(['semester' => $semester])->get();
	}

	/**
	 * @return Collection
	 */
	public function scheduleExams() {
		$semester = $this->getSemester()->name ?? '';

		return $this->belongsToMany(ScheduleExam::class, StudentScheduleExam::getTableName())->where(['semester' => $semester])->get();
	}

	public function getArea() {
		return $this->hasOne(Area::class, 'code', 'area');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function department() {
		return $this->hasOne(Department::class);
	}

	/**
	 * @return mixed
	 */
	public function getDepartmentAttribute() {
		return $this->department->name;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$this->getAppends();

		//        $this->area = $this->getArea()->name;

		return parent::toArray(); // TODO: Change the autogenerated stub
	}

	public function getSemester() {
		return Semester::limit(1)->orderBy('name', 'DESC')->first();
	}

	/**
	 * @param $department_code
	 * @throws \Exception
	 */
	public function syncStudentByDepartment($department_code) {
		/** @var Department $department */
		$department = Department::where(['code' => $department_code])->first();
		if (isset($department) && !empty($department)) {
			set_time_limit(0);
			$students = [];

			$infoStudent = new ThongTinSinhVien;

			$msv           = $department->code;
			$total_student = $department->total_student;
			//            $total_student = 5;

			for ($index = 1; $index <= $total_student; $index++) {
				$infoStudent->msv = Helper::getMsv($msv, $index);
				$student_info     = $infoStudent->getThongTinSinhVien()->asArray();
				if (!empty($student_info)) {
					if ($student_info['co_so'] == 'Hà Nội') {
						$coso = 10;
					}
					else {
						$coso = 20;
					}

					$students[] = [
						'code'               => $infoStudent->msv,
						'name'               => $student_info['name'],
						'status'             => $student_info['trang_thai'],
						'gender'             => $student_info['gioi_tinh'],
						'day_admission'      => $student_info['ngay_vao_truong'],
						'id_department'      => $department->id,
						'area'               => $coso,
						'education_level'    => $student_info['bac_dao_tao'],
						'type_education'     => $student_info['loai_hinh_dao_tao'],
						'branch_group'       => $student_info['nganh'],
						'branch'             => $student_info['chuyen_nganh'],
						'class'              => $student_info['lop'],
						'average_cumulative' => $student_info['diem_tb_tich_luy'],
						'school_year'        => $student_info['nien_khoa'],
						'total_term'         => $student_info['tong_so_tc_tich_luy'],
						'course'             => $student_info['khoa_hoc'],
						'created_at'         => date("Y-m-d H:i:s"),
						'updated_at'         => date("Y-m-d H:i:s"),
					];
				}

			}
			//            echo "<pre>";
			//            print_r($students);
			//            die;
			Student::insertOnDuplicateKey($students);
			$syncHistory               = new SyncHistory;
			$syncHistory->name         = Student::getTableName();
			$syncHistory->type         = 'web';
			$syncHistory->total_record = count($students);
			$syncHistory->status       = CConstant::STATE_ACTIVE;
			$syncHistory->save();
		}
	}

	/**
	 * @param $msv
	 * @throws \Exception
	 */
	public function syncStudent($msv) {
		$infoStudent  = new ThongTinSinhVien(true, $msv);
		$student_info = $infoStudent->getThongTinSinhVien()->asArray();

		$code = substr($msv, 0, 6);
		/** @var Department $department */
		$department = Department::where(['code' => $code])->first();
		if (!empty($student_info)) {
			if ($student_info['co_so'] == 'Hà Nội') {
				$coso = 10;
			}
			else {
				$coso = 20;
			}

			$students[] = [
				'code'               => $infoStudent->msv,
				'name'               => $student_info['name'],
				'status'             => $student_info['trang_thai'],
				'gender'             => $student_info['gioi_tinh'],
				'day_admission'      => $student_info['ngay_vao_truong'],
				'id_department'      => $department->id,
				'area'               => $coso,
				'education_level'    => $student_info['bac_dao_tao'],
				'type_education'     => $student_info['loai_hinh_dao_tao'],
				'branch_group'       => $student_info['nganh'],
				'branch'             => $student_info['chuyen_nganh'],
				'class'              => $student_info['lop'],
				'average_cumulative' => $student_info['diem_tb_tich_luy'],
				'school_year'        => $student_info['nien_khoa'],
				'total_term'         => $student_info['tong_so_tc_tich_luy'],
				'course'             => $student_info['khoa_hoc'],
				'created_at'         => time(),
				'updated_at'         => time()
			];
		}
	}
}
