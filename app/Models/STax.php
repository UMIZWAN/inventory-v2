<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class STax extends Model
{
    protected $table = 's_tax';

    protected $fillable = [
        'tax_name',
        'tax_percentage',
    ];
}
