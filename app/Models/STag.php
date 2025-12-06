<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class STag extends Model
{
    protected $table = 's_tag';

    protected $fillable = [
        'name',
        'is_active',
    ];
}
