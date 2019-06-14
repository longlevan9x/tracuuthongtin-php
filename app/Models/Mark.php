<?php

namespace App\Models;

use App\Models\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class Mark extends Model
{
    use ModelTrait;
    use InsertOnDuplicateKey;

    protected $fillable = ['student_code', 'semester', 'name_subject', 'code_class', 'credit', 'mark_average', 'mark_training', 'mark_exam', 'mark_exam2', 'mark_average_subject', 'coefficient1', 'coefficient2', 'mark_practice', 'degree', 'exam_foul', 'note'];
}
