<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

/**
 * App\Models\MoneyPay
 *
 * @property int $id
 * @property string $student_code
 * @property string $code_money
 * @property string|null $content
 * @property int|null $number stt
 * @property int|null $credit Tín chỉ
 * @property string $money Số tiền
 * @property string $money_paid Đã nộp
 * @property string $money_deduct Khấu trừ
 * @property string $money_pay Công nợ
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admins $author
 * @property-read \App\Models\Admins $authorUpdated
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Relationship[] $relationships
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay active($value = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay inActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay myPluck($column, $key = null, $title = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay orderBySortOrder()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay orderBySortOrderDesc()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay postTime($time = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereCodeMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereMoneyDeduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereMoneyPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereMoneyPay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereStudentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyPay whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MoneyPay extends Model
{
	use ModelTrait;
	use InsertOnDuplicateKey;

	protected $fillable = ['student_code', 'code_money', 'content', 'number', 'credit', 'money', 'money_paid', 'money_deduct', 'money_pay', 'status'];
}
