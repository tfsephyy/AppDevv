<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToxicWord extends Model
{
    protected $fillable = [
        'word',
        'type',
        'language',
    ];
}
