<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

/**
 * App\Models\Mark
 * @property int                                                                      $id
 * @property string                                                                   $student_code
 * @property string|null                                                              $semester             hoc ky
 * @property string                                                                   $name_subject         Tên môn học
 * @property string                                                                   $code_class           Mã lớp
 * @property int|null                                                                 $credit               Tín chỉ
 * @property float|null                                                               $mark_average
 * @property float|null                                                               $mark_training        Điểm rèn luyện
 * @property float|null                                                               $mark_exam
 * @property float|null                                                               $mark_exam2
 * @property float|null                                                               $mark_average_subject Điểm trung bình thường kỳ
 * @property string|null                                                              $coefficient1
 * @property string|null                                                              $coefficient2
 * @property string|null                                                              $mark_practice
 * @property string|null                                                              $degree
 * @property string|null                                                              $exam_foul
 * @property string|null                                                              $note
 * @property \Illuminate\Support\Carbon|null                                          $created_at
 * @property \Illuminate\Support\Carbon|null                                          $updated_at
 * @property-read \App\Models\Admins                                                  $author
 * @property-read \App\Models\Admins                                                  $authorUpdated
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Relationship[] $relationships
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark active($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark inActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark myPluck($column, $key = null, $title = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark orderBySortOrder()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark orderBySortOrderDesc()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark postTime($time = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereCodeClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereCoefficient1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereCoefficient2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereExamFoul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereMarkAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereMarkAverageSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereMarkExam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereMarkExam2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereMarkPractice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereMarkTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereNameSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereStudentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Mark whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Mark extends Model
{
	use ModelTrait;
	use InsertOnDuplicateKey;

	protected $fillable = [
		'student_code',
		'semester',
		'name_subject',
		'code_class',
		'credit',
		'mark_average',
		'mark_training',
		'mark_exam',
		'mark_exam2',
		'mark_average_subject',
		'coefficient1',
		'coefficient2',
		'mark_practice',
		'degree',
		'exam_foul',
		'note'
	];

	/**
	 * The attributes that should be cast to native types.
	 * @var array
	 */
	protected $casts = [
		'code'                 => 'string',
		'credit'               => 'integer',
		'mark_average'         => 'float',
		'mark_training'        => 'float',
		'mark_exam'            => 'float',
		'mark_exam2'           => 'float',
		'mark_average_subject' => 'float',
	];

//	protected  $coefficient1 = [];
//	public function getCoefficient1Attribute() {
//		return explode(',',$this->coefficient1);
//	}
}
