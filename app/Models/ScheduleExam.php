<?php

namespace App\Models;

use App\Crawler\Helper;
use App\Crawler\LichThi;
use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yadakhov\InsertOnDuplicateKey;

/**
 * App\Models\ScheduleExam
 *
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
 * @property-read \App\Models\Admins $author
 * @property-read \App\Models\Admins $authorUpdated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScheduleExam active($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScheduleExam findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScheduleExam inActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScheduleExam myPluck($column, $key = null, $title = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScheduleExam orderBySortOrder()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScheduleExam orderBySortOrderDesc()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ScheduleExam whereSlug($slug)
 */
class ScheduleExam extends Model
{
	use ModelTrait;
	use InsertOnDuplicateKey;
	protected $fillable = ['code', 'name', 'group', 'test_day', 'examination', 'room', 'type', 'note', 'is_active'];
}
