<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'archived',
        'is_posted',
        'images',
        'is_public'
    ];

    protected $casts = [
        'archived' => 'boolean',
        'is_posted' => 'boolean',
        'is_public' => 'boolean',
        'images' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function likes()
    {
        return $this->hasMany(JournalLike::class);
    }

    public function comments()
    {
        return $this->hasMany(JournalComment::class)->orderBy('created_at', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(UserAccount::class, 'user_id');
    }
}
