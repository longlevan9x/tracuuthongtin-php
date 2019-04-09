<?php

namespace App\Models;


use App\Models\Traits\ModelTrait;
use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Yadakhov\InsertOnDuplicateKey;

/**
 * App\Models\Schedule
 *
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
 * @property-read \App\Models\Admins $author
 * @property-read \App\Models\Admins $authorUpdated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule active($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule inActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule myPluck($column, $key = null, $title = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule orderBySortOrder()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule orderBySortOrderDesc()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schedule whereSlug($slug)
 */
class Schedule extends Model
{
	use ModelTrait;
	use InsertOnDuplicateKey;
    use EloquentJoin;

	protected $fillable = ['code', 'name', 'semester', 'lesson', 'start_time', 'end_time', 'weekday', 'session', 'teacher', 'classroom', 'is_active'];

	public function studentSchedules() {
	    return $this->hasMany(StudentSchedule::class, 'schedule_code', 'code');
    }
}
