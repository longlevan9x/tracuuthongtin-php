<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class MoneyPay extends Model
{
	use ModelTrait;
	use InsertOnDuplicateKey;

	protected $fillable = ['student_code', 'code_money', 'content', 'number', 'credit', 'money', 'money_paid', 'money_deduct', 'money_pay', 'status'];
}
