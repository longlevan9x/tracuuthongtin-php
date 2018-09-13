<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Area
 *
 * @mixin \Eloquent
 */
class Area extends Model
{
    protected $fillable = ['code', 'name', 'is_active'];
}
