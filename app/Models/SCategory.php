<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SCategory extends Model
{
    protected $table = 's_category';

    protected $fillable = [
        'name',
        's_types_id',
        'is_active',
    ];
}
