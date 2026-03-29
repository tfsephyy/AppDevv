<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'read',
        'related_id',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];
}
