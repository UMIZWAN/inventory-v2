<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SSize extends Model
{
    protected $table = 's_sizes';

    protected $fillable = [
        'name',
        's_types_id',
        'is_active',
    ];
}
