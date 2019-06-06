<?php

namespace App\Models;

use App\Commons\CRequest;
use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Pika\Api\Traits\UriParserTrait;
use Yadakhov\InsertOnDuplicateKey;

/**
 * Class Student
 * @package App\Models
 * @property-read Department                                                          $department
 * @property-read Collection                                                          $schedule_exams
 * @property-read Collection                                                          $schedules
 * @mixin \Eloquent
 * @property int                                                                      $id
 * @property int|null                                                                 id_course           khoa hoc
 * @property Carbon|null                                                              $created_at
 * @property Carbon|null                                                              $updated_at
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
 * @property int|null                                                                 $course_id          khoa hoc
 * @property-read Collection|ScheduleExam[]                                           $scheduleExams
 * @method static Builder|Student whereCourseId($value)
 * @method static Builder|Student whereDepartmentId($value)
 * @property string                                                                   $code
 * @property string                                                                   $name
 * @property string|null                                                              $class
 * @property string|null                                                              $branch_group       Nganh
 * @property string|null                                                              $branch             Chuyen nganh
 * @property string|null                                                              $status             trang thai
 * @property string|null                                                              $day_admission      ngay vao truong
 * @property string|null                                                              $school_year        nien khoa
 * @property int|null                                                                 $department_id      khoa
 * @property string|null                                                              $education_level    bac dao tao
 * @property string|null                                                              $gender             gioi tinh
 * @property string|null                                                              $type_education     Loai hinh dao tao
 * @property int|null                                                                 $area               Co so:10->hanoi, 20->namdinh
 * @property int|null                                                                 $total_term         tong so tin chi
 * @property-read \App\Models\Admins                                                  $author
 * @property-read \App\Models\Admins                                                  $authorUpdated
 * @property-read \App\Models\Course                                                  $course
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student active($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student inActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student myPluck($column, $key = null, $title = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student orderBySortOrder()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student orderBySortOrderDesc()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student whereSlug($slug)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Relationship[] $relationships
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student postTime($time = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student query()
 * @property string|null                                                              $gpa_10             trung binh tich luy he 10
 * @property string|null                                                              $gpa_4              trung binh tich luy he 4
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student whereGpa10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Student whereGpa4($value)
 */
class Student extends Model
{
	use ModelTrait;
	use InsertOnDuplicateKey;
	use UriParserTrait;

	/**
	 * @var array
	 */
	protected $fillable = [
		'code',
		'name',
		'class',
		'department_id',
		'branch_group',
		'course_id',
		'branch',
		'status',
		'day_admission',
		'school_year',
		'gender',
		'type_education',
		'area',
		'gpa_10',
		'gpa_4',
		'total_term'
	];

	protected $hidden = ['area'];
	//protected $appends = ['department', 'course'];

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
	 * @return Collection|BelongsToMany
	 */
	public function schedules() {
		$semester = $this->getSemester()->name ?? '';

		return $this->belongsToMany(Schedule::class, StudentSchedule::getTableName(), 'student_code', 'schedule_code', 'code', 'code')->where(['semester' => $semester]);
	}

	/**
	 * @return Collection|BelongsToMany
	 */
	public function scheduleExams() {
		$semester = $this->getSemester()->name ?? '';

		return $this->belongsToMany(ScheduleExam::class, StudentScheduleExam::getTableName(), 'student_code', 'schedule_exam_code', 'code', 'code')->where(['semester' => $semester]);
	}

	public function getArea() {
		return $this->hasOne(Area::class, 'code', 'area');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function department() {
		return $this->belongsTo(Department::class);
	}

	public function course() {
		return $this->belongsTo(Course::class);
	}

	/**
	 * @return mixed
	 */
	public function getDepartmentAttribute() {
		return $this->department()->first()->name ?? '';
	}

	public function getCourseAttribute() {
		return (int) $this->course()->first()->year ?? 0;
	}

	/**
	 * The attributes that should be cast to native types.
	 * @var array
	 */
	protected $casts = [
		'code'       => 'string',
		'course'     => 'integer',
		'area'       => 'integer',
		'gpa_10'     => 'float',
		'gpa_4'      => 'float',
		'total_term' => 'integer',
		'course_id' => 'integer',
		'department_id' => 'integer',
		'is_active' => 'integer',
	];

	protected $area_name = '';
	public function getAreaNameAttribute() {

		return $this->area == 10 ? "Hà Nội" : "Nam Định";
	}

	protected $appends = ['area_name'];

	/**
	 * @return array
	 */
	public function toArray() {

//		$this->setUriApiAppends(['department', 'course']);
        $this->gpa_10 = number_format($this->gpa_10, 2, '.', '');
        $this->gpa_4 = number_format($this->gpa_4, 2, '.', '');
		return parent::toArray(); // TODO: Change the autogenerated stub
	}

	public function getSemester($name = '') {
		/** @var Semester $query */
		$query = Semester::query();
		if (!empty($name)) {
			$query->whereName($name);
		}

		return $query->limit(1)->orderBy('sort_order', 'DESC')->first();
	}
}
