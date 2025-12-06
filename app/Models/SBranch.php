<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SBranch extends Model
{
    protected $table = 's_branch';

    protected $fillable = [
        'name',
        's_department_id',
        'is_active',
    ];
}
