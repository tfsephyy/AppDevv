<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'read',
        'related_id',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'user_id');
    }

    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }
}
