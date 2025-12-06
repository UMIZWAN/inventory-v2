<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SType extends Model
{
    protected $table = 's_types';

    protected $fillable = [
        'name',
        'is_active',
    ];
}
