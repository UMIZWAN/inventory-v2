<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SGroup extends Model
{
    protected $table = 's_group';

    protected $fillable = [
        'name',
        'is_active',
    ];
}
