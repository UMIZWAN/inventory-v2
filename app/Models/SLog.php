<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SLog extends Model
{
    protected $table = 's_logs';

    protected $fillable = [
        'text',
    ];
}
