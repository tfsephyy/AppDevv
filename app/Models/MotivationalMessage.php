<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivationalMessage extends Model
{
    protected $fillable = [
        'message',
        'archived',
    ];

    protected $casts = [
        'archived' => 'boolean',
    ];
}
